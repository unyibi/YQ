<?php

namespace App\Http\Middleware;

use App\Lib\Jwt;
use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $noVerifyRoute = [
            'api/login'
        ];
        $route = $request->route()->uri();
        $jwtToken = $request->header("token",'');
        $request->merge(['requestId' => Uuid::uuid4()->toString()]);
        if(in_array($route,$noVerifyRoute)){
            return $next($request);
        }
        if(empty($jwtToken)){
            throw new BadRequestHttpException('未登录');
        }
        $adminUuid = Jwt::verifyJwt($jwtToken);
        $request->merge(['adminUuid' => $adminUuid]);
        return $next($request);
    }
}
