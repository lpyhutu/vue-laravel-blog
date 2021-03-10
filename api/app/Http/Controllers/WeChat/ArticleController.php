<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Models\FrontArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $article;

    public function __construct()
    {
        $this->article = new FrontArticle();
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->article->getRelease($start, $pageSize);
    }

    /**
     * 详情
     * @param IdRequest $request
     * @return array
     */
    public function detail(IdRequest $request)
    {
        $id = $request->input("id");
        $uid = $request->input("uid");
        return $this->article->detail($id, $uid);
    }

    /**
     * 点赞
     * @param IdRequest $request
     * @return array
     */
    public function thumb(IdRequest $request)
    {
        $id = $request->input("id");
        $uid = $request->input("uid");
        return $this->article->thumb($id, $uid);
    }

    /**
     * 获取当前类别文章
     * @param Request $request
     * @return array
     */
    public function currentTypeArticle(Request $request)
    {
        $type = $request->input("type");
        return $this->article->currentType($type);
    }

    /**
     * 搜索
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $title = $request->input("title", "");
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->article->search($title, $start, $pageSize);
    }
}
