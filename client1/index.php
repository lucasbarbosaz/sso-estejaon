
<html>
    <?php
        if(isset($_SESSION['token'])) {
            header('home.php');
        }
    ?>
    <h2>Faça login.</h2>
    <a href="http://localhost/?redirect_url=127.0.0.2/home.php">Clique aqui para fazer login usando a conta da EstejaON</a>
</html>