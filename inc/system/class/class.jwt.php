<?php
class generateJWT
{

    static function returnResponse($response)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($response);
        exit;
    }
    static function returnErrorResponse($statusCode, $message)
    {
        $response = array();
        $response['error'] = true;
        $response['status_code'] = $statusCode;
        $response['message'] = $message;
        self::returnResponse($response);
    }

    static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    static function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    static function generateJWT($header, $payload, $user_id)
    {
        global $ssoConfig;
        global $db;

        $payload['usuario_id'] = $user_id;


        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $ssoConfig["jwt_secretkey"], true);
        $signatureEncoded = self::base64UrlEncode($signature);


        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    static function getToken()
    {
        global $ssoConfig;

        $headers = apache_request_headers();

        if (isset($headers['Authorization'])) {
            $http_authorization = $headers['Authorization'];
        } elseif (isset($headers['authorization'])) {
            $http_authorization = $headers['authorization'];
        } else {
            // Cabeçalho de autorização não encontrado
            self::returnErrorResponse(401, "Forneça um token válido para acessar este recurso.");
        }


        $bearer = explode(' ', $http_authorization);
        if (count($bearer) < 2) {
            self::returnErrorResponse(401, "Forneça um token válido para acessar este recurso.");
        }

        $token = explode('.', $bearer[1]);
        if (count($token) !== 3) {
            self::returnErrorResponse(401, "Forneça um token válido para acessar este recurso.");
        }

        $tokenHeader = $token[0];
        $tokenPayload = $token[1];
        $tokenSignature = $token[2];

        $validSignature = self::base64UrlEncode(hash_hmac('sha256', $tokenHeader . '.' . $tokenPayload, $ssoConfig["jwt_secretkey"], true));
        if ($tokenSignature !== $validSignature) {
            self::returnErrorResponse(401, "Forneça um token válido para acessar este recurso.");
        }

        return $bearer[1];
    }


    static function validateJWT($jwt)
    {
        global $ssoConfig;

        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return false;
        }

        list($headerEncoded, $payloadEncoded, $signatureEncoded) = $parts;

        $signature = self::base64UrlEncode(hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $ssoConfig["jwt_secretkey"], true));
        if ($signature !== $signatureEncoded) {
            return false;
        }

        $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);

        if ($payload['exp'] < time()) {
            return false;
        }

        return $payload;
    }

    static function checkAuth()
    {
        $token = self::getToken();

        if ($token === null) {
            self::returnErrorResponse(401, "Forneça um token válido para acessar este recurso.");
        } else if ($token === false) {
            self::returnErrorResponse(401, "Forneça um token válido.");
        } else {
            return $token;
        }
    }

    public static function getUserIdFromToken($checkAuth = true)
    {
        $token = $checkAuth ? self::checkAuth() : self::getToken();

        $tokenArr = explode('.', $token);
        $payload = json_decode(base64_decode($tokenArr[1]));
        return $payload->usuario_id;
    }
}
