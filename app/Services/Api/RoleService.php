<?php


namespace App\Services\Api;


use App\Models\Api\Role;
use App\Models\Api\RolePermission;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class RoleService extends CommonService
{
    /**
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @return Builder[]|Collection
     */
    public function getRole(array $condition, int $page, int $pageSize)
    {
        return Role::query()->where($condition)->forPage($page,$pageSize)->orderByDesc('id')->get();
    }

    /**
     * @param array $condition
     * @return int
     */
    public function getRoleCount(array $condition): int
    {
        return Role::query()->where($condition)->count();
    }


    /**
     * @param string $uuid
     * @return Role
     */
    public function getRoleDetail(string $uuid): Role
    {
        /**
         * @var Role
         */
        return Role::query()->where(['uuid' => $uuid])->with(['permission' => function ($query) {
            $query->where('is_show', '=', 1);
        }])->first();
    }

    /**
     * @param array $data
     * @param array $permissionUuid
     * @return Role
     */
    public function addRole(array $data, array $permissionUuid): Role
    {
        $role = new Role();
        /**
         * @var $res Role
         */
        $res = $role->query()->create($data);
        $role->rolePermission()->attach($permissionUuid,['role_uuid' => $res->uuid]);
        return $res;
    }

    /**
     * @param string $uuid
     * @param array $data
     * @param array $permissionUuid
     * @return bool
     */
    public function editRole(string $uuid, array $data, array $permissionUuid): bool
    {
        /**
         * @var $role Role
         */
        $role = Role::query()->where(['uuid' => $uuid])->first();
        if(is_null($role)){
            return false;
        }
        foreach($data as $k => $item) {
            $role->$k = $item;
        }
        RolePermission::query()->where(['role_uuid' => $uuid])->delete();
        $role->rolePermission()->attach($permissionUuid,['role_uuid' => $uuid]);
        return $role->save();
    }

    /**
     * @param array $uuid
     * @return bool
     */
    public function deleteRole(array $uuid): bool
    {
        /**
         * @var $role Role
         */
        $role = Role::query()->where(['uuid' => $uuid])->get();
        if($role->isEmpty()){
            return false;
        }
        RolePermission::query()->where(['role_uuid' => $uuid])->delete();
        foreach ($role as $item){
            $item->delete();
        }
        return true;
    }
}
