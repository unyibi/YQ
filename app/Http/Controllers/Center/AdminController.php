<?php


namespace App\Http\Controllers\Center;


use App\Http\Requests\AdminPost;
use App\Http\Requests\AdminUpdatePost;
use App\Services\Center\AdminService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class AdminController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class AdminController extends BaseController
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
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
        $status = $request->get('status','');
        $where = [];
        if(!empty($name)){
            $where[] = ['name', 'like', "%$name%"];
        }
        if($status !== ''){
            $where[] = ['status', '=', $status];
        }
        $admin = $this->adminService->getAdmin($where, $page, $pageSize);
        $total = $this->adminService->getAdminCount($where);
        $data = [
            'list' => $admin,
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
        $admin = $this->adminService->getAdminDetail($uuid);
        return $this->success($admin);
    }

    /**
     * 新增
     * @param AdminPost $request
     * @return JsonResponse
     */
    public function save(AdminPost $request): JsonResponse
    {
        $name = $request->post('name','');
        $nickname = $request->post('nickname','');
        $password = $request->post('password','');
        $avatar = $request->post('avatar','');
        $roleUuid = $request->post('role_uuid','');
        $data = [
            'name' => $name,
            'nickname' => $nickname,
            'password' => Hash::make($password),
            'avatar' => $avatar
        ];
        $this->adminService->addAdmin($data,$roleUuid);
        return $this->success([],'添加成功');
    }


    /**
     * 编辑
     * @param AdminUpdatePost $request
     * @param $uuid
     * @return JsonResponse
     */
    public function update(AdminUpdatePost $request, $uuid): JsonResponse
    {
        $name = $request->post('name','');
        $nickname = $request->post('nickname','');
        $avatar = $request->post('avatar','');
        $status = $request->post('status',1);
        $data = [
            'name' => $name,
            'nickname' => $nickname,
            'avatar' => $avatar,
            'status' => $status,
        ];
        $res = $this->adminService->editAdmin($uuid, $data);
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
        $res = $this->adminService->deleteAdmin($uuid);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'删除成功');
    }
}
