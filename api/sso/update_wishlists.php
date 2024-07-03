<?php
    header('Content-Type: application/json; charset=utf-8');

    if ($JWT::checkAuth()) {
        $usuario_id = $JWT::getUserIdFromToken();

        $postData = json_decode(file_get_contents("php://input"));

        $site_id = $postData->site_id;
        $wishlists = $postData->wishlists;

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
        }
    }
?>