<?php

namespace App\Http\Controllers\Index;

use App\Http\Common\Ip;
use App\Http\Common\RedisKey;
use App\Http\Controllers\Controller;
use App\Models\FrontArticle;
use App\Models\FrontComment;
use App\Models\FrontCommentSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class DetailController extends Controller
{

    protected $comment;
    protected $commentSub;
    protected $article;

    public function __construct()
    {
        $this->commentSub = new FrontCommentSub();
        $this->comment = new FrontComment();
        $this->article = new FrontArticle();
    }

    public function detail(Request $request)
    {
        $id = $request->route("id");
        $article = FrontArticle::with('frontType')
            ->where(["release" => 1, "id" => $id])
            ->get();
        if ($article->isEmpty()) {
            return redirect()->back();
        }
        $ip = Ip::getClientIp();
        $uid = Cache::get($ip);
        //点击量
        $red = Redis::zscore(RedisKey::$ARTICLE_READ_NUM, $uid . $id);
        if (!$red) {
            $res = FrontArticle::where(["id" => $id])
                ->update(["read_num" => $article[0]->read_num + 1]);
            if ($res) {
                Redis::zadd(RedisKey::$ARTICLE_READ_NUM, 1, $uid . $id);
                Redis::expire(RedisKey::$ARTICLE_READ_NUM, strtotime(date("y-m-d 23:59:59")) - time());
            }
        }
        $upArticle = FrontArticle::where("id", ">", $id)->where(["release" => 1])->limit(1)->first();
        $downArticle = FrontArticle::where("id", "<", $id)->where(["release" => 1])->orderBy('id', 'desc')->limit(1)->first();
        $comment = $this->comment->getRelease($id, 0, 50);
        session(['article_id' => $id]);
        session(['url' => "articlecomment"]);
        session(['urlOne' => "articlecommentone"]);
        session(['urlTwo' => "articlecommenttwo"]);
        session(['urlThumb' => "articlecommentthumb"]);
        return view(
            "front.detail",
            [
                "article" => $article,
                "upArticle" => $upArticle,
                "downArticle" => $downArticle,
                "comment" => $comment["data"],
                "path" => $request->path(),
                "title" => $article[0]->title . " - 糊涂博客",
                "keywords" => $article[0]->keywords,
                "description" => mb_substr(str_replace("#", "", $article[0]->content), 0, 230, "utf-8")
            ]
        );
    }

    public function articleComment(Request $request)
    {
        $qq = $request->input("qq");
        $content = $request->input("content");
        $html = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq);
        $nickName = trim(mb_convert_encoding(explode(',', $html)[6], "UTF-8", "GBK"), '"');
        $avatar = "https://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $email = "$qq@qq.com";
        $article_id = session("article_id");
        $comment = $this->comment->add($article_id, $qq, $nickName, $email, $avatar, $content, 1);
        if ($comment["code"] === 1001) {
            return redirect("detail/" . $article_id);
        }
        return redirect()->back();
    }

    public function articleCommentOne(Request $request)
    {
        $qq = $request->input("qq");
        $content = $request->input("content");
        $msg_id = $request->input("comment_id");
        $html = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq);
        $nickName = trim(mb_convert_encoding(explode(',', $html)[6], "UTF-8", "GBK"), '"');
        $avatar = "https://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $email = "$qq@qq.com";
        $comment = $this->commentSub->comment(["msg_id" => $msg_id, "qq" => $qq, "name" => $nickName, "email" => $email, "avatar" => $avatar, "content" => $content]);
        $article_id = session("article_id");
        if ($comment["code"] === 1001) {
            return redirect("detail/" . $article_id);
        }
        return redirect()->back();
    }

    public function articleCommentTwo(Request $request)
    {
        $qq = $request->input("qq");
        $content = $request->input("content");
        $sub_id = $request->input("comment_id");
        $html = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq);
        $nickName = trim(mb_convert_encoding(explode(',', $html)[6], "UTF-8", "GBK"), '"');
        $avatar = "https://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $email = "$qq@qq.com";
        $comment = $this->commentSub->commentSub(["sub_id" => $sub_id, "qq" => $qq, "name" => $nickName, "email" => $email, "avatar" => $avatar, "content" => $content]);
        $article_id = session("article_id");
        if ($comment["code"] === 1001) {
            return redirect("detail/" . $article_id);
        }
        return redirect()->back();
    }

    public function thumb(Request $request)
    {
        $ip = Ip::getClientIp();
        $uid = Cache::get($ip);
        $id = session("article_id");
        return $this->article->thumb($id, "00" . $uid);
    }

    public function articleCommentThumb(Request $request)
    {
        $id = $request->input("id", 0);
        $sub_id = $request->input("sub_id", 0);
        $ip = Ip::getClientIp();
        $uid = Cache::get($ip);
        return $this->comment->thumb($id, $sub_id, "00" . $uid);
    }
}
