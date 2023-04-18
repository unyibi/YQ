<?php
/*
 * 自定义公共函数
 */

use Illuminate\Support\Facades\Storage;

/**
 * 校验storage/app/public下的文件夹是否存在，不存在就创建
 * @param $dir
 * @return bool
 */
function existsStorageDir($dir): bool
{
    if (!Storage::disk('public')->exists($dir)) {
        Storage::disk('public')->makeDirectory($dir);
    }
    return true;
}
