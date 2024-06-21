<?php
require_once('../../geral.php');

header('Content-Type: application/json; charset=utf-8');

if ($JWT::checkAuth()) {
    $usuario_id = $JWT::getUserIdFromToken();

    $postData = json_decode(file_get_contents("php://input"));

    $site_id = $postData->site_id;
    $perfil = $postData->data;


    $verificaPerfil = $db->prepare("SELECT * FROM usuario_perfis WHERE usuario_id = ? AND site_id = ?");
    $verificaPerfil->bindValue(1, $usuario_id);
    $verificaPerfil->bindValue(2, $site_id);
    $verificaPerfil->execute();

    if ($verificaPerfil->rowCount() > 0) {
        $atualizaPerfil = $db->prepare("UPDATE usuario_perfis SET profile_data = ? WHERE usuario_id = ? AND site_id = ?");
        $atualizaPerfil->bindValue(1, json_encode($perfil));
        $atualizaPerfil->bindValue(2, $usuario_id);
        $atualizaPerfil->bindValue(3, $site_id);
        $atualizaPerfil->execute();

        if ($atualizaPerfil) {
            $response['success'] = true;
            $response['message'] = "Perfil atualizado com sucesso!";
            echo json_encode($response);
            exit();
        } else {
            $response['error'] = true;
            $response['message'] = "Erro ao atualizar perfil";
            echo json_encode($response);
            exit();
        }
    } else {
        $inserirPerfil = $db->prepare("INSERT INTO usuario_perfis (usuario_id, site_id, profile_data) VALUES (?, ?, ?)");
        $inserirPerfil->bindValue(1, $usuario_id);
        $inserirPerfil->bindValue(2, $site_id);
        $inserirPerfil->bindValue(3, json_encode($perfil));
        $inserirPerfil->execute();

        if ($inserirPerfil) {
            $response['success'] = true;
            $response['message'] = "Perfil atualizado com sucesso!";
            echo json_encode($response);
            exit();
        } else {
            $response['error'] = true;
            $response['message'] = "Erro ao atualizar perfil";
            echo json_encode($response);
            exit();
        }
    }
} else {
    //crie um arquivo com dados recebidos
    $file = fopen("data.txt", "w");
    fwrite($file, json_encode("oi"));
    fclose($file);
}
