<?php
    require_once(__DIR__ ."/../geral.php");
 

    session_start();
    session_destroy();

    header('Location: index.php');
?>