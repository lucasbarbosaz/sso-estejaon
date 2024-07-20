<?php

require_once (__DIR__ . "/geral.php");

$token = $db->prepare("SELECT * FROM token WHERE usuario_id = ?");
$token->bindValue(1, $_SESSION['id']);
$token->execute();

if (isset($_GET['redirect_url'])) {
    if ($token->rowCount() > 0) {
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
    
                    $backUrl = isset($_GET['back_url']) ? $_GET['back_url'] : null;
    
                    if ($backUrl) {
                        Redirect($target . "?token=" . $_SESSION['token'] . "&back_url=" . $backUrl);
                    } else {
                        Redirect($target . "?token=" . $_SESSION['token']);
                    }
                    
                    exit;
                }
    
            } 
        } else {
            $appUrl = $_GET['redirect_url'];
            $backUrl = isset($_GET['back_url']) ? $_GET['back_url'] : null;
            
            if ($backUrl) {
                Redirect($site["url_login"] . "?redirect_url=" . $appUrl . "&back_url=".$backUrl);	
            } else {
                Redirect($site["url_login"] . "?redirect_url=" . $appUrl);	
            }
            
            exit;
        } 
    } else {
        $appUrl = $_GET['redirect_url'];
        $backUrl = isset($_GET['back_url']) ? $_GET['back_url'] : null;
        
        if ($backUrl) {
            Redirect($site["url_login"] . "?redirect_url=" . $appUrl . "&back_url=".$backUrl);	
        } else {
            Redirect($site["url_login"] . "?redirect_url=" . $appUrl);	
        }
        
        exit;
    }
} else {
                
    Redirect($site["url_login"]);
    exit;
}
 






?>