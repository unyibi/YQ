<?php


namespace App\Http\Controllers\Center;


use App\Http\Requests\RolePost;
use App\Http\Requests\RoleUpdatePost;
use App\Services\Center\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class RoleController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class RoleController extends BaseController
{

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
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
        $role = $request->get('role','');
        $status = $request->get('status','');
        $where = [];
        if(!empty($role)){
            $where[] = ['role', 'like', "%$role%"];
        }
        if($status !== ''){
            $where[] = ['status', '=', $status];
        }
        $role = $this->roleService->getRole($where, $page, $pageSize);
        $total = $this->roleService->getRoleCount($where);
        $data = [
            'list' => $role,
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
        $article = $this->roleService->getRoleDetail($uuid);
        return $this->success($article);
    }

    /**
     * 新增
     * @param RolePost $request
     * @return JsonResponse
     */
    public function save(RolePost $request): JsonResponse
    {
        $role = $request->post('role','');
        $desc = $request->post('desc','');
        $status = $request->post('status',1);
        $data = [
            'role' => $role,
            'desc' => $desc,
            'status' => $status
        ];
        $this->roleService->addRole($data);
        return $this->success([],'添加成功');
    }


    /**
     * 编辑
     * @param RoleUpdatePost $request
     * @param $uuid
     * @return JsonResponse
     */
    public function update(RoleUpdatePost $request, $uuid): JsonResponse
    {
        $role = $request->post('role','');
        $desc = $request->post('desc','');
        $status = $request->post('status',1);
        $data = [
            'role' => $role,
            'desc' => $desc,
            'status' => $status
        ];
        $res = $this->roleService->editRole($uuid, $data);
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
        $res = $this->roleService->deleteRole($uuid);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'删除成功');
    }
}
