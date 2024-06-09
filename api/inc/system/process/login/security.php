<?php
require_once (__DIR__ . "/../../../../../geral.php");

// Define a codificação como UTF-8
header('Content-Type: application/json; charset=utf-8');

if (extract($_GET)) {
    if (isset($_GET['redirect_blocked'])) {
        $ip = $Functions::IP();

        $siteRedirecionado = $_GET['redirect_blocked'];

        $dadosIP = $Functions::requestData("ip-api.com/json/" . $ip, "GET");

        $addLog = $db->prepare("INSERT INTO logs (ip_navegador, dados_ip, mensagem) VALUES (?,?,?)");
        $addLog->bindValue(1, $ip);
        $addLog->bindValue(2, $dadosIP);
        $addLog->bindValue(3, "Manipulou a url e tentou redirecionar para: " . $siteRedirecionado);
        $addLog->execute();

        $response['success'] = true;
        echo json_encode($response);
    } else {
        echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
    }
} else {
    echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
}
?>