<?php


namespace App\Services;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait AdminTrait
{
    public function getAdminUuid()
    {
        $adminUuid = request()->get("adminUuid");
        if(empty($adminUuid)){
            throw new BadRequestHttpException('参数错误');
        }
        return $adminUuid;
    }
}
