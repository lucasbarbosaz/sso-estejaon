<?php
    class generateJWT {

        

        static function base64UrlEncode($data) {
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        }
    
        static function base64UrlDecode($data) {
            return base64_decode(strtr($data, '-_', '+/'));
        }
    
        static function generateJWT($header, $payload) {
            global $ssoConfig;

            $headerEncoded = self::base64UrlEncode(json_encode($header));
            $payloadEncoded = self::base64UrlEncode(json_encode($payload));
            
            $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $ssoConfig["jwt_secretkey"], true);
            $signatureEncoded = self::base64UrlEncode($signature);
            
            return "$headerEncoded.$payloadEncoded.$signatureEncoded";
        }
    
        static function validateJWT($jwt) {
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
    }
?>