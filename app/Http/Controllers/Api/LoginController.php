<?php


namespace App\Http\Controllers\Api;


use App\Services\Api\LoginService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class AdminController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class LoginController extends BaseController
{

    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * 登录
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $name = $request->get('name','');
        $password = $request->get('password','');
        $res = $this->loginService->login($name, $password);
        return $this->success($res);
    }

    /**
     * 登录用户信息
     * @return JsonResponse
     */
    public function adminInfo(): JsonResponse
    {
        $res = $this->loginService->adminInfo();
        return $this->success($res);
    }
}
