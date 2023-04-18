<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\PicturePost;
use App\Services\Api\PictureService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class PictureController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class PictureController extends BaseController
{

    protected $pictureService;

    public function __construct(PictureService $pictureService)
    {
        $this->pictureService = $pictureService;
    }

    /**
     * 列表
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->get('page',1);
        $pageSize = $request->get('page_size',10);
        $title = $request->get('title','');
        $columnUuid = $request->get('column_uuid',[]);
        $where[] = ['is_del', '=', 0];
        if(!empty($title)){
            $where[] = ['title', 'like', "%$title%"];
        }
        if(!empty($columnUuid)){
            $columnUuid = array_map('intval', explode(',',$columnUuid));
        }
        $res = $this->pictureService->getPicture($where, $page, $pageSize, $columnUuid);
        $total = $this->pictureService->getPictureCount($where, $columnUuid);
        $data = [
            'list' => $res,
            'total' => $total,
        ];
        return $this->success($data);
    }

    /**
     * 详情
     * @param Request $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function read(Request $request,string $uuid): JsonResponse
    {
        $res = $this->pictureService->getPictureDetail($uuid);
        return $this->success($res);
    }

    /**
     * 新增
     * @param PicturePost $request
     * @return JsonResponse
     */
    public function save(PicturePost $request): JsonResponse
    {
        $columnUuid = $request->post('column_uuid',[]);
        $title = $request->post('title','');
        $imageUrl = $request->post('image_url','');
        $content = $request->post('content','');
        $isTop = $request->post('is_top',0);
        $sort = $request->post('sort',1);
        $showApp = $request->post('show_app',[]);
        $isShow = $request->post('is_show',1);
        $data = [
            'column_uuid' => $columnUuid,
            'title' => $title,
            'image_url' => $imageUrl,
            'content' => $content,
            'is_top' => $isTop,
            'sort' => $sort,
            'show_app' => $showApp,
            'is_show' => $isShow,
        ];
        $res = $this->pictureService->addPicture($data);
        return $this->success($res,'添加成功');
    }


    /**
     * 编辑
     * @param PicturePost $request
     * @param $uuid
     * @return JsonResponse
     */
    public function update(PicturePost $request, $uuid): JsonResponse
    {
        $columnUuid = $request->post('column_uuid',[]);
        $title = $request->post('title','');
        $imageUrl = $request->post('image_url','');
        $content = $request->post('content','');
        $isTop = $request->post('is_top',0);
        $sort = $request->post('sort',1);
        $showApp = $request->post('show_app',[]);
        $isShow = $request->post('is_show',1);
        $data = [
            'column_uuid' => $columnUuid,
            'title' => $title,
            'image_url' => $imageUrl,
            'content' => $content,
            'is_top' => $isTop,
            'sort' => $sort,
            'show_app' => $showApp,
            'is_show' => $isShow,
        ];
        $res = $this->pictureService->editPicture($uuid, $data);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'编辑成功');
    }

    /**
     * 删除
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $uuid = $request->post('uuid', []);
        $res = $this->pictureService->softDeletePicture($uuid);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'删除成功');
    }

    /**
     * 排序
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function sort(Request $request, $uuid): JsonResponse
    {
        $sort = $request->post('sort',1);
        $res = $this->pictureService->sortPicture($uuid, $sort);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'排序修改成功');
    }

    /**
     * 置顶
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function top(Request $request, $uuid): JsonResponse
    {
        $isTop = $request->post('is_top',1);
        $res = $this->pictureService->topPicture($uuid, $isTop);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        $message = $isTop == 0 ? '取消置顶成功' : '置顶成功';
        return $this->success([],$message);
    }
}
