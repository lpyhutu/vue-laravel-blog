<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\Email;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class FrontCommentSub extends Model
{
    protected $table = "blog_front_comment_sub";
    protected $dateFormat = 'U';
    protected $fillable = ["msg_id", "article_id", "qq", "name", "email", "avatar", "release", "content", "thumb_num", "master", "be_qq", "be_name", "be_email", "be_avatar", "be_master", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 获取
     * @param int $msg_id 留言ID
     * @param int $article_id 文章ID
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($msg_id, $article_id, $start = 0, $pageSize = 15)
    {

        $msg = FrontCommentSub::where(["msg_id" => $msg_id, "article_id" => $article_id])
            ->offset($start)->limit($pageSize)->get();
        if ($msg->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontCommentSub::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $msg];
    }

    /**
     * 添加
     * @param $params
     * @return array
     */
    public function add($params)
    {
        $msg = FrontCommentSub::create($params);
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！"];
        }
        Email::commentReply($params["article_id"], $params["be_email"]);
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $msg];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $msg = FrontCommentSub::destroy($id);
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * 修改
     * @param $params
     * @return array
     */
    public function edit($params)
    {
        $msg = FrontCommentSub::where(["id" => $params["id"]])->update($params);
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "修改成功！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "修改失败！"];
    }

    /**
     * 发布
     * @param int $id id
     * @return array
     */
    public function release($id)
    {
        $msg = FrontCommentSub::where(["id" => $id])->first();
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "该评论不存在！"];
        }
        $msg->release = $msg->release === 1 ? 2 : 1;
        $text = $msg->release === 1 ? "回收" : "发布";
        if (!$msg->save()) {
            return ["code" => Code::$WARNING, "msg" => $text . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $text . "成功"];
    }

    /**
     * 获取已发布
     * @return array
     */
    public function getRelease()
    {
//        $msg = FrontCommentSub::where(["release" => 1])->get();
//        if ($msg->isEmpty()) {
//            return ["code" => Code::$SUCCESS_NO_TIP,"msg"];
//        }
//        return ["code" => Code::$SUCCESS, "data" => $msg];
    }

    /**
     * 评论
     * @param $params
     * @return array
     */
    public function comment($params)
    {
        $isMsg = FrontComment::where(["id" => $params["msg_id"]])->first();
        return $this->handleComment($isMsg, $params);
    }

    /**
     * 子评论
     * @param $params
     * @return array
     */
    public function commentSub($params)
    {
        $isMsg = FrontCommentSub::where(["id" => $params["sub_id"]])->first();
        $params["msg_id"] = $isMsg->msg_id;
        if (!$isMsg) {
            return ["code" => Code::$WARNING, "msg" => "该数据不存在！"];
        }
        return $this->handleComment($isMsg, $params);

    }

    /**
     * 判断
     * @param $isMsg
     * @param $params
     * @return array
     */
    public function handleComment($isMsg, $params)
    {
        if (!$isMsg) {
            return ["code" => Code::$WARNING, "msg" => "该数据不存在！"];
        }
        $params["release"] = 1;
        $params["article_id"] = $isMsg->article_id;
        $params["be_qq"] = $isMsg->qq;
        $params["be_name"] = $isMsg->name;
        $params["be_email"] = $isMsg->email;
        $params["be_avatar"] = $isMsg->avatar;
        $params["be_master"] = $isMsg->master;
        return $this->add($params);
    }
}
