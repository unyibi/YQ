<?php

namespace Commons\Utilities;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class StringHelper
 * @author yee
 * @date 2022/11/15
 * @package Commons\Utilities
 */
class StringHelper
{
    /**
     * 蛇形命名转小驼峰
     * @param $str
     * @return string
     */
    public static function snakeToLowerCamel($str): string
    {
        return lcfirst(Str::studly($str));
    }

    /**
     * 格式化图片转完整链接
     * @param $url
     * @param string $disk
     * @return string
     */
    public static function formatImageToFull($url, string $disk = 'cos'): string
    {
        if(empty($url)){
            return '';
        }
        $parseUrl = parse_url($url);
        if(isset($parseUrl['host'])){
            return $url;
        }
        return Storage::disk($disk)->url($url);
    }


    /**
     * 格式化图片转路径
     * @param $url
     * @return string
     */
    public static function formatImageToPath($url): string
    {
        if(empty($url)){
            return '';
        }
        $parseUrl = parse_url($url);
        return $parseUrl['path'] ?? $url;
    }

    /**
     * 取模获取连接数据库
     * @param $schoolId
     * @return string
     */
    public static function getDatabase($schoolId): string
    {
        $hashModel = $schoolId % 8;
        return sprintf("station_%s", $hashModel);
    }

    /**
     * null转为空字符串
     * @param $str
     * @return string
     */
    public static function convertNullStringsToEmpty($str): string
    {
        return $str === null ? '' : $str;
    }

}
