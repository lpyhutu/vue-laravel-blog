<?php

namespace App\Http\Controllers\Front;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
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
     * 获取
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $release = $request->input("release", 0);
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->article->getAll($release, $start, $pageSize);
    }

    /**
     * 修改
     * @param ArticleRequest $request
     * @return array
     */
    public function edit(ArticleRequest $request)
    {
        $params = $request->all();
        return $this->article->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id", 0);
        return $this->article->del(explode(",", $id));
    }

    /**
     * 添加
     * @param ArticleRequest $request
     * @return array
     */
    public function add(ArticleRequest $request)
    {
        $params = $request->all();
        return $this->article->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->input("id", 0);
        return $this->article->release($id);
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

    /**
     * 详情
     * @param IdRequest $request
     * @return array
     */
    public function detail(IdRequest $request)
    {
        $id = $request->input("id");
        $uid = $request->input("uid");
        return $this->article->detail($id, "00" . $uid);
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
        return $this->article->thumb($id, "00" . $uid);
    }

    /***
     * 阅读排行
     */
    public function ranking()
    {
        return $this->article->readingRanking();
    }

    /**
     * 当前类别文章
     * @param Request $request
     * @return array
     */
    public function type(Request $request)
    {
        $type = $request->input("type");
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->article->currentTypeArticle($type,$start,$pageSize);
    }
}
