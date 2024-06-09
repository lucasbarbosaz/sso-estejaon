<?php
require_once(__DIR__ . "/geral.php");

            
$obterSitesPermitidos = $db->prepare("SELECT url FROM host");
$obterSitesPermitidos->execute();
$urlsPermitidas = $obterSitesPermitidos->fetchAll(PDO::FETCH_COLUMN);

print_r($urlsPermitidas);
?>