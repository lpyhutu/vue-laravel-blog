<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\Email;
use App\Http\Common\RedisKey;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class FrontMessage extends Model
{
    protected $table = "blog_front_message";
    protected $dateFormat = 'U';
    protected $fillable = ["qq", "name", "email", "avatar", "content", "thumb_num", "release", "master", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function msgSub()
    {
        return $this->hasMany('App\Models\FrontMessageSub', 'msg_id', "id");
    }

    /**
     * 获取
     * @param int $release 查询类别
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($release = 0, $start = 0, $pageSize = 15)
    {
        $condition = [];
        if ($release !== 0) {
            $condition = ["release" => $release];
        }
        $msg = FrontMessage::where($condition)->offset($start)->limit($pageSize)->get();
        if ($msg->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontMessage::where($condition)->count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $msg];
    }

    /**
     * 添加
     * @param $qq
     * @param $name
     * @param $email
     * @param $avatar
     * @param $release
     * @return array
     */
    public function add($qq, $name, $email, $avatar, $content, $release)
    {
        $msg = FrontMessage::create(["qq" => $qq, "name" => $name, "email" => $email, "avatar" => $avatar, "content" => $content, "release" => $release]);
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！"];
        }
        Email::message();
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！"];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $isMsg = FrontMessageSub::whereIn("msg_id", $id)->first();
        if ($isMsg) {
            return ["code" => Code::$WARNING, "msg" => "该留言含有子留言，请删除后重试！"];
        }
        $msg = FrontMessage::destroy($id);
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
        $msg = FrontMessage::where(["id" => $params["id"]])->update($params);
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
        $msg = FrontMessage::where(["id" => $id])->first();
        if (!$msg) {
            return ["code" => Code::$WARNING, "msg" => "该留言不存在！"];
        }
        $msg->release = $msg->release === 1 ? 2 : 1;
        $text = $msg->release === 1 ? "审核" : "回收";
        if (!$msg->save()) {
            return ["code" => Code::$WARNING, "msg" => $text . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $text . "成功"];
    }

    /**
     * 获取已发布
     * @param int $start
     * @param int $pageSize
     * @return array
     */
    public function getRelease($start = 0, $pageSize = 15)
    {
        $msg = FrontMessage::with(["msgSub" => function ($query) {
            return $query->where(["release" => 1]);
        }])
            ->where(["release" => 1])
            ->orderBy("created_at", "desc")
            ->offset($start)->limit($pageSize)
            ->get();
        if ($msg->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontMessage::where(["release" => 1])->count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $msg];
    }

    /**
     * @param int $id 留言ID
     * @param int $subId 子留言ID
     * @param int $uid uid
     * @return array
     */
    public function thumb($id, $sub_id, $uid)
    {
        if ($sub_id == 0) {
            $msg = FrontMessage::where(["release" => 1, "id" => $id])->first();
        } else {
            $msg = FrontMessageSub::where(["release" => 1, "id" => $sub_id])->first();
        }
        if (!$msg) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "该评论不存在！", "data" => $msg];
        }
        $red = Redis::zscore(RedisKey::$MESSAGE_THUMB_NUM, $uid . "." . $id . $sub_id);
        if ($red) {
            return ["code" => Code::$INFO, "msg" => "赞多了容易骄傲！", "data" => $msg];
        }
        $msg->increment("thumb_num");
        $msg->save();
        if ($msg) {
            Redis::zadd(RedisKey::$MESSAGE_THUMB_NUM, 1, $uid . "." . $id . $sub_id);
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $msg];
    }
}
