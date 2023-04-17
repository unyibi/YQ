<?php

namespace App\Models\Api;


/**
 * Class RolePermission
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property string $permission_uuid 菜单uuid
 * @property string $role_uuid 角色uuid
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class RolePermission extends BaseModel
{
    protected $fillable = [
        'permission_uuid', 'role_uuid'
    ];
}
