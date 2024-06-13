<?php
function Redirect($url, $local = true)
{
    ob_start();

    if ($url == 'reload') {
        header('Refresh: 0');
    } else if ($local == true || $local == null) {
        $goto = $url;
        header('Location: ' . $goto);
    } else {
        $goto = ($local) ? URL . $url : $url;
        header('Location: ' . $goto);
    }

    ob_end_flush();
}

function decryptParameter($encrypted)
{
    $key = '1234567890123456';
    $iv = '1234567890123456';
    $cipher = "AES-128-CBC";

    $encrypted = base64_decode($encrypted);

    $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

    return $decrypted;
}

function verificarLoginBloqueado()
{
    if (isset($_SESSION['bloqueado_ate']) && time() < $_SESSION['bloqueado_ate']) {
        return true;
    }
    return false;
}

function registrarTentativaFalha()
{
    global $site;

    if (!isset($_SESSION['tentativas_falhas'])) {
        $_SESSION['tentativas_falhas'] = 0;
    }
    $_SESSION['tentativas_falhas']++;

    if ($_SESSION['tentativas_falhas'] >= $site["max_tentativa_login"]) {
        $_SESSION['bloqueado_ate'] = time() + $site["tempo_bloqueio_login"];
    }
}

function redefinirTentativas()
{
    unset($_SESSION['tentativas_falhas']);
    unset($_SESSION['bloqueado_ate']);
}

function converterSegundosEmMinutos($segundos)
{
    $minutos = floor($segundos / 60);

    return sprintf("%d minutos", $minutos);
}
?>