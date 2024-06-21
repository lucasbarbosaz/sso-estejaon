<?php
require_once('../../geral.php');


header('Content-Type: application/json; charset=utf-8');

$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $usuario_id = $JWT::getUserIdFromToken();

    $postData = json_decode(file_get_contents("php://input"));

    $senhaAntiga = $postData->old_password;
    $novaSenha = $postData->new_password;
    $confirmarSenha = $postData->confirm_password;

    $usuario = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
    $usuario->bindValue(1, $usuario_id);
    $usuario->execute();

    if ($usuario->rowCount() > 0) {
        $usuario = $usuario->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senhaAntiga, $usuario['senha'])) {
            if ($novaSenha != $senhaAntiga) {
                if ($novaSenha) {
                    if ($senhaAntiga) {
                        if (strlen($novaSenha) < 6) {
                            $response['error'] = true;
                            $response['message'] = "A nova senha deve conter pelo menos 6 caracteres";
                            echo json_encode($response);
                            exit();
                        }

                        if ($novaSenha != $confirmarSenha) {
                            $response['error'] = true;
                            $response['message'] = "As senhas não coincidem";
                            echo json_encode($response);
                            exit();
                        }

                        $novaSenha = password_hash($novaSenha, PASSWORD_BCRYPT);
                        $atualizarSenha = $db->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
                        $atualizarSenha->bindValue(1, $novaSenha);
                        $atualizarSenha->bindValue(2, $usuario_id);
                        $atualizarSenha->execute();

                        $response['success'] = true;
                        $response['message'] = "Senha alterada com sucesso!";
                        echo json_encode($response);
                        exit();
                    } else {
                        $response['error'] = true;
                        $response['message'] = "Senha atual não informada";
                        echo json_encode($response);
                        exit();
                    }
                } else {
                    $response['error'] = true;
                    $response['message'] = "Nova senha não informada";
                    echo json_encode($response);
                    exit();
                }
            } else {
                $response['error'] = true;
                $response['message'] = "A nova senha deve ser diferente da senha antiga";
                echo json_encode($response);
                exit();
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Senha atual incorreta";
            echo json_encode($response);
            exit();
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Usuário não encontrado";
        echo json_encode($response);
        exit();
    }
}
