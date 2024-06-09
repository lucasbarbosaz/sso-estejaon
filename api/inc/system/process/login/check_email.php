<?php
// Inclui o arquivo de configuração
require_once(__DIR__ . '/../../../../../geral.php');


// Define a codificação como UTF-8
header('Content-Type: application/json; charset=utf-8');

// Habilita o CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: " . LOGIN_URL);
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Inicializa um array para armazenar as mensagens de erro
$response = array();

if (extract($_POST)) {
    $email = (isset($email)) ? $email : '';
    // Verifica se o campo de email foi enviado
    if (!isset($email) || empty($email)) {
        $response['error'] = "Digite um e-mail";
        echo json_encode($response);
        exit;
    }

    // Sanitiza e valida o email enviado
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $response['error'] = "Digite um e-mail válido";
        echo json_encode($response);
        exit;
    }

    // Verifica se o email possui um domínio permitido
    $emailValido = false;
    foreach (EMAILS_PERMITIDOS as $dominio) {
        if (strpos($email, $dominio) !== false) {
            $emailValido = true;
            break;
        }
    }

    if (!$emailValido) {
        $response['error'] = "E-mail não permitido";
        echo json_encode($response);
        exit;
    }

    try {
        // Prepara e executa a consulta SQL para verificar se o email existe
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verifica se o email existe no banco de dados
        if (!$user) {
            $response['error'] = "Não foi possível encontrar sua conta na EstejaON";
            echo json_encode($response);
            exit;
        }

        // Se chegou até aqui, o email foi encontrado
        $response['success'] = true;
        echo json_encode($response);
    } catch (PDOException $e) {
        $response['error'] = "Erro interno do servidor: " . $e->getMessage();
        echo json_encode($response);
        exit;
    }
} else {
    echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}
