<?php


namespace App\Services\Center;


use App\Models\Center\Role;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * @return Builder|Model|object|null
     */
    public function getRoleDetail(string $uuid)
    {
        return Role::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function addRole($data)
    {
        return Role::query()->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function editRole(string $uuid, array $data): bool
    {
        $role = Role::query()->where(['uuid' => $uuid])->first();
        if(is_null($role)){
            return false;
        }
        foreach($data as $k => $item) {
            $role->$k = $item;
        }
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
        foreach ($role as $item){
            $item->delete();
        }
        return true;
    }
}
