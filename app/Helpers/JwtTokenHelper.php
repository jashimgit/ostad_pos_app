<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtTokenHelper
{


    public static function CreateToken($userEmail, $userId)
    {
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-pos-token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userid' => $userId,
        ];


        return $token = JWT::encode($payload, $key, 'HS256');
    }




    public static function VerifyToken($token)
    {

        try {
            if ($token == null) {
                return 'unauthorized';
            } else {

                $key = env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            }
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
            'userEmail' => $userEmail,
            'userid' => '0',
        ];


        return  JWT::encode($payload, $key, 'HS256');
    }
}
