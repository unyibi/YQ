<?php

namespace App\Models\Api;


/**
 * Class Permission
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property integer $pid 角色
 * @property string $title 标题
 * @property string $name 名称
 * @property integer $is_show 是否显示：1显示 0隐藏
 * @property integer $sort 排序
 * @property string $url 路径
 * @property integer $navigation 前端是否显示导航：0否 1是
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class Permission extends BaseModel
{
    protected $fillable = [
        'pid', 'title', 'name', 'is_show', 'sort', 'url', 'navigation'
    ];
}
