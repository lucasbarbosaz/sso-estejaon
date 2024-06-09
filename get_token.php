<?php

    require_once(__DIR__ . "/geral.php");

    function obterTokenCliente($token) {
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

                $usuario_data = array(
                    'id' => intval($obterUsuario['id']),
                    'nome' => $obterUsuario['nome'],
                    'apelido' => $obterUsuario['apelido'],
                    'email' => $obterUsuario['email'],
                    'email_secundario' => $obterUsuario['email_secundario'],
                    'telefone' => $obterUsuario['telefone']
                );
            }
        }

        $response = array();
        $response['status_code'] = 200;
        $response['usuario'] = $usuario_data;
        echo json_encode($response);
    }

    if (!empty($_GET['token'])) {
        echo obterTokenCliente($_GET['token']);
    } else {
        echo json_encode(array(
            'code' => 400,
            'msg' => "Invalid"
        ));
    }

?>