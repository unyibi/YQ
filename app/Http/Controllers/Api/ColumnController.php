<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\ColumnPost;
use App\Services\Api\ColumnService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ColumnController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class ColumnController extends BaseController
{

    protected $columnService;

    public function __construct(ColumnService $columnService)
    {
        $this->columnService = $columnService;
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
        $name = $request->get('name','');
        $property = $request->get('property',1);
        $pid = $request->get('pid',0);
        $where[] = ['is_del', '=', 0];
        $where[] = ['pid', '=', $pid];
        if(!empty($name)){
            $where[] = ['name', 'like', "%$name%"];
        }
        if(!empty($property)){
            $where[] = ['property', '=', $property];
        }
        $res = $this->columnService->getColumn($where, $page, $pageSize);
        $total = $this->columnService->getColumnCount($where);
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
        $res = $this->columnService->getColumnDetail($uuid);
        return $this->success($res);
    }

    /**
     * 新增
     * @param ColumnPost $request
     * @return JsonResponse
     */
    public function save(ColumnPost $request): JsonResponse
    {
        $pid = $request->post('pid',0);
        $name = $request->post('name','');
        $showReleaseTime = $request->post('show_release_time',1);
        $type = $request->post('type',[]);
        $sort = $request->post('sort',1);
        $property = $request->post('property',1);
        $showApp = $request->post('show_app',[]);
        $data = [
            'pid' => $pid,
            'name' => $name,
            'show_release_time' => $showReleaseTime,
            'type' => $type,
            'property' => $property,
            'sort' => $sort,
            'show_app' => $showApp,
        ];
        $res = $this->columnService->addColumn($data);
        return $this->success($res,'添加成功');
    }


    /**
     * 编辑
     * @param ColumnPost $request
     * @param $uuid
     * @return JsonResponse
     */
    public function update(ColumnPost $request, $uuid): JsonResponse
    {
        $pid = $request->post('pid',0);
        $name = $request->post('name','');
        $showReleaseTime = $request->post('show_release_time',1);
        $type = $request->post('type',[]);
        $sort = $request->post('sort',1);
        $property = $request->post('property',1);
        $showApp = $request->post('show_app',[]);
        $data = [
            'pid' => $pid,
            'name' => $name,
            'show_release_time' => $showReleaseTime,
            'type' => $type,
            'property' => $property,
            'sort' => $sort,
            'show_app' => $showApp,
        ];
        $res = $this->columnService->editColumn($uuid, $data);
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
        $res = $this->columnService->softDeleteColumn($uuid);
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
        $res = $this->columnService->sortColumn($uuid, $sort);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'排序修改成功');
    }
}
