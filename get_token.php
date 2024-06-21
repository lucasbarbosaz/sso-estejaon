<?php

    require_once(__DIR__ . "/geral.php");

    function obterTokenCliente($token, $siteUrl) {
        global $db;
        global $JWT;

        //validar token
        if(!$JWT::validateJWT($token)) {
            echo json_encode(array(
                'code' => 400,
                'msg' => "Token inválido ou expirado"
            ));
            return;
        }


        $obterToken = $db->prepare("SELECT * FROM token WHERE access_token = ?");
        $obterToken->bindValue(1, $token);
        $obterToken->execute();

        if ($obterToken->rowCount() > 0) {
            $obterToken = $obterToken->fetch(PDO::FETCH_ASSOC);

            $obterUsuario = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $obterUsuario->bindValue(1, $obterToken['usuario_id']);
            $obterUsuario->execute();
            $obterUsuario = $obterUsuario->rowCount() > 0 ? $obterUsuario->fetch(PDO::FETCH_ASSOC) : null;

            if ($obterUsuario !== null ) {

                //verificar qual dos nossos sites é para retornar o usuario_data correto
                if (isset($siteUrl) ) {
                    if ($siteUrl == "127.0.0.2") {
                        //faça buscar a profile_data e salvar na array
                        $obterPerfil = $db->prepare("SELECT * FROM usuario_perfis WHERE usuario_id = ? AND site_id = ?");
                        $obterPerfil->bindValue(1, $obterUsuario['id']);
                        $obterPerfil->bindValue(2, 1);
                        $obterPerfil->execute();
                        $obterPerfil = $obterPerfil->rowCount() > 0 ? $obterPerfil->fetch(PDO::FETCH_ASSOC) : null;

                        $usuario_data = array(
                            
                            'id' => intval($obterUsuario['id']),
                            'nome' => $obterUsuario['nome'],
                            'email' => $obterUsuario['email'],
                            'senha' => $obterUsuario['senha'],
                            'telefone' => $obterUsuario['telefone'],
                            'role_id' => intval($obterUsuario['role_id']),
                            'role' => $obterUsuario['role'], //padrao
                            'profile_data' => json_decode($obterPerfil['profile_data'])
                        );
                    } else {
                        //padrao
                        $usuario_data = array(
                            'id' => intval($obterUsuario['id']),
                            'nome' => $obterUsuario['nome'],
                            'apelido' => $obterUsuario['apelido'],
                            'email' => $obterUsuario['email'],
                            'email_secundario' => $obterUsuario['email_secundario'],
                            'telefone' => $obterUsuario['telefone']
                        );
                    }
                } else {
                    echo json_encode(array(
                        'status_code' => 400,
                        'msg' => "Invalid"
                    ));
                    return;
                }
            }
        }

        $response = array();
        $response['status_code'] = 200;
        $response['usuario'] = $usuario_data;
        echo json_encode($response);
    }

    if (!empty($_GET['token'])) {
        echo obterTokenCliente($_GET['token'], $_GET['site']);
    } else {
        echo json_encode(array(
            'status_code' => 400,
            'msg' => "Invalid"
        ));
        return;
    }

?>