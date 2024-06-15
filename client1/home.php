<?php
    require_once(__DIR__ . "/../geral.php");

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (!empty($token)) {
            
            if(!$JWT::validateJWT($token)) {
                echo "OIi";
                
            } else {
                $_SESSION['token'] = $token;
            }
                
        }
    }
    


    if (isset($_SESSION['token'])) {
        $url = "https://accounts.estejaon.com.br/get_token.php?token=".$_SESSION['token'];

        $resp = json_decode($Functions::requestData($url, 'GET'));

        if ($resp) {
            $usuario = "";
            if ($resp->status_code == 200) {
                $usuario = $resp->usuario;
            } else {
                unset($_SESSION['token']);
            }
        } else {
            unset($_SESSION['token']);
            header("Location: index.php");
        }
        
    }
?>

<?php
if(isset($_SESSION['token'])) { ?>
<h1>Bem vindo, <?= $usuario->nome ?></h1>
<h3>Sair <a href="/logout.php">Clique aqui</a></h3>
<?php } else { ?>
<h1>Faça login para acessar esse site.</h1>
<?php } ?>
