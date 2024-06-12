<?php
require_once ("../../geral.php");

// Define a codificação como UTF-8
header('Content-Type: application/json; charset=utf-8');
if (extract($_POST)) {

    $response = array();

    if (isset($_POST['type']) && $_POST['type'] == "enviaremail") {
        $mail = (isset($_POST['email'])) ? $_POST['email'] : '';


        if (!isset($mail) || empty($mail)) {
            $response["error"] = true;
            $response["message"] = "Preencha o e-mail da conta";
            $response["input_error"] = "email";
            echo json_encode($response);
            exit;
        } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $response["error"] = true;
            $response["message"] = "Formato de e-mail inválido";
            $response["input_error"] = "email";
            echo json_encode($response);
            exit;
        } else {

            $email_existe = $db->prepare("SELECT email FROM usuarios WHERE email = ?");
            $email_existe->bindValue(1, $mail);
            $email_existe->execute();

            if ($email_existe->rowCount() > 0) {

                $obterUsuario = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
                $obterUsuario->bindValue(1, $mail);
                $obterUsuario->execute();
                $obterUsuario = $obterUsuario->fetch(PDO::FETCH_ASSOC);


                $ultimaRec = $db->prepare("SELECT timestamp FROM recuperasenha WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
                $ultimaRec->bindValue(1, $obterUsuario['id']);
                $ultimaRec->execute();

                $obterHora = $ultimaRec->rowCount() > 0 ? $ultimaRec->fetch()['timestamp'] : 0;

                if (($obterHora + (60 * 3)) > time()) {
                    $response["error"] = true;
                    $response["message"] = "Espere 3 minutos antes de solicitar um novo link de redefinição de senha.";
                    $response["input_error"] = "email";
                    echo json_encode($response);
                    exit;
                } else {


                    $key = sha1(microtime(true) . mt_rand(1000000, 9999999));

                    $inserir = $db->prepare("INSERT INTO recuperasenha (usuario_id, `key`, `registro_ip`, `ultimo_ip`, ativo,`timestamp`) VALUES (?, ?, ?, ?, ?, ?)");
                    $inserir->bindValue(1, $obterUsuario['id']);
                    $inserir->bindValue(2, $key);
                    $inserir->bindValue(3, $Functions::IP());
                    $inserir->bindValue(4, $Functions::IP());
                    $inserir->bindValue(5, '1');
                    $inserir->bindValue(6, time());
                    $inserir->execute();

                    if ($inserir->rowCount() > 0) {
                        $mailBody = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $emailConfig['recoveryPassword']);
                        $mailBody = str_replace('%site_name%', SITE_NAME, $mailBody);
                        $mailBody = str_replace('%usuario%', $obterUsuario['nome'], $mailBody);
                        $mailBody = str_replace('%keylink%', '<a href="' . SITE_URL . '/recuperar_senha/' . $key . '">' . SITE_URL . '/recuperar_senha/' . $key . '</a>', $mailBody);

                        $enviou = $Email::enviarEmail(strtolower($mail), "Redifinição de senha", $mailBody);

                        if (!$enviou) {
                            $response["error"] = true;
                            $response["message"] = "Algo deu errado! Tente novamente mais tarde.";
                            echo json_encode($response);
                            exit;
                        }
                    }

                }
            } else {
                $response["error"] = true;
                $response["message"] = "Algo deu errado! Tente novamente mais tarde.";
                echo json_encode($response);
                exit;
            }


            $response['success'] = true;
            $response['message'] = 'Se ' . $mail . ' for o e-mail utilizado na conta, um e-mail com um link de redefinição de senha acaba de ser enviado.';
            echo json_encode($response);

        }
    } else if (isset($_POST['type']) && $_POST['type'] == "redefinirsenha") {
        $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
        $senha2 = (isset($_POST['senha2'])) ? $_POST['senha2'] : '';

        if (!isset($key) || empty($key)) {
            $response["error"] = true;
            $response["message"] = "A chave de redefinição de senha não foi informada. <a href='/esqueceu'>Clique aqui para gerar um novo link</a>";
            $response["type"] = "undefined_key";
            echo json_encode($response);
            exit;
        } else if (!isset($senha) || empty($senha)) {
            $response["error"] = true;
            $response["message"] = "Informe a nova senha.";
            $response["type"] = "senha";
            $response["input_error"] = "passwordForgot";
            echo json_encode($response);
            exit;
        } else if (strlen($senha) < 6) {
            $response["error"] = true;
            $response["message"] = "A nova senha deve ter no mínimo 6 caracteres.";
            $response["type"] = "senha";
            $response["input_error"] = "passwordForgot";
            echo json_encode($response);
        } else if ($senha != $senha2) {
            $response["error"] = true;
            $response["message"] = "As senhas não conferem.";
            $response["type"] = "senha_diferente";
            $response["input_error"] = ["passwordForgot", "passwordForgot2"];
            echo json_encode($response);
            exit;
        } else {
            $key = (isset($_POST['key'])) ? $_POST['key'] : '';

            $resetar = $db->prepare('SELECT * FROM recuperasenha WHERE `key` = ?');
            $resetar->bindValue(1, $key);
            $resetar->execute();

            if ($resetar->rowCount() > 0) {
                $resetar = $resetar->fetch();

                if ($resetar['ativo'] == '1') {
                    $tempo = $resetar['timestamp'];

                    if (($tempo + (60 * 60 * 2)) < time()) {
                        $response["error"] = true;
                        $response["message"] = "Este link de redefinição de senha expirou.";
                        $response["type"] = "key_expired";
                        echo json_encode($response);
                        exit;
                    } else {
                        $desativar = $db->prepare('UPDATE recuperasenha SET ativo = "0", ultimo_ip = ? WHERE `key` = ?');
                        $desativar->bindValue(1, $Functions::IP());
                        $desativar->bindValue(2, $key);
                        $desativar->execute();

                        $atualizarUsuario = $db->prepare('UPDATE usuarios SET senha = ? WHERE id = ?');
                        $atualizarUsuario->bindValue(1, $Functions::criptografarSenha($senha));
                        $atualizarUsuario->bindValue(2, $resetar['usuario_id']);
                        $atualizarUsuario->execute();


                        $response['success'] = true;
                        $response['message'] = 'Senha alterada com sucesso!, faça login para atualizar sua senha.';
                        echo json_encode($response);

                    }
                } else {
                    $response["error"] = true;
                    $response["message"] = "Este link de redefinição de senha expirou.";
                    $response["type"] = "key_expired";
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response["error"] = true;
                $response["message"] = "Este link de redefinição de senha expirou.";
                $response["type"] = "key_expired";
                echo json_encode($response);
                exit;
            }
        }

    } else {
        echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
    }


} else {
    echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
}
?>