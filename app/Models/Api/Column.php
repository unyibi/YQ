<?php

namespace App\Models\Api;


/**
 * Class Column
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property string $name 名称
 * @property integer $show_release_time 是否展示发布时间：0不展示 1展示
 * @property integer $pid 上级栏目id
 * @property array $type 栏目类型：1招生 2就业（支持多选）
 * @property integer $property 栏目属性：1文章 2图片 3视频
 * @property integer $is_del 是否删除
 * @property integer $sort 排序
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property array $show_app 平台：1官网 2微信 3抖音 4百度 5支付宝 6QQ
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class Column extends BaseModel
{
    protected $fillable = [
        'name', 'show_release_time', 'pid', 'type', 'property', 'sort', 'show_app'
    ];

    protected $casts = [
        'type' => 'array',
        'show_app' => 'array',
    ];

    protected $hidden = [
        'is_del', 'create_time'
    ];

}
