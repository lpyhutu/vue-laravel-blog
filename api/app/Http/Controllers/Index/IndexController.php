<?php

namespace App\Http\Controllers\Index;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Models\FrontArticle;
use App\Models\FrontTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{

    protected $total;

    public function __construct()
    {
        $this->total = new FrontTotal();
    }

    public function index(Request $request)
    {
        $page = $request->route("page", 1);
        $type = $request->route("type", 0);
        $pageSize = 15;
        $condition = ["release" => 1];
        if ($type != 0) {
            $condition["type"] = $type;
        }
        $article = FrontArticle::with(["frontComment" => function ($query) {
            return $query->where(["release" => 1]);
        }])
            ->with(["frontCommentSub" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->where($condition)
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->get();

        if ($article->isEmpty()) {
            return redirect()->back();
        }
        $total = FrontArticle::where($condition)->count();
        $pageNum = ceil($total / $pageSize);
        return view(
            "front.index",
            [
                "article" => $article,
                "page" => $page,
                "pageNum" => $pageNum,
                "path" => $request->path(),
                "title" => "网页设计，模板分享，源码下载 - 糊涂博客",
                "keywords" => "个人博客,网页,源码,模板分享",
                "description" => "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。"
            ]
        );
    }

    public function search(Request $request)
    {
        $page = $request->route("page", 1);
        $title = $request->input("title", 0);
        if ($title == 0) {
            $title = $request->route("title", 0);
        }
        $pageSize = 20;
        $condition = ["release" => 1];
        $article = FrontArticle::with(["frontComment" => function ($query) {
            return $query->where(["release" => 1]);
        }])
            ->with(["frontCommentSub" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->where("title", "like", "%" . $title . "%")
            ->where($condition)
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = FrontArticle::where("title", "like", "%" . $title . "%")->where($condition)->count();
        $pageNum = ceil($total / $pageSize);
        return view(
            "front.search",
            [
                "article" => $article,
                "page" => $page,
                "pageNum" => $pageNum,
                "path" => $request->path(),
                "search" => $title,
                "title" => "搜索结果 - 网页设计，模板分享，源码下载 - 糊涂博客",
                "keywords" => "搜索,搜索结果",
                "description" => "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。"
            ]
        );
    }

    /**
     * 浏览时长
     * @param Request $request
     * @return array|bool
     */
    public function visitsTime(Request $request)
    {
        $ip = Ip::getClientIp();
        $uid = Cache::get($ip);
        return $this->total->visitsTime($uid);
    }
}
