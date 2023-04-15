<?php

namespace App\Http\Middleware;

use Closure;
use Commons\Utilities\JwtHandle;
use Commons\Utilities\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $jwtToken = $request->header("token",'');
        if(empty($jwtToken)){
            throw new BadRequestHttpException('未登录');
        }
        $tokenData = JwtHandle::decode($jwtToken);
        $schoolId = data_get($tokenData, 'id');
        $request->merge(['schoolId' => $schoolId]);
        $request->merge(['requestId' => Str::uuid()->toString()]);
        config(['database.connections.mysql.database' => StringHelper::getDatabase($schoolId)]);
        return $next($request);
    }
}
