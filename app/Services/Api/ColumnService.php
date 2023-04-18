<?php


namespace App\Services\Api;


use App\Models\APi\Column;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ColumnService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class ColumnService extends CommonService
{
    /**
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @return Builder[]|Collection
     */
    public function getColumn(array $condition, int $page, int $pageSize)
    {
        return Column::query()->where($condition)->forPage($page,$pageSize)->orderBy('sort')->orderByDesc('id')->get();
    }

    /**
     * @param array $condition
     * @return int
     */
    public function getColumnCount(array $condition): int
    {
        return Column::query()->where($condition)->count();
    }


    /**
     * @param string $uuid
     * @return Builder|Model|object|null
     */
    public function getColumnDetail(string $uuid)
    {
        return Column::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function addColumn($data)
    {
        return Column::query()->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function editColumn(string $uuid, array $data): bool
    {
        $column = Column::query()->where(['uuid' => $uuid])->first();
        if(is_null($column)){
            return false;
        }
        foreach($data as $k => $item) {
            $column->$k = $item;
        }
        return $column->save();
    }

    /**
     * @param array $uuid
     * @return bool
     */
    public function softDeleteColumn(array $uuid): bool
    {
        /**
         * @var $column Column
         */
        $column = Column::query()->where(['uuid' => $uuid])->get();
        if($column->isEmpty()){
            return false;
        }
        foreach ($column as $item){
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
    public function sortColumn(string $uuid, int $sort): bool
    {
        /**
         * @var $column Column
         */
        $column = Column::query()->where(['uuid' => $uuid])->first();
        if(is_null($column)){
            return false;
        }
        $column->sort = $sort;
        return $column->save();
    }
}
