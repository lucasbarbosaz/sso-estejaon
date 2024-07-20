<?php
require_once('../../geral.php');

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $tokenArr = explode('.', $token);
    $payload = json_decode(base64_decode($tokenArr[1]));

    $usuario_id = $payload->usuario_id;

    $sql = $db->prepare("DELETE FROM token WHERE usuario_id = ?");
    $sql->bindValue(1, $usuario_id);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(array('status_code' => 200));
        session_destroy();
    } 
}