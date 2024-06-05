<?php

// Defina constantes para credenciais de banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'sso_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Defina constantes para o site
define('SITE_NAME', 'EstejaON');
define('SITE_URL', 'http://localhost');
define('AUTH_URL', 'https://auth.estejaon.com.br');

// Configuração da conexão PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lançar exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo padrão de recuperação de dados
    PDO::ATTR_EMULATE_PREPARES   => false, // Desativar emulação de prepared statements
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci", // Configuração de charset e collation
    PDO::ATTR_PERSISTENT         => true // Usar conexões persistentes para melhorar o desempenho
];

try {
    // Conectar ao banco de dados usando as constantes definidas
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, $options);

    // Outras configurações do PDO, se necessário

} catch (PDOException $e) {
    // Em caso de erro, exibir uma mensagem amigável para o usuário
    echo "<title>Erro ao conectar-se com o Banco de Dados</title> " . $e->getMessage(); 
    exit();
    // Você também pode registrar o erro em um arquivo de log para fins de depuração
    // error_log("Erro ao conectar ao banco de dados: " . $e->getMessage(), 0);
    // Lembre-se de nunca exibir detalhes técnicos do erro em um ambiente de produção
}

?>