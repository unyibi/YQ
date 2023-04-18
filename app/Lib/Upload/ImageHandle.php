<?php
namespace App\Lib\Upload;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ImageHandle
 * @author yee
 * @date 2023/4/18
 * @package App\Lib\Upload
 */
class ImageHandle
{
    //定义一个允许的后缀名属性
    private $allowExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * @param $file
     * @param string $folder
     * @param string $filePrefix
     * @param int $maxWidth
     * @return string[]
     * @throws FileNotFoundException
     */
    public function save($file, string $folder = 'default', string $filePrefix = 'image', int $maxWidth = 0): array
    {
        //进行后缀名的验证,如果没有那么就默认为png
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        if(!in_array($extension, $this->allowExt)) {
            throw new BadRequestHttpException('不支持的文件格式');
        }
        //定义存储路径，文件夹切割能让查找效率更高
        $folderName = "storage/images/" . $folder . "/" .date("Ym/d", time());
        $uploadPath = public_path() . "/" . $folderName;
        //定义文件名
        $fileName = $filePrefix . "_" . time() . "_" . uniqid() . "." . $extension;
        //将图片移动到目标储存位置
        $file->move($uploadPath, $fileName);
        //如果限制了图片宽度，就进行裁剪
        $uploadFile = $uploadPath . "/" . $fileName;
        $folderFile =  "/" . $folderName . "/" . $fileName;
        if ($maxWidth > 0 && $extension != 'gif') {
            // 此类封装的函数，用于裁剪图片
            $image = $this->reduceSize($uploadFile, $maxWidth);
        }else{
            $image = Image::make($uploadFile);
        }
        return [
            'image_url'         => env('APP_URL') . $folderFile,
            'image_path'        => $folderFile,
            'image_width'       => $image->width(),
            'image_height'      => $image->height(),
            'image_size'        => $image->filesize(),
            'image_mime'        => $image->mime(),
            'image_extension'   => $extension,
        ];
    }

    /**
     * 图片裁剪
     * @param $fileName
     * @param $maxWidth
     * @return \Intervention\Image\Image
     */
    public function reduceSize($fileName, $maxWidth): \Intervention\Image\Image
    {
        //先实例化，参数是图片物理路径
        $image = Image::make($fileName);
        //将图片的大小进行调整
        $image->resize($maxWidth, null, function($constraint) {
            //设定宽度 $maxWidth, 高度等比例双方缩放
            $constraint->aspectRatio();
            //防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        //对图片进行保存
        $image->save();
        return $image;
    }

}
