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

// Verifica se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response['error'] = "Método não permitido";
    echo json_encode($response);
    exit;
}

// Verifica se o campo de email foi enviado
if (!isset($_POST['email']) || empty($_POST['email'])) {
    $response['error'] = "Email inválido";
    echo json_encode($response);
    exit;
}

// Verifica se o campo de senha foi enviado
if (!isset($_POST['senha']) || empty($_POST['senha'])) {
    $response['error'] = "Digite uma senha";
    echo json_encode($response);
    exit;
}

// Obtém o email e a senha enviados
$email = $_POST['email'];
$senha = $_POST['senha'];

// Obtém o endereço IP do usuário, considerando o uso de Cloudflare
$ipAddress = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];

try {
    // Prepara e executa a consulta SQL para obter o hash da senha do usuário
    $stmt = $db->prepare("SELECT senha FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $hashSenha = $stmt->fetchColumn();

    // Verifica se o hash da senha foi encontrado no banco de dados
    if (!$hashSenha) {
        $response['error'] = 'Senha incorreta. Tente novamente ou clique em "Esqueceu a senha?" para escolher outra. [HASH]';
        echo json_encode($response);
        exit;
    }

    // Verifica se a senha enviada corresponde ao hash no banco de dados
    if (password_verify($senha, $hashSenha)) {
        // Senha correta
        // Cabeçalho JWT
        $header = [
            'alg' => 'HS256', // Algoritmo de hash
            'typ' => 'JWT' // Tipo de token
        ];

        // Corpo JWT (contém as informações que você deseja transmitir)
        $body = [
            'sub' => '1234567890', // Identificador do usuário
            'iat' => time(), // Data de emissão do token (timestamp)
            'exp' => time() + (60 * 60), // Data de expiração do token (1 hora após a emissão)
        ];

        // Codifica o cabeçalho e o corpo para JSON
        $encodedHeader = base64_encode(json_encode($header));
        $encodedBody = base64_encode(json_encode($body));

        // Calcula a assinatura do token (usando uma chave secreta)
        $signature = hash_hmac('sha256', $encodedHeader . '.' . $encodedBody, 'sua_chave_secreta', true);
        $encodedSignature = base64_encode($signature);

        // Concatena o cabeçalho, corpo e assinatura para formar o token JWT
        $token = $encodedHeader . '.' . $encodedBody . '.' . $encodedSignature;

        // Salva no banco de dados
        $stmt = $db->prepare("UPDATE usuarios SET token = ?, ip_recente = ? WHERE email = ?");
        $stmt->execute([$token, $ipAddress, $email]);	
		
        // Retorna o token JWT na resposta JSON
        $response['success'] = true;
		$response['token'] = $token;
		
        echo json_encode($response);
    } else {
        // Senha incorreta
        $response['error'] = 'Senha incorreta. Tente novamente ou clique em "Esqueceu a senha?" para escolher outra.';
        echo json_encode($response);
    }
} catch (PDOException $e) {
    error_log("Erro no banco de dados: " . $e->getMessage()); // Log do erro detalhado
    $response['error'] = "Erro interno do servidor";
    echo json_encode($response);
    exit;
} catch (Exception $e) {
    error_log("Erro geral: " . $e->getMessage()); // Log do erro geral
    $response['error'] = "Erro interno do servidor";
    echo json_encode($response);
    exit;
}
?>
