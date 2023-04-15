<?php

namespace App\Models\Center;

use Commons\Utilities\StringHelper;

/**
 * Class Admin
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property string $name 账号
 * @property string $nickname 昵称
 * @property string $password 密码
 * @property string $login_time 登录时间
 * @property string $login_ip 登录ip
 * @property string $avatar 头像
 * @property integer $status 状态
 * @property integer $is_super 是否是超级管理员：0否 1是
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class Admin extends BaseModel
{
    protected $fillable = [
        'name', 'nickname', 'password', 'tails', 'login_time', 'login_ip', 'avatar', 'status', 'is_super'
    ];

    protected $hidden = [
        'create_time','is_super','password'
    ];

    /**
     * 用户拥有的角色
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\hasManyThrough
    {
        return $this->hasManyThrough('App\Models\Center\Role','App\Models\Center\AdminRole','admin_uuid','uuid','uuid','role_uuid');
    }

    /**
     * 用户角色关联
     */
    public function roleAdmin(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany('App\Models\Center\Role','App\Models\Center\AdminRole','admin_uuid','role_uuid','uuid','uuid');
    }

    /**
     * 头像地址
     * @param string $value
     * @return string
     */
    public function getAvatarAttribute(string $value): string
    {
        return StringHelper::formatImageToFull(($value));
    }

    /**
     * 头像地址
     * @param string $value
     * @return void
     */
    public function setAvatarAttribute(string $value)
    {
        $this->attributes['avatar'] = StringHelper::formatImageToPath(($value));
    }
}
