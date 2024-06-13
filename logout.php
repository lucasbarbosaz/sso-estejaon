<?php
    require_once(__DIR__ ."/geral.php");
 
    if (!empty($_GET['token'])) {
        $token = $_GET['token'];
    } else {
        $token = $_SESSION['token'];
    }

    $Functions::deleteToken($token);
    session_destroy();

    Redirect($site["url"]);
?>