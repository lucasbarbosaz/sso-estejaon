<?php
require_once("../../geral.php");

// Define a codificação como UTF-8
header('Content-Type: application/json; charset=utf-8');
if (extract($_POST)) {

} else {
    echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
}
?>