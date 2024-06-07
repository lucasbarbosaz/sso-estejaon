<?php
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../functions.php');

// Define a codificação como UTF-8
header('Content-Type: application/json; charset=utf-8');

// Habilita o CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: " . LOGIN_URL);
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");



if (extract($_POST)) {
    $response = array();

    $nome = (isset($_POST['nome'])) ? Filter('nome', $_POST['nome']) : '';
    $apelido = (isset($_POST['apelido'])) ? Filter('nome', $_POST['apelido']) : '';
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $telefone = (isset($_POST['telefone'])) ? $_POST['telefone'] : '';
    $email_secundario = (isset($_POST['email_secundario'])) ? $_POST['email_secundario'] : ' ';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
    $conf_senha = (isset($_POST['conf_senha'])) ? $_POST['conf_senha'] : '';
    $dia = (isset($_POST['dia'])) ? $_POST['dia'] : '';
    $mes = (isset($_POST['mes'])) ? $_POST['mes'] : '';
    $ano = (isset($_POST['ano'])) ? $_POST['ano'] : '';
    $genero = (isset($_POST['genero'])) ? $_POST['genero'] : '';

    $email_existe = $pdo->prepare("SELECT email FROM usuarios WHERE email = ?");
    $email_existe->bindValue(1, $email);
    $email_existe->execute();

    $email_secundario_existe = $pdo->prepare("SELECT email FROM usuarios WHERE email = ?");
    $email_secundario_existe->bindValue(1, $email_secundario);
    $email_secundario_existe->execute();

    $emailValido = false;
    $emailSecValido = false;

    foreach (EMAILS_PERMITIDOS as $dominio) {
        if (strpos($email, $dominio) !== false) {
            $emailValido = true;
            break;
        }
    }

    foreach (EMAILS_PERMITIDOS as $dominio) {
        if (strpos($email_secundario, $dominio) !== false) {
            $emailSecValido = true;
            break;
        }
    }

    $data = $ano . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dia, 2, '0', STR_PAD_LEFT);
    $data_nascimento = new DateTime($data);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nascimento)->y;

    if (!isset($nome) || empty($nome)) {
        $response['error'] = true;
        $response['back'] = true;
        $response['type'] = "nome";
        $response['message'] = "Informe um nome";
        $response['input_error'] = "name";
        echo json_encode($response);
        exit;
    } else if (strlen($nome) < 3 || strlen($nome) >= 50) {
        $response['error'] = true;
        $response['back'] = true;
        $response['type'] = "nome";
        $response['message'] = "Minímo 3 caracteres e máximo 50.";
        $response['input_error'] = "name";
        echo json_encode($response);
        exit;
    } else if (Validate('nome', $nome) !== true) {
        $response['error'] = true;
        $response['back'] = true;
        $response['message'] = "Insira um nome válido.";
        $response['type'] = "nome";
        echo json_encode($response);
        exit;
    } else if (Validate('nome', $apelido) !== true) {
        $response['error'] = true;
        $response['back'] = true;
        $response['message'] = "Insira um apelido válido.";
        $response['type'] = "apelido";
        $response['input_error'] = "apelido";
        echo json_encode($response);
        exit;
    } else if (!isset($email) || empty($email)) {
        $response['error'] = true;
        $response['back'] = true;
        $response['type'] = "email";
        $response['message'] = "Informe um e-mail";
        $response['input_error'] = "email_usuario";
        echo json_encode($response);
        exit;
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $response['error'] = true;
        $response['back'] = true;
        $response['type'] = "email";
        $response['message'] = "Digite um e-mail válido";
        $response['input_error'] = "email_usuario";
        echo json_encode($response);
        exit;
    } else if (!$emailValido) {
        $response['error'] = true;
        $response['back'] = true;
        $response['type'] = "email";
        $response['message'] = "E-mail não permitido";
        $response['input_error'] = "email_usuario";
        echo json_encode($response);
        exit;
    } else if ($email_existe->rowCount() > 0) {
        $response['error'] = "Esse e-mail já foi cadastrado na EstejaON";
        echo json_encode($response);
        exit;
    } else if (!formatarNumeroCelular($telefone)) {
        $response['error'] = true;
        $response['type'] = "telefone";
        $response['message'] = "Insira um número de telefone válido.";
        $response['input_error'] = "telefone";
        echo json_encode($response);
        exit;
    } else if ($email_secundario_existe->rowCount() > 0) {
        $response['error'] = true;
        $response['type'] = "email_secundario";
        $response['message'] = "Esse e-mail já está sendo utilizado";
        $response['input_error'] = "email-secundario";
        echo json_encode($response);
    } else if (!isset($senha) || empty($senha)) {
        $response['error'] = true;
        $response['type'] = "senha";
        $response['message'] = "Por favor, preencha todos os campos de senha.";
        $response['input_error'] = "senha-registro";
        echo json_encode($response);
        exit;
    } else if (strlen($senha) < 6) {
        $response['error'] = true;
        $response['type'] = "senha";
        $response['message'] = "Sua senha precisa ter 6 ou mais caracteres.";
        $response['input_error'] = "senha-registro";
        echo json_encode($response);
        exit;
    } else if ($senha != $conf_senha) {
        $response['error'] = true;
        $response['type'] = "senha-diferente";
        $response['message'] = "Sua senha não são identicas.";
        $response['input_error'] = ["senha-registro", "conf-senha"];
        echo json_encode($response);
        exit;
    } else if (!isset($conf_senha) || empty($conf_senha)) {
        $response['error'] = true;
        $response['type'] = "conf-senha";
        $response['message'] = "Confirme sua senha";
        $response['input_error'] = "conf-senha";
        echo json_encode($response);
        exit;
    } else if (!empty($dia) && !empty($mes) && !empty($ano)) {
        $response['error'] = true;
        $response['type'] = 'nascimento';
        $response['message'] = "Por favor, preencha todos os campos de data.";
        $response['input_error'] = ["birthdaydia","birthdaymes","birthdayano"];
        echo json_encode($response);
        exit;
    } else if ($idade < 18) {
        $response['error'] = "Você tem que maior de idade para continuar.";
        echo json_encode($response);
        exit;
    } else if (!isset($genero)) {
        $response['error'] = true;
        $response['type'] = 'genero';
        $response['message'] = "Por favor, escolha seu gênero.";
        $response['input_error'] = "gender";
        echo json_encode($response);
        exit;
    } else {

        // a finalizar

        $response['success'] = true;
        echo json_encode($response);
    }
}
