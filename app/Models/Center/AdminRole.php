<?php

namespace App\Models\Center;


/**
 * Class AdminRole
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property string $admin_uuid 账号uuid
 * @property string $role_uuid 角色uuid
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class AdminRole extends BaseModel
{
    protected $fillable = [
        'admin_uuid', 'role_uuid'
    ];
}
