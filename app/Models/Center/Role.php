<?php

namespace App\Models\Center;


/**
 * Class Role
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property string $role 角色
 * @property string $desc 描述
 * @property integer $status 状态
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class Role extends BaseModel
{
    protected $fillable = [
        'role', 'desc', 'status'
    ];

    protected $hidden = [
        'create_time'
    ];
}
