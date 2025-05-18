<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{

    public static function createToken($user_email, $user_id){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel Token',
            'iat' => time(),
            'exp' => time() + 3600 * 24,
            'user_email' => $user_email,
            'user_id' => $user_id,
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function createTokenForResetPassword($user_email){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel Token',
            'iat' => time(),
            'exp' => time() + 60*5,
            'user_email' => $user_email
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function verifyToken($token){
        try {
          if (!$token) {
            return "Invalid Token";
          } else {
            $key = env('JWT_KEY');
            $payload = JWT::decode($token, new Key($key, 'HS256'));
            return $payload;
          }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

