<?php


namespace App\Services\Api;


use App\Models\APi\Article;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleService
 * @author yee
 * @date 2023/4/12
 * @package App\Services
 */
class ArticleService extends CommonService
{
    /**
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @param array $columnUuid
     * @return Builder[]|Collection
     */
    public function getArticle(array $condition, int $page, int $pageSize, array $columnUuid)
    {
        $sql = Article::query();
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
    public function getArticleCount(array $condition,array $columnUuid): int
    {
        $sql = Article::query();
        if(!empty($columnUuid)){
            $sql->whereJsonContains("column_uuid", $columnUuid);
        }
        return $sql->where($condition)->count();
    }


    /**
     * @param string $uuid
     * @return Builder|Model|object|null
     */
    public function getArticleDetail(string $uuid)
    {
        return Article::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function addArticle($data)
    {
        return Article::query()->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function editArticle(string $uuid, array $data): bool
    {
        $article = Article::query()->where(['uuid' => $uuid])->first();
        if(is_null($article)){
            return false;
        }
        foreach($data as $k => $item) {
            $article->$k = $item;
        }
        return $article->save();
    }

    /**
     * @param array $uuid
     * @return bool
     */
    public function softDeleteArticle(array $uuid): bool
    {
        /**
         * @var $article Article
         */
        $article = Article::query()->where(['uuid' => $uuid])->get();
        if($article->isEmpty()){
            return false;
        }
        foreach ($article as $item){
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
    public function sortArticle(string $uuid, int $sort): bool
    {
        /**
         * @var $article Article
         */
        $article = Article::query()->where(['uuid' => $uuid])->first();
        if(is_null($article)){
            return false;
        }
        $article->sort = $sort;
        return $article->save();
    }


    /**
     * @param string $uuid
     * @param int $isTop
     * @return bool
     */
    public function topArticle(string $uuid, int $isTop): bool
    {
        /**
         * @var $article Article
         */
        $article = Article::query()->where(['uuid' => $uuid])->first();
        if(is_null($article)){
            return false;
        }
        $article->is_top = $isTop;
        return $article->save();
    }
}
