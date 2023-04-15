<?php


namespace Commons\Utilities;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandle
{
    public static function encode(string $str)
    {

    }

    /**
     * @param string $token
     * @return \stdClass
     */
    public static function decode(string $token): \stdClass
    {
        return JWT::decode($token, new Key(env("JWT_KEY"), "HS256"));
    }
}
