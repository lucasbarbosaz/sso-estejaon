<?php
class Functions
{
    static function Validate($type, $string)
    {
        if ($type == "nome") {
            $pattern = "/[^a-zA-Z0-9 ]+/";  // Inclui espaço como caractere válido
            $match = preg_match($pattern, $string);

            if ($match == 1) {
                return false;
            } else {
                return true;
            }
        }
    }

    static function Filter($type, $string)
    {
        if ($type == 'nome') {
            $value = htmlspecialchars_decode($string);

            $search = [
                "/",
                "\\"
            ];

            $replace = [
                "",
                ""
            ];

            $value = str_replace($search, $replace, $value);
        }

        return $value;
    }

    static function formatarNumeroCelular($numero)
    {
        $numero = preg_replace('/\D/', '', $numero);

        if (strlen($numero) == 11) {
            return $numero;
        }

        if (strlen($numero) == 10) {
            $numero = '9' . $numero;
            return $numero;
        }

        return false;
    }



    static function generateToken($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    static function saveToken($token, $cliente_id)
    {
        global $db;

        $save = $db->prepare("INSERT INTO token (access_token, user_id) VALUES (?,?)");
        $save->bindValue(1, $token);
        $save->bindValue(2, $cliente_id);
        $save->execute();

        return $save->rowCount();
    }

    static function deleteToken($token)
    {
        global $db;

        $delete = $db->prepare("DELETE FROM token WHERE access_token = ?");
        $delete->bindValue(1, $token);
        $delete->execute();

        return $delete->rowCount();
    }

    static function getUserByToken($token)
    {
        global $db;

        $getUserId = $db->prepare("SELECT user_id FROM token WHERE access_token = ?");
        $getUserId->bindValue(1, $token);
        $getUserId->execute();
        $getUserId = $getUserId->rowCount() > 0 ? $getUserId->fetch(PDO::FETCH_ASSOC) : null;

        if ($getUserId !== null) {
            $getUser = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $getUser->bindValue(1, $getUserId['user_id']);
            $getUser->execute();

            return $getUser->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    static function IP()
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else if (!empty($_SERVER['HTTP_INCAP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_INCAP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_SUCURI_CLIENTIP'])) {
            $ip = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
        } else if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    static function requestData($url, $method = "GET", $postdata = null)
    {
        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
        );

        if ($method == "POST") {
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_POST => 1,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_POSTFIELDS => $postdata,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_VERBOSE => 1
                )
            );
        } else {
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_HTTPGET => 1,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_VERBOSE => 1
                )
            );
        }


        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    static function getHostFromUrl($url)
    {
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'http://' . $url;
        }
        $parsedUrl = parse_url($url);
        return $parsedUrl['host'] ?? null;
    }

    static function Session($type)
    {
        if ($type == 'conectado') {
            if (isset($_SESSION['id']) && isset($_SESSION['token'])) {
                Redirect(SITE_URL . '/conta');
            }
        } else if ($type == 'desconectado') {
            if (!isset($_SESSION['id']) && !isset($_SESSION['token'])) {
                Redirect(SITE_URL);
            }
        }
    }

    static function criptografarSenha($senha) //bcrypt padrao da nossa db
    {
        return password_hash($senha, PASSWORD_BCRYPT);
    }

    static function validarCPF($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    static function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $tamanho = 12;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);

        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado = $soma % 11 < 2 ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[0]) {
            return false;
        }

        $tamanho = 13;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado = $soma % 11 < 2 ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[1]) {
            return false;
        }

        return true;
    }

    static function formatarCelular($numeroCelular)
    {
        $numeroCelular = preg_replace('/\D/', '', $numeroCelular);

        if (strlen($numeroCelular) == 11) {
            $numeroFormatado = sprintf(
                "(%s) %s-%s",
                substr($numeroCelular, 0, 2),      // DDD
                substr($numeroCelular, 2, 5),      // Parte do número
                substr($numeroCelular, 7)
            );
            return $numeroFormatado;
        } else {
            return "Número de celular inválido.";
        }
    }

    static function removerFormatacaoCNPJ($cnpj)
    {
        $cnpjNumerico = preg_replace('/\D/', '', $cnpj);
        return $cnpjNumerico;
    }

    
}
