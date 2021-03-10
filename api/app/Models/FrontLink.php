<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\Email;
use App\Http\Common\RedisKey;
use App\Http\Requests\IdRequest;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class FrontLink extends Model
{
    protected $table = "blog_front_link";
    protected $dateFormat = 'U';
    protected $fillable = ["title", "site", "img_url", "email", "visit_num", "sort", "release", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 获取
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($start = 0, $pageSize = 15)
    {

        $link = FrontLink::orderBy('sort', 'asc')->offset($start)->limit($pageSize)->get();
        if ($link->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontLink::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $link];
    }

    /**
     * 添加
     * @param $params
     * @return array
     */
    public function add($params)
    {
        $link = FrontLink::create($params);
        if (!$link) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！"];
        }
        Email::linkApply();
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！"];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $link = FrontLink::destroy($id);
        if (!$link) {
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
        $link = FrontLink::where(["id" => $params["id"]])->update($params);
        if (!$link) {
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
        $link = FrontLink::where(["id" => $id])->first();
        if (!$link) {
            return ["code" => Code::$INFO, "msg" => "该数据不存在！"];
        }
        $msg = $link->release === 1 ? "回收" : "发布";
        $link->release === 1 ? "" : Email::linkReply($link->email);
        $link->release = $link->release === 1 ? 2 : 1;

        $link->save();
        if (!$link->save()) {
            return ["code" => Code::$WARNING, "msg" => $msg . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $msg . "成功"];
    }

    /**
     * 获取已发布
     * @return array
     */
    public function getRelease()
    {
        $link = FrontLink::where(["release" => 1])->orderBy('sort', 'asc')->orderBy('visit_num', 'desc')->get();
        if ($link->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "data" => []];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $link];
    }

    /**
     * @param int $id 文章ID
     * @param int $uid uid
     * @return array
     */
    public function visitNum($id, $uid)
    {
        $link = FrontLink::where(["release" => 1, "id" => $id])->first();
        if (!$link) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "该链接不存在！", "data" => []];
        }
        $red = Redis::zscore(RedisKey::$LINK_VISIT_NUM, $uid . "." . $id);
        if ($red) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success"];
        }
        $res = $link->increment("visit_num");
        if ($res) {
            Redis::zadd(RedisKey::$LINK_VISIT_NUM, 1, $uid . "." . $id);
            Redis::expire(RedisKey::$LINK_VISIT_NUM, strtotime(date("y-m-d 23:59:59")) - time());
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success"];
    }
}
