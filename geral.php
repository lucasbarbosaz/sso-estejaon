<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);


if (!isset($_SESSION)) {
    
    $lifetime = 30 * 24 * 60 * 60; //30 dias de sessão ativa
    
    ini_set('session.cookie_lifetime', $lifetime);

    session_start();


}


define('DIR', __DIR__);

require_once (DIR . '/inc/system/class/class.core.php');
require_once (DIR . '/inc/system/functions.php');

define('EMAILS_PERMITIDOS', array('@gmail.com', '@outlook.com', '@hotmail.com', '@yahoo.com', '@icloud.com', '@protonmail.com'));
// Defina constantes para o site
define('SITE_NAME', 'EstejaON');
define('SITE_URL', 'http://localhost');
define('LOGIN_URL', 'http://localhost/login');
define('MAX_TENTATIVAS_LOGIN', 5); // Define o número máximo de tentativas de login
define('TEMPO_BLOQUEIO_LOGIN', 300); // Define o tempo de bloqueio em segundos (300 segundos = 5 minutos)


//se usuario estiver logado liberar variavel $usuario em todo o sistema para obter dados do usuario
if (isset($_SESSION['id']) && isset($_SESSION['senha']) && isset($_SESSION['token'])) {
    $usuario_id = $_SESSION['id'];
    $senha = password_hash($_SESSION['senha'], PASSWORD_BCRYPT);

    if (password_verify($_SESSION['senha'], $senha)) {
        //valida se o token ainda é válido
        if ($JWT::validateJWT($_SESSION['token'])) {

            $usuario = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $usuario->bindValue(1, $_SESSION['id']);
            $usuario->execute();

            if ($usuario->rowCount() > 0) {
                $usuario = $usuario->fetch(PDO::FETCH_ASSOC);

                //atualizar ip do usuario
                $atualiza_ip = $db->prepare("UPDATE usuarios SET ultimo_ip = ? WHERE id = ?");
                $atualiza_ip->bindValue(1, $Functions::IP());
                $atualiza_ip->bindValue(2, $usuario['id']);
                $atualiza_ip->execute();

            } else {
                $Functions::deleteToken($_SESSION['token']);
                session_destroy();
                Redirect(SITE_URL);
            }
        } else {
            $Functions::deleteToken($_SESSION['token']);
            session_destroy();
            Redirect(SITE_URL);
        }
    }

} else {

}

header("Content-Type: text/html; charset=utf-8", true);
header("Access-Control-Allow-Origin: " . SITE_URL);
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-15', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


?>