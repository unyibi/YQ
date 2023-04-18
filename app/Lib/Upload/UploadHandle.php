<?php


namespace App\Lib\Upload;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * 文件分片上传
 * Class UploadHandle
 * @author yee
 * @date 2023/4/18
 * @package App\Lib\Upload
 */
class UploadHandle
{
    protected $image = [
        'png', 'jpeg', 'jpg', 'gif', 'webp', 'bmp'
    ];
    protected $imageMaxSize = 5242880;//最大5M
    protected $txt = [
        'docx', 'doc', 'txt', 'wps', 'pdf', 'zip', 'rar', 'html', 'rtf'
    ];
    protected $txtMaxSize = 524288000;//最大500M
    protected $video = [
        'mp4', 'avi', 'mpg', 'mpeg', 'mov', 'swf'
    ];
    protected $videoMaxSize = 2621440000;//最大2500M
    protected $fileFolder = 'default';
    protected $maxSize = 0;

    /**
     * @param $file
     * @param int $blockId
     * @param int $blockTot
     * @param string $folder
     * @param string $filePrefix
     * @param string $uuid
     * @return array|string[]
     * @throws FileNotFoundException
     */
    public function upload($file, int $blockId = 0, int $blockTot = 1, string $folder = 'default', string $filePrefix = 'default', string $uuid = ''): array
    {
        //进行后缀名的验证
        $extension = strtolower($file->getClientOriginalExtension()) ?: '';
        $this->formatFileFolderAndMaxSize($extension, $blockTot);
        $fileSize = $file->getSize();
        if ($fileSize > $this->maxSize) {
            throw new BadRequestHttpException('文件过大，请压缩后上传');
        }
        //定义存储路径，文件夹切割能让查找效率更高
        $folderName = "{$this->fileFolder}/{$folder}/" . date("Ym/d", time());
        //定义文件名
        $fileName = $filePrefix . "_" . time() . "_" . uniqid() . "." . $extension;
        $tempDirName = "upload_big_temp/" . $uuid;
        existsStorageDir($tempDirName);
        existsStorageDir($folderName);
        $tempSaveDir = Storage::disk('public')->path($tempDirName);
        $uploadPath = Storage::disk('public')->path($folderName);
        $file->move($tempSaveDir, $blockId); //以块号为名保存当前块
        $block = Storage::disk('public')->files($tempDirName);
        if (count($block) == $blockTot) {  //整个文件上传完成
            for ($i = 0; $i < $blockTot; $i++) {
                $content = Storage::disk('public')->get($tempDirName . '/' . $i);
                file_put_contents($uploadPath . '/' . $fileName, $content, $i ? FILE_APPEND : FILE_TEXT);//追加:覆盖
            }
            Storage::disk('public')->deleteDirectory($tempDirName); //删除临时文件
            return [
                'file_url'          => env('APP_URL') . '/storage/' . $folderName . '/' . $fileName,
                'file_path'         => '/storage/' . $folderName . '/' . $fileName,
                'file_size'         => $fileSize,
                'file_extension'    => $extension,
                'file_name'         => $fileName,
            ];
        }
        return [];
    }

    /**
     * 通过后缀判断文件格式化文件夹和限制文件大小
     * @param $extension
     * @param $blockTot
     * @return void
     */
    private function formatFileFolderAndMaxSize($extension, $blockTot): void
    {
        if (in_array($extension, $this->image)) {
            $this->fileFolder = 'images';
            $this->maxSize = intval($this->imageMaxSize / $blockTot) ;
        }elseif (in_array($extension, $this->txt)){
            $this->fileFolder = 'documents';
            $this->maxSize = intval($this->txtMaxSize / $blockTot);
        }elseif (in_array($extension, $this->video)){
            $this->fileFolder = 'videos';
            $this->maxSize = intval($this->videoMaxSize / $blockTot);
        }else{
            throw new BadRequestHttpException('不支持的文件格式');
        }
    }
}
