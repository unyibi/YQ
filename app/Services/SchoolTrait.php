<?php


namespace App\Services;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait SchoolTrait
{
    public function getSchoolId()
    {
        $schoolId = request()->get("schoolId");
        if(empty($schoolId)){
            throw new BadRequestHttpException('参数错误');
        }
        return $schoolId;
    }
}
