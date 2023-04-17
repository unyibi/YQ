<?php


namespace App\Http\Controllers\Api;


use App\Services\Api\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class PermissionController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class PermissionController extends BaseController
{

    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * 列表
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $where = [];
        $permission = $this->permissionService->getPermission($where);
        return $this->success($permission);
    }

    /**
     * 详情
     * @param Request $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function read(Request $request,string $uuid): JsonResponse
    {
        $article = $this->permissionService->getPermissionDetail($uuid);
        return $this->success($article);
    }

    /**
     * 新增
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        $title = $request->post('title','');
        $name = $request->post('name','');
        $isShow = $request->post('is_show',1);
        $pid = $request->post('pid',0);
        $sort = $request->post('sort',1);
        $url = $request->post('url','');
        $navigation = $request->post('navigation',1);
        $data = [
            'title' => $title,
            'name' => $name,
            'is_show' => $isShow,
            'pid' => $pid,
            'sort' => $sort,
            'url' => $url,
            'navigation' => $navigation,
        ];
        $this->permissionService->addPermission($data);
        return $this->success([],'添加成功');
    }


    /**
     * 编辑
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function update(Request $request, $uuid): JsonResponse
    {
        $title = $request->post('title','');
        $name = $request->post('name','');
        $isShow = $request->post('is_show',1);
        $pid = $request->post('pid',0);
        $sort = $request->post('sort',1);
        $url = $request->post('url','');
        $navigation = $request->post('navigation',1);
        $data = [
            'title' => $title,
            'name' => $name,
            'is_show' => $isShow,
            'pid' => $pid,
            'sort' => $sort,
            'url' => $url,
            'navigation' => $navigation,
        ];
        $res = $this->permissionService->editPermission($uuid, $data);
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
        $res = $this->permissionService->deletePermission($uuid);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'删除成功');
    }
}
