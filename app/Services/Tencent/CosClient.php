<?php


namespace App\Services\Tencent;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\CommonService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CosClient extends CommonService
{
    private $schoolId;

    protected $savePathPattern = 'uploads/%s/%s';

    protected $driverName = 'cos';

    public function setSchoolId($schoolId): CosClient
    {
        $this->schoolId = $schoolId;
        return $this;
    }

    public function setSavePath($path): CosClient
    {
        if (empty($path)) {
            return $this;
        }
        $path = ltrim($path, '/');
        $path = rtrim($path, '/');
        $this->savePathPattern = $path . '/%s/%s';
        return $this;
    }

    public function compressAndUpload(UploadedFile $uploadFile, $width, $height)
    {
        // 如果是gif动图，直接上传到cos
        $savePath = sprintf($this->savePathPattern, $this->schoolId, date("Ymd"));
        if ($this->didUploadDirectly($uploadFile)) {
            $fileUrl = $uploadFile->store($savePath, $this->driverName);
            return [$fileUrl, Storage::disk($this->driverName)->url($fileUrl)];
        }

        if (empty($width)) {
            throw new BadRequestHttpException("the image width can not be empty");
        }

        $filePath = $uploadFile->store("upload");
        $filePathArr = explode('/', $filePath);
        $fileName = array_pop($filePathArr);
        $fileNameArr = explode('.', $fileName);
        return $this->compressLocalImage($filePath, $width, $height, $fileNameArr[0]);
    }

    public function uploadByUrl($imgUrl, $width, $height)
    {
        if (empty($imgUrl)) {
            throw new BadRequestHttpException("图片URL不能为空");
        }

        $suffix = $this->getSuffix($imgUrl);
        $fileName = Str::random();
        $savePath = sprintf($this->savePathPattern, $this->schoolId, date("Ymd"));
        $filePath = sprintf("%s/%s.%s", $savePath, $fileName, $suffix);
        if ($suffix == 'gif' || $this->getFilesize($imgUrl) < 100) {
            Storage::disk($this->driverName)->put($filePath, file_get_contents($imgUrl));
            return [$filePath, Storage::disk($this->driverName)->url($filePath)];
        }
        Storage::put($filePath, file_get_contents($imgUrl));
        return $this->compressLocalImage($filePath, $width, $height, $fileName);
    }

    public function deleteByPath($filePath)
    {
        if (empty($filePath)) {
            throw new BadRequestHttpException("图片路径不能为空");
        }
        Storage::disk($this->driverName)->delete($filePath);
    }

    private function compressLocalImage($localPath, $width, $height, $fileName)
    {
        $fullPath = Storage::path($localPath);
        if (empty($height)) {
            list($w, $h) = $this->getImgSize($fullPath);
            $height = ceil(($width * $h)/$w);
        }

        $this->compress($fullPath, $width, $height);
        Storage::delete($localPath);
        $compressFile = sprintf("/tmp/%s.jpg", $fileName);
        $savePath = sprintf($this->savePathPattern, $this->schoolId, date("Ymd"));
        if (file_exists($compressFile)) {
            $savePath = sprintf("%s/%s.jpg", $savePath, $fileName);
            Storage::disk($this->driverName)->put($savePath, file_get_contents($compressFile));
//            Storage::delete($compressFile);
            unlink($compressFile);
            return [$savePath, Storage::disk($this->driverName)->url($savePath)];
        }
        return false;
    }

    private function compress($filePath, $width, $height)
    {
        $cmd = <<<CMD
/usr/local/node/bin/squoosh-cli --resize '{"enabled":true,"width":{$width},"height":{$height},"method":"lanczos3","fitMethod":"stretch","premultiply":true,"linearRGB":true}' --mozjpeg '{"quality":85,"baseline":false,"arithmetic":false,"progressive":true,"optimize_coding":true,"smoothing":0,"color_space":3,"quant_table":3,"trellis_multipass":false,"trellis_opt_zero":false,"trellis_opt_table":false,"trellis_loops":1,"auto_subsample":true,"chroma_subsample":2,"separate_chroma_quality":false,"chroma_quality":75}' -d '/tmp' {$filePath} 2>&1
CMD;
        shell_exec($cmd);
    }

    private function didUploadDirectly(UploadedFile $uploadFile): bool
    {
        $extension = Str::lower($uploadFile->getClientOriginalExtension());

        return $extension == 'gif' || (($uploadFile->getSize()/1024) < 100);
    }

    /**
     * 返回图片大小，单位kb
     * @param $filename
     * @return float|int
     */
    private function getFilesize($filename)
    {
        if (filter_var($filename, FILTER_VALIDATE_URL) !== false) {
            list($length, $type) = $this->getImgInfoByUrl($filename);
            return $length/1024;
        } else {
            return filesize($filename)/1024;
        }
    }

    private function getImgMimeInfo($img) {
        return getimagesize($img);
    }

    /**
     * 获取图片的长宽
     * @param $img
     * @return array
     */
    private function getImgSize($img): array
    {
        list($w, $h) = $this->getImgMimeInfo($img);
        return [$w, $h];
    }

    private function getSuffix($img)
    {
        $suffix = false;
        if (filter_var($img, FILTER_VALIDATE_URL) === true) {
            list($length, $type) = $this->getImgInfoByUrl($img);
            $suffix = explode('/',$type)[1];
        } else {
            $mimeInfo = $this->getImgMimeInfo($img);

            if($mime = $mimeInfo['mime']){
                $suffix = explode('/',$mime)[1];
            }
        }

        return $suffix;
    }

    private function getImgInfoByUrl($imgUrl): array
    {
        $headers = get_headers($imgUrl);
        return [Arr::get($headers, 'content-length'), Arr::get($headers, 'content-type')];
    }
}
