<?php
// Inclui o arquivo de configuração
require_once (__DIR__ . '/../../../../../geral.php');

header('Content-Type: application/json; charset=utf-8');


if (extract(($_POST))) {

    if (isset($_POST['type']) && $_POST['type'] == "email") {

        $email = (isset($_POST['email'])) ? $_POST['email'] : '';

        $email_existe = $db->prepare("SELECT email FROM usuarios WHERE email = ?");
        $email_existe->bindValue(1, $email);
        $email_existe->execute();

        if (!isset($email) || empty(trim($email))) {
            $response['error'] = true;
            $response["back"] = false;
            $response['message'] = "Email inválido";
            $response['input_error'] = "email-login";
            echo json_encode($response);
            exit;
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $response["error"] = true;
            $response["back"] = false;
            $response["message"] = "Insira um e-mail válido";
            $response['input_error'] = "email-login";
            echo json_encode($response);
            exit;
        } else if (!$email_existe->rowCount() > 0) {
            $response["error"] = true;
            $response["back"] = false;
            $response["message"] = "E-mail ou senha incorretos";
            $response['input_error'] = "email-login";
            echo json_encode($response);
            exit;
        } else {

            $response['success'] = true;
            echo json_encode($response);

        }
    } else if (isset($_POST['type']) && $_POST['type'] == "senha") {
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';

        if (!isset($senha) || empty($senha)) {
            $response['error'] = true;
            $response["back"] = false;
            $response['message'] = "Digite uma senha";

            echo json_encode($response);
            exit;
        } else {
            $obter_senha = $db->prepare("SELECT senha FROM usuarios WHERE email = ?");
            $obter_senha->bindValue(1, $email);
            $obter_senha->execute();
            $obter_senha = $obter_senha->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $obter_senha['senha'])) {

                $obter_usuario = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
                $obter_usuario->bindValue(1, $email);
                $obter_usuario->execute();
                $obter_usuario = $obter_usuario->fetch(PDO::FETCH_ASSOC);

                if (isset($_GET['redirect_url'])) {
                    $appUrl = $_GET['redirect_url'];


                    $obterSitesPermitidos = $db->prepare("SELECT url FROM host");
                    $obterSitesPermitidos->execute();
                    $urlsPermitidas = $obterSitesPermitidos->fetchAll(PDO::FETCH_COLUMN);

                    $obterHost = $Functions::getHostFromUrl($appUrl); //remover o path e o scheme

                    if (in_array($obterHost, $urlsPermitidas)) {
                        if (substr($appUrl, 0, 4) != "http") {
                            $source = parse_url("http://" . $appUrl);
                        } else {
                            $source = parse_url($appUrl);
                        }

                        if (isset($source['host'])) {
                            $header = [
                                'alg' => 'HS256',
                                'typ' => 'JWT'
                            ];

                            $payload = [
                                'iat' => time(),
                                'exp' => time() + (30 * 24 * 60 * 60), // expira em 30 dias
                                'sub' => $obter_usuario['id']
                            ];

                            $token = $JWT::generateJWT($header, $payload);

                            $scheme = isset($source['scheme']) ? $source['scheme'] : 'http';
                            $host = $source['host'];
                            $path = isset($source['path']) ? $source['path'] : '';

                            $target = $scheme . '://' . $host . $path;

                            $atualiza_ip = $db->prepare("UPDATE usuarios SET ultimo_ip = ? WHERE id = ?");
                            $atualiza_ip->bindValue(1, $Functions::IP());
                            $atualiza_ip->bindValue(2, $obter_usuario['id']);
                            $atualiza_ip->execute();
        
                            $removeTokenAntigo = $db->prepare("SELECT * FROM token WHERE usuario_id = ?");
                            $removeTokenAntigo->bindValue(1, $obter_usuario['id']);
                            $removeTokenAntigo->execute();
        
                            if ($removeTokenAntigo->rowCount() > 0) {
                                $removeTokenAntigo = $removeTokenAntigo->fetch(PDO::FETCH_ASSOC);
                                $delete = $db->prepare("DELETE FROM token WHERE access_token = ?");
                                $delete->bindValue(1, $removeTokenAntigo['access_token']);
                                $delete->execute();
                            }
        
                            $salvarToken = $db->prepare("INSERT INTO token (access_token, usuario_id) VALUES(?,?)");
                            $salvarToken->bindValue(1, $token);
                            $salvarToken->bindValue(2, $obter_usuario['id']);
                            $salvarToken->execute();

                            $_SESSION['token'] = $token;
                            $_SESSION['id'] = $obter_usuario['id'];
                            $_SESSION['nome'] = $obter_usuario['nome'];
                            $_SESSION['senha'] = $obter_usuario['senha'];
                            $_SESSION['apelido'] = $obter_usuario['apelido'];
                            $_SESSION['email'] = $obter_usuario['email'];
                            $_SESSION['email_secundario'] = $obter_usuario['email_secundario'];
                            $_SESSION['telefone'] = $obter_usuario['telefone'];

                            $response['success'] = true;
                            $response['redirect'] = true;
                            $response['location'] = $target . '?token=' . $token;
                            echo json_encode($response);
                        }
                    } else {
                        $response['error'] = true;
                        $response['url'] = "$obterHost";
                        $response['type'] = 'url_blocked';
                        echo json_encode($response);
                    }
                } else {

                    $header = [
                        'alg' => 'HS256',
                        'typ' => 'JWT'
                    ];

                    $payload = [
                        'iat' => time(),
                        'exp' => time() + (30 * 24 * 60 * 60), // expira em 30 dias
                        'sub' => $obter_usuario['id']
                    ];

                    $token = $JWT::generateJWT($header, $payload);

                    $atualiza_ip = $db->prepare("UPDATE usuarios SET ultimo_ip = ? WHERE id = ?");
                    $atualiza_ip->bindValue(1, $Functions::IP());
                    $atualiza_ip->bindValue(2, $obter_usuario['id']);
                    $atualiza_ip->execute();

                    $removeTokenAntigo = $db->prepare("SELECT * FROM token WHERE usuario_id = ?");
                    $removeTokenAntigo->bindValue(1, $obter_usuario['id']);
                    $removeTokenAntigo->execute();

                    if ($removeTokenAntigo->rowCount() > 0) {
                        $removeTokenAntigo = $removeTokenAntigo->fetch(PDO::FETCH_ASSOC);
                        $delete = $db->prepare("DELETE FROM token WHERE access_token = ?");
                        $delete->bindValue(1, $removeTokenAntigo['access_token']);
                        $delete->execute();
                    }

                    $salvarToken = $db->prepare("INSERT INTO token (access_token, usuario_id) VALUES(?,?)");
                    $salvarToken->bindValue(1, $token);
                    $salvarToken->bindValue(2, $obter_usuario['id']);
                    $salvarToken->execute();

                    $_SESSION['token'] = $token;
                    $_SESSION['id'] = $obter_usuario['id'];
                    $_SESSION['nome'] = $obter_usuario['nome'];
                    $_SESSION['senha'] = $obter_usuario['senha'];
                    $_SESSION['apelido'] = $obter_usuario['apelido'];
                    $_SESSION['email'] = $obter_usuario['email'];
                    $_SESSION['email_secundario'] = $obter_usuario['email_secundario'];
                    $_SESSION['telefone'] = $obter_usuario['telefone'];

                    $response['success'] = true;
                    echo json_encode($response);
                }


            } else {
                $response["error"] = true;
                $response['back'] = true;
                $response["message"] = "E-mail ou senha incorretos";
                $response["input_error"] = "senha-login";
                echo json_encode($response);
            }
        }
    }
}




?>