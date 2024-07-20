<?php
require_once('../../geral.php');

header('Content-Type: application/json; charset=utf-8');

if ($JWT::checkAuth()) {

    $postData = json_decode(file_get_contents("php://input"));

    $type = $postData->type;

    if ($type == "admin_edit_user") {
        $usuario_id = $postData->data->id;
    } else if ($type == "edit_user") {
        $usuario_id = $JWT::getUserIdFromToken();
    }

    $name = $postData->data->name;
    $email = $postData->data->email;
    $phone = $postData->data->phone;


    //com os dados abaixo crie um json e coloque dentro da coluna redes_sociais

    $facebook = $postData->data->facebook;
    $twitter = $postData->data->twitter;
    $linkedin = $postData->data->linkedin;

    $redes_sociais = array(
        "facebook" => $facebook,
        "twitter" => $twitter,
        "linkedin" => $linkedin
    );

    $redes_sociais = json_encode($redes_sociais);

    $updateUser = $db->prepare("UPDATE usuarios SET nome = ?, email = ?, telefone = ?, redes_sociais = ?  WHERE id = ?");
    $updateUser->bindValue(1, $name);
    $updateUser->bindValue(2, $email);
    $updateUser->bindValue(3, $phone);
    $updateUser->bindValue(4, $redes_sociais);
    $updateUser->bindValue(5, $usuario_id);
    $updateUser->execute();

    if ($updateUser) {
        $response['success'] = true;
        $response['message'] = "Perfil atualizado com sucesso!";
        echo json_encode($response);
        exit();
    }
}
