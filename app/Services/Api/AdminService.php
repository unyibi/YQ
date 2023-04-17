<?php


namespace App\Services\Api;


use App\Models\Api\Admin;
use App\Models\Api\AdminRole;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class AdminService extends CommonService
{
    /**
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @return Builder[]|Collection
     */
    public function getAdmin(array $condition, int $page, int $pageSize)
    {
        return Admin::query()->where($condition)->where(['is_super' => 0])->forPage($page,$pageSize)->orderByDesc('id')->get();
    }

    /**
     * @param array $condition
     * @return int
     */
    public function getAdminCount(array $condition): int
    {
        return Admin::query()->where($condition)->where(['is_super' => 0])->count();
    }


    /**
     * @param string $uuid
     * @return Admin
     */
    public function getAdminDetail(string $uuid): Admin
    {
        /**
         * @var Admin
         */
        return Admin::query()->where(['uuid' => $uuid])->with(['roles' => function ($query) {
            $query->select(['roles.id','uuid', 'role'])->where('status', '=', 1);
        }])->first();
    }

    /**
     * @param $data
     * @param $roleUuid
     * @return Admin
     */
    public function addAdmin($data,$roleUuid): Admin
    {
        $admin = new Admin();
        /**
         * @var $res Admin
         */
        $res = $admin->query()->create($data);
        $admin->roleAdmin()->attach($roleUuid,['admin_uuid' => $res->uuid]);
        return $res;
    }

    /**
     * @param string $uuid
     * @param array $data
     * @param $roleUuid
     * @return bool
     */
    public function editAdmin(string $uuid, array $data, $roleUuid): bool
    {
        /**
         * @var $admin Admin
         */
        $admin = Admin::query()->where(['uuid' => $uuid, 'is_super' => 0])->first();
        if(is_null($admin)){
            return false;
        }
        foreach($data as $k => $item) {
            $admin->$k = $item;
        }
        if(!empty($roleUuid)){
            AdminRole::query()->where(['admin_uuid' => $uuid])->delete();
            $admin->roleAdmin()->attach($roleUuid, ['admin_uuid' => $uuid]);
        }
        return $admin->save();
    }

    /**
     * @param array $uuid
     * @return bool
     */
    public function deleteAdmin(array $uuid): bool
    {
        /**
         * @var $admin Admin
         */
        $admin = Admin::query()->where(['uuid' => $uuid, 'is_super' => 0])->get();
        if($admin->isEmpty()){
            return false;
        }
        AdminRole::query()->where(['admin_uuid' => $uuid])->delete();
        foreach ($admin as $item){
            $item->delete();
        }
        return true;
    }
}
