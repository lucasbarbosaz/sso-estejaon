<?php
require_once ("geral.php");
$appUrl = "https://www.google.com";

echo $Functions::getHostFromUrl($appUrl);

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


    
}