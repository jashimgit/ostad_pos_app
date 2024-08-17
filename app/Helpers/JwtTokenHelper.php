<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtTokenHelper
{


    public static function CreateToken($userEmail)
    {
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-pos-token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail
        ];


        return $token = JWT::encode($payload, $key, 'HS256');
    }




    public static function VerifyToken($token)
    {
        // decode 
        try {
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;

        } catch (\Throwable $th) {
            return 'unauthorized';
        }
    }

    // reset password token issude
    public static function ResetPasswordToken($userEmail)
    {
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-pos-token',
            'iat' => time(),
            'exp' => time() + 60 * 10,
            'userEmail' => $userEmail
        ];


        return $token = JWT::encode($payload, $key, 'HS256');
    }
}
