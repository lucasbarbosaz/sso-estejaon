<?php
require_once ('../../geral.php');

// Define a codificação como UTF-8
header('Content-Type: application/json; charset=utf-8');

if (extract($_POST)) {
    $response = array();


    $nome = (isset($_POST['nome'])) ? htmlspecialchars($_POST['nome']) : '';
    $apelido = (isset($_POST['apelido'])) ? htmlspecialchars($_POST['apelido']) : '';
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $telefone = (isset($_POST['telefone'])) ? $_POST['telefone'] : '';
    $email_secundario = (isset($_POST['email_secundario'])) ? $_POST['email_secundario'] : ' ';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
    $conf_senha = (isset($_POST['conf_senha'])) ? $_POST['conf_senha'] : '';
    $dia = (isset($_POST['dia'])) ? $_POST['dia'] : '';
    $mes = (isset($_POST['mes'])) ? $_POST['mes'] : '';
    $ano = (isset($_POST['ano'])) ? $_POST['ano'] : '';
    $genero = (isset($_POST['genero'])) ? $_POST['genero'] : '';
    $tipoPessoa = (isset($_POST['tipoPessoa'])) ? $_POST['tipoPessoa'] : '';
    $captcha = (isset($_POST['captcha'])) ? $_POST['captcha'] : '';


    $email_existe = $db->prepare("SELECT email FROM usuarios WHERE email = ?");
    $email_existe->bindValue(1, $email);
    $email_existe->execute();

    $email_secundario_existe = $db->prepare("SELECT email FROM usuarios WHERE email = ?");
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
    } else if ($Functions::Validate('nome', $nome) !== true) {
        $response['error'] = true;
        $response['back'] = true;
        $response['message'] = "Insira um nome válido.";
        $response['input_error'] = "name";
        $response['type'] = "nome";
        echo json_encode($response);
        exit;
    } else if ($Functions::Validate('nome', $apelido) !== true) {
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
        $response['error'] = true;
        $response['back'] = true;
        $response['type'] = "email";
        $response['message'] = "Esse e-mail já foi cadastrado na EstejaON";
        $response['input_error'] = "email_usuario";
        echo json_encode($response);
        exit;
    } else if ($email_secundario_existe->rowCount() > 0) {
        $response['error'] = true;
        $response['type'] = "email_secundario";
        $response['message'] = "Esse e-mail já está sendo utilizado";
        $response['input_error'] = "email-secundario";
        echo json_encode($response);
    } else if ($email_secundario === $email) {
        $response['error'] = true;
        $response['type'] = "email_secundario";
        $response['message'] = "Esse e-mail já está sendo utilizado como principal.";
        $response['input_error'] = "email-secundario";
        echo json_encode($response);
        exit;
    } else if (!$Functions::formatarNumeroCelular($telefone)) {
        $response['error'] = true;
        $response['type'] = "telefone";
        $response['message'] = "Insira um número de telefone válido.";
        $response['input_error'] = "telefone";
        echo json_encode($response);
        exit;
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
    } else if (empty($dia) && empty($mes) && empty($ano)) {
        $response['error'] = true;
        $response['type'] = 'nascimento';
        $response['message'] = "Por favor, preencha todos os campos de data.";
        $response['input_error'] = ["birthdaydia", "birthdaymes", "birthdayano"];
        echo json_encode($response);
        exit;
    } else if ($idade < 18) {
        $response['error'] = "Você tem que maior de idade para continuar.";
        echo json_encode($response);
        exit;
    } else if (!isset($genero) || empty($genero)) {
        $response['error'] = true;
        $response['type'] = 'genero';
        $response['message'] = "Por favor, escolha seu gênero.";
        $response['input_error'] = "gender";
        echo json_encode($response);
        exit;
    } else if (!isset($tipoPessoa) || empty($tipoPessoa)) {
        $response['error'] = true;
        $response['type'] = 'tipoPessoa';
        $response['message'] = "Por favor, escolha o tipo do seu documento.";
        $response['input_error'] = "tipoPessoa";
        echo json_encode($response);
        exit;
    } else if (empty($captcha) || $captcha == null || $captcha == '') {
        $response["error"] = true;
        $response["back"] = false;
        $response["type"] = "errorCaptcha";
        $response["message"] = "Precisamos saber que você não é um robô! Verifique o teste abaixo";
        $response["input_error"] = "errorCaptcha";
        echo json_encode($response);
        exit;
    } else {

        if ($tipoPessoa == "pf") {
            $cpf = (isset($_POST['cpf'])) ? $_POST['cpf'] : '';

            if (!$Functions::validarCPF($cpf)) {
                $response['error'] = true;
                $response['type'] = 'cpf';
                $response['message'] = "Por favor, insira um CPF válido";
                $response['input_error'] = "cpf";
                echo json_encode($response);
                exit;
            } else if (!isset($cpf) || empty($cpf)) {
                $response['error'] = true;
                $response['type'] = 'cpf';
                $response['message'] = "Por favor, insira um CPF";
                $response['input_error'] = "cpf";
                echo json_encode($response);
                exit;
            }
        } else if ($tipoPessoa == "pj") {
            $cnpj = (isset($_POST['cnpj'])) ? $_POST['cnpj'] : '';

            if (!$Functions::validarCNPJ($cnpj)) {
                $response['error'] = true;
                $response['type'] = 'cnpj';
                $response['message'] = "Por favor, insira um CNPJ válido";
                $response['input_error'] = "cnpj";
                echo json_encode($response);
                exit;
            } else if (!isset($cnpj) || empty($cnpj)) {
                $response['error'] = true;
                $response['type'] = 'cnpj';
                $response['message'] = "Por favor, insira um CNPJ";
                $response['input_error'] = "cnpj";
                echo json_encode($response);
                exit;
            }
        }

        $hcaptchaData = isset($_POST['captcha']) ? $_POST['captcha'] : '';

        if ($hcaptchaData) {

            $dataCaptcha = array(
                'secret' => $hCaptcha["secret_key"],
                'response' => $_POST['captcha']
            );

            $verificarhCaptcha = curl_init();

            curl_setopt($verificarhCaptcha, CURLOPT_URL, "https://hcaptcha.com/siteverify");
            curl_setopt($verificarhCaptcha, CURLOPT_POST, true);
            curl_setopt($verificarhCaptcha, CURLOPT_POSTFIELDS, http_build_query($dataCaptcha));
            curl_setopt($verificarhCaptcha, CURLOPT_RETURNTRANSFER, true);
            $responsehCaptcha = curl_exec($verificarhCaptcha);

            $responseData = json_decode($responsehCaptcha);

            if ($responseData->success == false) {
                $response["error"] = true;
                $response["back"] = false;
                $response["type"] = "errorCaptcha";
                $response["message"] = "Precisamos saber que você não é um robô! Verifique o teste abaixo";
                $response["input_error"] = "errorCaptcha";
                echo json_encode($response);
                exit;
            }


            if (isset($_GET['redirect_url'])) {
                $appUrl = $_GET['redirect_url'];


                $obterSitesPermitidos = $db->prepare("SELECT url FROM host");
                $obterSitesPermitidos->execute();
                $urlsPermitidas = $obterSitesPermitidos->fetchAll(PDO::FETCH_COLUMN);

                $obterHost = $Functions::getHostFromUrl($appUrl); //remover o path e o scheme

                if (in_array($obterHost, $urlsPermitidas)) {

                    if (substr($appUrl, 0, 4) != "http") {
                        $source = parse_url("http://" . $appUrl);
                    } else {
                        $source = parse_url($appUrl);
                    }

                    if (isset($source['host'])) {
                        $senha_bcrypt = password_hash($senha, PASSWORD_BCRYPT);

                        $dataEmpresa = json_decode($Functions::requestData("https://publica.cnpj.ws/cnpj/" . $Functions::removerFormatacaoCNPJ($cnpj) . "", "GET"));

                        if ($dataEmpresa) {
                            $inserir_conta = $db->prepare("INSERT INTO usuarios (nome, apelido, email, email_secundario, telefone, senha, data_nascimento, genero, tipo_pessoa, cpf, cnpj, razao_social, descricao_empresa, ultimo_ip, registro_ip) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $inserir_conta->bindValue(1, $nome);
                            $inserir_conta->bindValue(2, $apelido);
                            $inserir_conta->bindValue(3, $email);
                            $inserir_conta->bindValue(4, $email_secundario);
                            $inserir_conta->bindValue(5, $Functions::formatarNumeroCelular($telefone));
                            $inserir_conta->bindValue(6, $senha_bcrypt);
                            $inserir_conta->bindValue(7, $data);
                            $inserir_conta->bindValue(8, $genero);
                            $inserir_conta->bindValue(9, $tipoPessoa);
                            $inserir_conta->bindValue(10, $cpf ? $cpf : "");
                            $inserir_conta->bindValue(11, $cnpj ? $cnpj : "");
                            $inserir_conta->bindValue(12, $dataEmpresa->razao_social);
                            $inserir_conta->bindValue(13, $dataEmpresa->natureza_juridica->descricao);
                            $inserir_conta->bindValue(14, $Functions::IP());
                            $inserir_conta->bindValue(15, $Functions::IP());
                            $inserir_conta->execute();
                            $conta_id = $db->lastInsertId();

                            $header = [
                                'alg' => 'HS256',
                                'typ' => 'JWT'
                            ];

                            $payload = [
                                'iat' => time(),
                                'exp' => time() + (30 * 24 * 60 * 60), // expira em 30 dias
                                'sub' => $conta_id
                            ];

                            $token = $JWT::generateJWT($header, $payload);

                            $scheme = isset($source['scheme']) ? $source['scheme'] : 'http';
                            $host = $source['host'];
                            $path = isset($source['path']) ? $source['path'] : '';

                            $target = $scheme . '://' . $host . $path;

                            $salvarToken = $db->prepare("INSERT INTO token (access_token, usuario_id) VALUES(?,?)");
                            $salvarToken->bindValue(1, $token);
                            $salvarToken->bindValue(2, $conta_id);
                            $salvarToken->execute();

                            $_SESSION['token'] = $token;
                            $_SESSION['id'] = $conta_id;
                            $_SESSION['senha'] = $senha_bcrypt;


                            $response['success'] = true;
                            $response['redirect'] = true;
                            $response['location'] = $target . '?token=' . $token;
                            echo json_encode($response);
                        } else {
                            $response['error'] = true;
                        }


                    }


                } else {
                    $response['error'] = true;
                    $response['url'] = "$obterHost";
                    $response['type'] = 'url_blocked';
                    echo json_encode($response);
                }
            } else {

                $senha_bcrypt = password_hash($senha, PASSWORD_BCRYPT);

                $dataEmpresa = json_decode($Functions::requestData("https://publica.cnpj.ws/cnpj/" . $Functions::removerFormatacaoCNPJ($cnpj) . "", "GET"));

                if ($dataEmpresa) {
                    $inserir_conta = $db->prepare("INSERT INTO usuarios (nome, apelido, email, email_secundario, telefone, senha, data_nascimento, genero, tipo_pessoa, cpf, cnpj, razao_social, descricao_empresa, ultimo_ip, registro_ip) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $inserir_conta->bindValue(1, $nome);
                    $inserir_conta->bindValue(2, $apelido);
                    $inserir_conta->bindValue(3, $email);
                    $inserir_conta->bindValue(4, $email_secundario);
                    $inserir_conta->bindValue(5, $Functions::formatarNumeroCelular($telefone));
                    $inserir_conta->bindValue(6, $senha_bcrypt);
                    $inserir_conta->bindValue(7, $data);
                    $inserir_conta->bindValue(8, $genero);
                    $inserir_conta->bindValue(9, $tipoPessoa);
                    $inserir_conta->bindValue(10, $cpf ? $cpf : "");
                    $inserir_conta->bindValue(11, $cnpj ? $cnpj : "");
                    $inserir_conta->bindValue(12, $dataEmpresa->razao_social);
                    $inserir_conta->bindValue(13, $dataEmpresa->natureza_juridica->descricao);
                    $inserir_conta->bindValue(14, $Functions::IP());
                    $inserir_conta->bindValue(15, $Functions::IP());
                    $inserir_conta->execute();
                    $conta_id = $db->lastInsertId();

                    $header = [
                        'alg' => 'HS256',
                        'typ' => 'JWT'
                    ];

                    $payload = [
                        'iat' => time(),
                        'exp' => time() + (30 * 24 * 60 * 60), // expira em 30 dias
                        'sub' => $conta_id
                    ];

                    $token = $JWT::generateJWT($header, $payload);

                    $salvarToken = $db->prepare("INSERT INTO token (access_token, usuario_id) VALUES(?,?)");
                    $salvarToken->bindValue(1, $token);
                    $salvarToken->bindValue(2, $conta_id);
                    $salvarToken->execute();


                    $_SESSION['token'] = $token;
                    $_SESSION['id'] = $conta_id;
                    $_SESSION['senha'] = $senha_bcrypt;

                    $response['success'] = true;
                    echo json_encode($response);
                }

            }
        } else {
            $response["error"] = true;
            $response["back"] = false;
            $response["type"] = "errorCaptcha";
            $response["message"] = "Precisamos saber que você não é um robô! Verifique o teste abaixo";
            $response["input_error"] = "errorCaptcha";
            echo json_encode($response);
            exit;
        }


    }
} else {
    echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
}
?>