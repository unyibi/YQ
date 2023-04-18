<?php

namespace App\Models\Api;

use Commons\Utilities\StringHelper;

/**
 * Class Picture
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property array $column_uuid 所属栏目
 * @property string $title 标题
 * @property string $image_url 图片地址
 * @property string $content 内容
 * @property integer $is_top 是否置顶
 * @property integer $is_del 是否删除
 * @property integer $sort 排序
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $release_time 发布时间
 * @property integer $views_num 浏览量
 * @property array $show_app 平台：1官网 2微信 3抖音 4百度 5支付宝 6QQ
 * @property integer $is_show 是否展示：0否 1是
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class Picture extends BaseModel
{
    protected $fillable = [
        'title', 'image_url', 'content', 'is_top', 'sort', 'column_uuid', 'show_app', 'release_time', 'views_num', 'is_show'
    ];

    protected $casts = [
        'column_uuid' => 'array',
        'show_app' => 'array',
    ];

    protected $hidden = [
        'is_del', 'create_time'
    ];

    /**
     * 图片地址
     * @param string $value
     * @return string
     */
    public function getImageUrlAttribute(string $value): string
    {
        return StringHelper::formatImageToFull(($value));
    }

    /**
     * 图片地址
     * @param string $value
     * @return void
     */
    public function setImageUrlAttribute(string $value): void
    {
        $this->attributes['image_url'] = StringHelper::formatImageToPath(($value));
    }

}
