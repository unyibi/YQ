<?php

namespace App\Models\Api;

use App\Models\UuidTrait;
use Commons\Utilities\StringHelper;
use  Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Articles
 * @property integer $id
 * @property string $uuid uuid唯一标识
 * @property integer $school_id 学校id
 * @property array $column_uuid 所属栏目
 * @property string $title 标题
 * @property string $sub_title 副标题
 * @property string $image_url 图片地址
 * @property string $content 文章内容
 * @property integer $is_top 是否置顶
 * @property integer $is_del 是否删除
 * @property integer $sort 排序
 * @property string $release_time 发布时间
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $url_md5 爬虫加密链接
 * @property integer $jump_type 跳转外部链接类型：0不跳转1网页2文档
 * @property string $jump_url 跳转地址
 * @property integer $views_num 浏览量
 * @property array $show_app 展示端：8官网 9微信 10支付宝 11抖音 12百度 13QQ
 * @property integer $is_show 是否展示：0否 1是
 * @property integer $is_draft 是否设为草稿：0否 1是
 * @property string $timing_send 定时发送
 * @author yee
 * @date 2023/4/12
 * @package App\Models
 * @method object isEmpty() 判断对象是否为空
 */
class Article extends BaseModel
{
    use HasFactory;
    use UuidTrait;

    public $timestamps = false;

    protected $fillable = [
        'title', 'sub_title', 'image_url', 'content', 'is_top', 'sort', 'column_uuid', 'school_id', 'show_app', 'release_time', 'url_md5', 'jump_type', 'jump_url', 'views_num', 'is_show', 'is_draft', 'timing_send'
    ];

    protected $casts = [
        'column_uuid' => 'array',
        'show_app' => 'array',
    ];

    protected $hidden = [
        'is_del','create_time'
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

    /**
     * 跳转地址
     * @param $value
     * @return void
     */
    public function setJumpUrlAttribute($value): string
    {
        $this->attributes['jump_url'] = StringHelper::convertNullStringsToEmpty(($value));
    }
}
