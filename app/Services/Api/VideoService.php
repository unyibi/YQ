<?php


namespace App\Services\Api;


use App\Models\APi\Video;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VideoService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class VideoService extends CommonService
{
    /**
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @param array $columnUuid
     * @return Builder[]|Collection
     */
    public function getVideo(array $condition, int $page, int $pageSize, array $columnUuid)
    {
        $sql = Video::query();
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
    public function getVideoCount(array $condition,array $columnUuid): int
    {
        $sql = Video::query();
        if(!empty($columnUuid)){
            $sql->whereJsonContains("column_uuid", $columnUuid);
        }
        return $sql->where($condition)->count();
    }


    /**
     * @param string $uuid
     * @return Builder|Model|object|null
     */
    public function getVideoDetail(string $uuid)
    {
        return Video::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function addVideo($data)
    {
        return Video::query()->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function editVideo(string $uuid, array $data): bool
    {
        $video = Video::query()->where(['uuid' => $uuid])->first();
        if(is_null($video)){
            return false;
        }
        foreach($data as $k => $item) {
            $video->$k = $item;
        }
        return $video->save();
    }

    /**
     * @param array $uuid
     * @return bool
     */
    public function softDeleteVideo(array $uuid): bool
    {
        /**
         * @var $video Video
         */
        $video = Video::query()->where(['uuid' => $uuid])->get();
        if($video->isEmpty()){
            return false;
        }
        foreach ($video as $item){
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
    public function sortVideo(string $uuid, int $sort): bool
    {
        /**
         * @var $video Video
         */
        $video = Video::query()->where(['uuid' => $uuid])->first();
        if(is_null($video)){
            return false;
        }
        $video->sort = $sort;
        return $video->save();
    }


    /**
     * @param string $uuid
     * @param int $isTop
     * @return bool
     */
    public function topVideo(string $uuid, int $isTop): bool
    {
        /**
         * @var $video Video
         */
        $video = Video::query()->where(['uuid' => $uuid])->first();
        if(is_null($video)){
            return false;
        }
        $video->is_top = $isTop;
        return $video->save();
    }
}
