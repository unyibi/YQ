<?php


namespace App\Services\Api;


use App\Models\APi\Picture;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PictureService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class PictureService extends CommonService
{
    /**
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @param array $columnUuid
     * @return Builder[]|Collection
     */
    public function getPicture(array $condition, int $page, int $pageSize, array $columnUuid)
    {
        $sql = Picture::query();
        if(!empty($columnUuid)){
            $sql->whereJsonContains("column_uuid", $columnUuid);
        }
        return $sql->where($condition)->forPage($page,$pageSize)->orderByDesc('is_top')->orderBy('sort')->orderByDesc('id')->get();
    }

    /**
     * @param array $condition
     * @param array $columnUuid
     * @return int
     */
    public function getPictureCount(array $condition,array $columnUuid): int
    {
        $sql = Picture::query();
        if(!empty($columnUuid)){
            $sql->whereJsonContains("column_uuid", $columnUuid);
        }
        return $sql->where($condition)->count();
    }


    /**
     * @param string $uuid
     * @return Builder|Model|object|null
     */
    public function getPictureDetail(string $uuid)
    {
        return Picture::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function addPicture($data)
    {
        return Picture::query()->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function editPicture(string $uuid, array $data): bool
    {
        $picture = Picture::query()->where(['uuid' => $uuid])->first();
        if(is_null($picture)){
            return false;
        }
        foreach($data as $k => $item) {
            $picture->$k = $item;
        }
        return $picture->save();
    }

    /**
     * @param array $uuid
     * @return bool
     */
    public function softDeletePicture(array $uuid): bool
    {
        /**
         * @var $picture Picture
         */
        $picture = Picture::query()->where(['uuid' => $uuid])->get();
        if($picture->isEmpty()){
            return false;
        }
        foreach ($picture as $item){
            $item->is_del = 1;
            $item->save();
        }
        return true;
    }

    /**
     * @param string $uuid
     * @param int $sort
     * @return bool
     */
    public function sortPicture(string $uuid, int $sort): bool
    {
        /**
         * @var $picture Picture
         */
        $picture = Picture::query()->where(['uuid' => $uuid])->first();
        if(is_null($picture)){
            return false;
        }
        $picture->sort = $sort;
        return $picture->save();
    }


    /**
     * @param string $uuid
     * @param int $isTop
     * @return bool
     */
    public function topPicture(string $uuid, int $isTop): bool
    {
        /**
         * @var $picture Picture
         */
        $picture = Picture::query()->where(['uuid' => $uuid])->first();
        if(is_null($picture)){
            return false;
        }
        $picture->is_top = $isTop;
        return $picture->save();
    }
}
