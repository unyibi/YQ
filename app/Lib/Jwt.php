<?php

namespace App\Lib;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Jwt
{
    public static function createJwt($uuid): string
    {
        $time = time();
        $expTime = 2592000; //过期时间：一个月
        $payload = array(
            "iat" => $time,
            "nbf" => $time,
            "uuid" => $uuid,
            "exp" => $time + $expTime,
        );

        return \Firebase\JWT\JWT::encode($payload, env('JWT_KEY'), 'HS256');
    }

    //传入jwt判断用户
    public static function verifyJwt($jwt)
    {
        try {
            $decoded = \Firebase\JWT\JWT::decode($jwt, new Key(env('JWT_KEY'), 'HS256'));
        } catch (SignatureInvalidException $e) {
            throw new BadRequestHttpException('签名不正确');
        } catch (BeforeValidException $e) {
            throw new BadRequestHttpException('签名未到使用时间');
        } catch (ExpiredException $e) {
            throw new BadRequestHttpException('签名已过期');
        } catch (\Exception $e) {
            throw new BadRequestHttpException('签名错误');
        }
        return $decoded->uuid;
    }
}
