<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Lib\Jwt\Handle;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jwtToken = $request->header("token",'');
        $request->merge(['requestId' => Uuid::uuid4()->toString()]);
        if(empty($jwtToken)){
            throw new BadRequestHttpException('未登录');
        }
        $adminUuid = Handle::verifyJwt($jwtToken);
        $request->merge(['adminUuid' => $adminUuid]);
        return $next($request);
    }
}
