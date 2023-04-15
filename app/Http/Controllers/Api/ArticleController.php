<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\ArticlePost;
use App\Services\Api\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ArticleController
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers\Api
 */
class ArticleController extends BaseController
{

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
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
        $title = $request->get('title','');
        $columnUuid = $request->get('column_uuid',[]);
        $where[] = ['is_del', '=', 0];
        $where[] = ['title', 'like', "%$title%"];
        if(!empty($columnUuid)){
            $columnUuid = array_map('intval', explode(',',$columnUuid));
        }
        $articles = $this->articleService->getArticle($where, $page, $pageSize, $columnUuid);
        $total = $this->articleService->getArticleCount($where, $columnUuid);
        $data = [
            'list' => $articles,
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
        $article = $this->articleService->getArticleDetail($uuid);
        return $this->success($article);
    }

    /**
     * 新增
     * @param ArticlePost $request
     * @return JsonResponse
     */
    public function save(ArticlePost $request): JsonResponse
    {
        $columnUuid = $request->post('column_uuid',[]);
        $title = $request->post('title','');
        $subTitle = $request->post('sub_title','');
        $imageUrl = $request->post('image_url','');
        $content = $request->post('content','');
        $isTop = $request->post('is_top',0);
        $sort = $request->post('sort',1);
        $releaseTime = $request->post('release_time','');
        $jumpType = $request->post('jump_type',0);
        $jumpUrl = $request->post('jump_url','');
        $showApp = $request->post('show_app',[]);
        $isShow = $request->post('is_show',1);
        $isDraft = $request->post('is_draft',0);
        $timingSend = $request->post('timing_send','');
        $data = [
            'column_uuid' => $columnUuid,
            'title' => $title,
            'sub_title' => $subTitle,
            'image_url' => $imageUrl,
            'content' => $content,
            'is_top' => $isTop,
            'sort' => $sort,
            'release_time' => $releaseTime,
            'jump_type' => $jumpType,
            'jump_url' => $jumpUrl,
            'show_app' => $showApp,
            'is_show' => $isShow,
            'is_draft' => $isDraft,
            'timing_send' => $timingSend,
        ];
        $this->articleService->addArticle($data);
        return $this->success([],'添加成功');
    }


    /**
     * 编辑
     * @param ArticlePost $request
     * @param $uuid
     * @return JsonResponse
     */
    public function update(ArticlePost $request, $uuid): JsonResponse
    {
        $columnUuid = $request->post('column_uuid',[]);
        $title = $request->post('title','');
        $subTitle = $request->post('sub_title','');
        $imageUrl = $request->post('image_url','');
        $content = $request->post('content','');
        $isTop = $request->post('is_top',0);
        $sort = $request->post('sort',1);
        $releaseTime = $request->post('release_time','');
        $jumpType = $request->post('jump_type',0);
        $jumpUrl = $request->post('jump_url','');
        $showApp = $request->post('show_app',[]);
        $isShow = $request->post('is_show',1);
        $isDraft = $request->post('is_draft',0);
        $timingSend = $request->post('timing_send','');
        $data = [
            'column_uuid' => $columnUuid,
            'title' => $title,
            'sub_title' => $subTitle,
            'image_url' => $imageUrl,
            'content' => $content,
            'is_top' => $isTop,
            'sort' => $sort,
            'release_time' => $releaseTime,
            'jump_type' => $jumpType,
            'jump_url' => $jumpUrl,
            'show_app' => $showApp,
            'is_show' => $isShow,
            'is_draft' => $isDraft,
            'timing_send' => $timingSend,
        ];
        $res = $this->articleService->editArticle($uuid, $data);
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
        $res = $this->articleService->softDeleteArticle($uuid);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'删除成功');
    }

    /**
     * 排序
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function sort(Request $request, $uuid): JsonResponse
    {
        $sort = $request->post('sort',1);
        $res = $this->articleService->sortArticle($uuid, $sort);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        return $this->success([],'排序修改成功');
    }

    /**
     * 置顶
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function top(Request $request, $uuid): JsonResponse
    {
        $isTop = $request->post('is_top',1);
        $res = $this->articleService->topArticle($uuid, $isTop);
        if(!$res){
            throw new BadRequestHttpException('参数错误');
        }
        $message = $isTop == 0 ? '取消置顶成功' : '置顶成功';
        return $this->success([],$message);
    }
}
