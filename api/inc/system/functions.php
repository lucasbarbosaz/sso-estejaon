<?php
function Validate($type, $string)
{
    if ($type == "nome") {
        $pattern = "/[^a-zA-Z0-9]+/";
        $match = preg_match($pattern, $string);

        if ($match == 1) {
            return false;
        } else {
            return true;
        }
    }
}

function Filter($type, $string)
{
    if ($type == 'nome') {
        $value = htmlspecialchars_decode($string);

        $search = [
            " ", "/", "\\"
        ];

        $replace = [
            "", "", ""
        ];

        $value = str_replace($search, $replace, $value);
    }

    return $value;
}

function formatarNumeroCelular($numero) {
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

function criarRespostaErro($mensagem, $tipo, $inputErro) {
    return [
        'error' => true,
        'back' => true,
        'message' => $mensagem,
        'type' => $tipo,
        'input_error' => $inputErro
    ];
}