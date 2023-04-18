<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\UploadPost;
use App\Lib\Upload\ImageHandle;
use App\Lib\Upload\UploadHandle;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UploadFileController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class UploadController extends BaseController
{

    /**
     * 文件上传
     * @param UploadPost $request
     * @param UploadHandle $uploader
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function file(UploadPost $request,UploadHandle $uploader): JsonResponse
    {
        $file = $request->file('file','');
        $folder = $request->post('folder','default');
        $filePrefix = $request->post('file_prefix','default');
        $blockId = $request->post('block_id',0);
        $blockTot = $request->post('block_tot',1);
        $uuid = $request->post('uuid','');
        $result = $uploader->upload($file, $blockId, $blockTot, $folder, $filePrefix, $uuid);
        return $this->success($result);
    }

    /**
     * 图片上传
     * @param Request $request
     * @param ImageHandle $uploader
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function image(Request $request,ImageHandle $uploader): JsonResponse
    {
        $image = $request->file('image','');
        $folder = $request->post('folder','default');
        $filePrefix = $request->post('file_prefix','image');
        $maxWidth = $request->post('max_width',0);
        $result = $uploader->save($image, $folder, $filePrefix, $maxWidth);
        return $this->success($result);
    }

}
