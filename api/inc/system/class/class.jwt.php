<?php
    class generateJWT {

        private static $jwt_secret_key = '#axPksmXajLPi%uAxaEw%xPçVvDohS'; //nossa chave (n compartilhar)


        static function base64UrlEncode($data) {
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        }
    
        static function base64UrlDecode($data) {
            return base64_decode(strtr($data, '-_', '+/'));
        }
    
        static function generateJWT($header, $payload) {
            $headerEncoded = self::base64UrlEncode(json_encode($header));
            $payloadEncoded = self::base64UrlEncode(json_encode($payload));
            
            $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::$jwt_secret_key, true);
            $signatureEncoded = self::base64UrlEncode($signature);
            
            return "$headerEncoded.$payloadEncoded.$signatureEncoded";
        }
    
        static function validateJWT($jwt) {
            $parts = explode('.', $jwt);
            if (count($parts) !== 3) {
                return false;
            }
    
            list($headerEncoded, $payloadEncoded, $signatureEncoded) = $parts;
    
            $signature = self::base64UrlEncode(hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::$jwt_secret_key, true));
            if ($signature !== $signatureEncoded) {
                return false; 
            }
    
            $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);
    
            if ($payload['exp'] < time()) {
                return false; 
            }
    
            return $payload; 
        }
    }
?>