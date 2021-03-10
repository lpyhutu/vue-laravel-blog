<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\Email;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class FrontMessageSub extends Model
{
    protected $table = "blog_front_message_sub";
    protected $dateFormat = 'U';
    protected $fillable = ["msg_id", "qq", "name", "email", "avatar", "content", "thumb_num", "master", "be_qq", "be_name", "be_email", "be_avatar", "be_master", "release", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 获取
     * @param int $msg_id 留言ID
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($msg_id, $start = 0, $pageSize = 15)
    {

        $msg = FrontMessageSub::where(["msg_id" => $msg_id])->offset($start)->limit($pageSize)->get();
        if ($msg->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontMessageSub::where(["msg_id" => $msg_id])->count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $msg];
    }

    /**
     * 添加
     * @param $params
     * @return array
     */
    public function add($params)
    {
        $msg = FrontMessageSub::create($params);
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！"];
        }
        Email::messageReply($params["be_email"], $params["name"]);
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！"];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $msg = FrontMessageSub::destroy($id);
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
        $msg = FrontMessageSub::where(["id" => $params["id"]])->update($params);
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "修改失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "修改成功！"];
    }

    /**
     * 发布
     * @param int $id id
     * @return array
     */
    public function release($id)
    {
        $msg = FrontMessageSub::where(["id" => $id])->first();
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "该留言不存在！"];
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
        $msg = FrontMessageSub::where(["release" => 1])->get();
        if ($msg->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！"];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $msg];
    }

    /**
     * 评论
     * @param $params
     * @return array
     */
    public function comment($params)
    {
        $isMsg = FrontMessage::where(["id" => $params["msg_id"]])->first();
        return $this->handleComment($isMsg, $params);
    }

    /**
     * 子评论
     * @param $params
     * @return array
     */
    public function commentSub($params)
    {
        $isMsg = FrontMessageSub::where(["id" => $params["sub_id"]])->first();
        if (!$isMsg) {
            return ["code" => Code::$WARNING, "msg" => "该数据不存在！", "data" => []];
        }
        $params["msg_id"] = $isMsg->msg_id;
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
            return ["code" => Code::$WARNING, "msg" => "该数据不存在！", "data" => []];
        }
        $params["release"] = 1;
        $params["be_qq"] = $isMsg->qq;
        $params["be_qq"] = $isMsg->qq;
        $params["be_name"] = $isMsg->name;
        $params["be_email"] = $isMsg->email;
        $params["be_avatar"] = $isMsg->avatar;
        $params["be_master"] = $isMsg->master;
        return $this->add($params);
    }
}
