<?php

require_once (__DIR__ . "/geral.php");


if (isset($_GET['redirect_url'])) {
    $appUrl = $_GET['redirect_url'];
    if (isset($_SESSION['id']) && isset($_SESSION['token'])) {
        
        $obterSitesPermitidos = $db->prepare("SELECT url FROM host");
        $obterSitesPermitidos->execute();
        $urlsPermitidas = $obterSitesPermitidos->fetchAll(PDO::FETCH_COLUMN);

        $obterHost = $Functions::getHostFromUrl($appUrl);

        if (in_array($obterHost, $urlsPermitidas)) {
            if (substr($appUrl, 0, 7) != "http://" && substr($appUrl, 0, 8) != "https://") {
                $source = parse_url("https://" . $appUrl);
            } else {
                $source = parse_url($appUrl);
            }


            if (isset($source['host'])) {
                $scheme = isset($source['scheme']) ? $source['scheme'] : 'http';
                $host = $source['host'];
                $path = isset($source['path']) ? $source['path'] : '';

                $target = $scheme . '://' . $host . $path;


                Redirect($target . "?token=" . $_SESSION['token']);
                exit;
            }

        } else {
            Redirect($site["url_login"]);
            exit;
        }
    } else {
        Redirect($site["url_login"] . "?redirect_url=" . $appUrl);
        exit;
    }
} else {
    Redirect($site["url_login"]);
    exit;
}




?>