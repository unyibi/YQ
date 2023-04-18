<?php


namespace App\Services\Api;


use App\Lib\Jwt\Handle;
use App\Models\Api\Admin;
use App\Services\CommonService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class LoginService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class LoginService extends CommonService
{

    /**
     * 登录
     * @param string $name
     * @param string $password
     * @return array
     */
    public function login(string $name, string $password): array
    {
        $condition = [
            'name' => $name
        ];
        $admin = Admin::query()->where($condition)->first();
        if(!$admin){
            throw new BadRequestHttpException('账号不存在');
        }
        if($admin['status'] == 0){
            throw new BadRequestHttpException('账号已关闭');
        }
        if (!Hash::check($password, $admin['password'])) {
            throw new BadRequestHttpException('密码错误');
        }
        return[
            'token' => Handle::createJwt($admin['uuid'])
        ];
    }

    /**
     * @return Admin
     */
    public function adminInfo(): Admin
    {
        /**
         * @var Admin
         */
        return Admin::query()->where(['uuid' => $this->getAdminUuid()])->with(['roles' => function ($query) {
            $query->select(['roles.id','uuid', 'role'])->where('status', '=', 1);
        }])->first();
    }
}
