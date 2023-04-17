<?php


namespace App\Services\Api;


use App\Models\Api\Permission;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class PermissionService extends CommonService
{
    /**
     * @param array $condition
     * @return Builder[]|Collection
     */
    public function getPermission(array $condition)
    {
        return Permission::query()->where($condition)->orderBy('sort')->orderBy('id')->get();
    }

    /**
     * @param array $condition
     * @return int
     */
    public function getPermissionCount(array $condition): int
    {
        return Permission::query()->where($condition)->count();
    }


    /**
     * @param string $uuid
     * @return Builder|Model|object|null
     */
    public function getPermissionDetail(string $uuid)
    {
        return Permission::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function addPermission($data)
    {
        return Permission::query()->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function editPermission(string $uuid, array $data): bool
    {
        $role = Permission::query()->where(['uuid' => $uuid])->first();
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
    public function deletePermission(array $uuid): bool
    {
        /**
         * @var $role Permission
         */
        $role = Permission::query()->where(['uuid' => $uuid])->get();
        if($role->isEmpty()){
            return false;
        }
        foreach ($role as $item){
            $item->delete();
        }
        return true;
    }
}
