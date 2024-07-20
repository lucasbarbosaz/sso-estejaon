<?php
require_once('../../geral.php');

header('Content-Type: application/json; charset=utf-8');


if ($JWT::checkAuth()) {

    $postData = json_decode(file_get_contents("php://input"));

    $id = isset($postData->id) ? $postData->id : null;

    $usuarios = [];
    $redesSociais = [];

    if ($id) {
        $obterUsuarios = $db->prepare("SELECT * FROM usuarios WHERE id = ? AND role_id = ?");
        $obterUsuarios->bindValue(1, $id);
        $obterUsuarios->bindValue(2, 2);
        $obterUsuarios->execute();

        if ($obterUsuarios->rowCount() == 0) {
            $response['error'] = 'Usuário não encontrado';
            echo json_encode($response);
            exit;
        }

        while ($usuario = $obterUsuarios->fetch(PDO::FETCH_ASSOC)) {

            array_push($usuarios, array(
                'id' => $usuario['id'],
                'name' => $usuario['nome'],
                'email' => $usuario['email'],
                'telefone' => $usuario['telefone'],
                'redes_sociais' => $usuario['redes_sociais'],
                'role_id' => $usuario['role_id']

            ));
        }

        echo json_encode($usuarios[0]);
        return;
    } else {

        $obterUsuarios = $db->prepare("SELECT * FROM usuarios WHERE role_id = ?");
        $obterUsuarios->bindValue(1, 2);
        $obterUsuarios->execute();


        while ($usuario = $obterUsuarios->fetch(PDO::FETCH_ASSOC)) {
            $obterRedesSociais = $db->prepare("SELECT profile_data FROM usuario_perfis WHERE usuario_id = ?");
            $obterRedesSociais->bindValue(1, $usuario['id']);
            $obterRedesSociais->execute();

            $redesSociais = $obterRedesSociais->fetchAll(PDO::FETCH_ASSOC);

            array_push($usuarios, array(
                'id' => $usuario['id'],
                'name' => $usuario['nome'],
                'email' => $usuario['email'],
                'telefone' => $usuario['telefone'],
                
                'redes_sociais' => array_map(function ($redeSocial) {
                    return json_decode($redeSocial['profile_data'], true);
                }, $redesSociais),
                'role_id' => $usuario['role_id']

            ));
        }
    }

    $response['data'] = $usuarios;
    echo json_encode($response);
}
