<?php

namespace App\Http\Controllers\Index;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Models\FrontMessage;
use App\Models\FrontMessageSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    protected $msg;
    protected $msgSub;

    public function __construct()
    {
        $this->msg = new FrontMessage();
        $this->msgSub = new FrontMessageSub();
    }

    public function message(Request $request)
    {
        session(['url' => "messagecomment"]);
        session(['urlOne' => "messagecommentone"]);
        session(['urlTwo' => "messagecommenttwo"]);
        session(['urlThumb' => "messagecommentthumb"]);
        $comment = $this->msg->getRelease(0, 50);
        return view(
            "front.message",
            [
                "comment" => $comment["data"],
                "path" => $request->path(),
                "title" => "留言板 - 网页设计，模板分享，源码下载 - 糊涂博客",
                "keywords" => "留言板,评论",
                "description" => "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。"
            ]
        );
    }

    public function messageComment(Request $request)
    {
        $qq = $request->input("qq");
        $content = $request->input("content");
        $html = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq);
        $nickName = trim(mb_convert_encoding(explode(',', $html)[6], "UTF-8", "GBK"), '"');
        $avatar = "https://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $email = "$qq@qq.com";
        $article_id = session("article_id");
        $comment = $this->msg->add($qq, $nickName, $email, $avatar, $content, 1);
        if ($comment["code"] === 1001) {
            return redirect("message");
        }
        return redirect()->back();
    }

    public function messageCommentOne(Request $request)
    {
        $qq = $request->input("qq");
        $content = $request->input("content");
        $msg_id = $request->input("comment_id");
        $html = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq);
        $nickName = trim(mb_convert_encoding(explode(',', $html)[6], "UTF-8", "GBK"), '"');
        $avatar = "https://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $email = "$qq@qq.com";
        $comment = $this->msgSub->comment(["msg_id" => $msg_id, "qq" => $qq, "name" => $nickName, "email" => $email, "avatar" => $avatar, "content" => $content]);
        $article_id = session("article_id");
        if ($comment["code"] === 1001) {
            return redirect("message");
        }
        return redirect()->back();
    }

    public function messageCommentTwo(Request $request)
    {
        $qq = $request->input("qq");
        $content = $request->input("content");
        $sub_id = $request->input("comment_id");
        $html = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq);
        $nickName = trim(mb_convert_encoding(explode(',', $html)[6], "UTF-8", "GBK"), '"');
        $avatar = "https://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $email = "$qq@qq.com";
        $comment = $this->msgSub->commentSub(["sub_id" => $sub_id, "qq" => $qq, "name" => $nickName, "email" => $email, "avatar" => $avatar, "content" => $content]);
        $article_id = session("article_id");
        if ($comment["code"] === 1001) {
            return redirect("message");
        }
        return redirect()->back();
    }

    public function messageCommentThumb(Request $request)
    {
        $id = $request->input("id", 0);
        $sub_id = $request->input("sub_id", 0);
        $ip = Ip::getClientIp();
        $uid = Cache::get($ip);
        return $this->msg->thumb($id, $sub_id, "00" . $uid);
    }
}
