<?php
    require_once('class.functions.php');
    require_once('class.dbconnect.php');
    require_once('class.jwt.php');
    require_once('class.email.php');

    $Functions = new Functions;
    $PDO = new Database();
    $db = $PDO->connection();
    $JWT = new generateJWT();
    $Email = new Email();

?>