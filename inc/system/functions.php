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

function decryptParameter($encrypted) {
    $key = '1234567890123456'; 
    $iv = '1234567890123456'; 
    $cipher = "AES-128-CBC";

    $encrypted = base64_decode($encrypted);

    $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

    return $decrypted;
}
?>