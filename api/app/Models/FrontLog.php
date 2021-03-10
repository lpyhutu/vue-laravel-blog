<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class FrontLog extends Model
{
    protected $table = "blog_front_log";
    protected $dateFormat = 'U';
    protected $fillable = ["type", "version", "content", "release", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * 获取
     * @param $type
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($type = 0, $start = 0, $pageSize = 15)
    {
        $condition = [];
        if ($type !== 0) {
            $condition = ["type" => $type];
        }
        $log = FrontLog::where($condition)->offset($start)->limit($pageSize)->get();
        if ($log->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontLog::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $log];
    }

    /**
     * 添加日志
     * @param $params
     * @return array
     */
    public function add($params)
    {
        $log = FrontLog::create($params);
        if (!$log) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $log];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $log];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $log = FrontLog::destroy($id);
        if (!$log) {
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
        $log = FrontLog::where(["id" => $params["id"]])->update($params);
        if (!$log) {
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
        $log = FrontLog::where(["id" => $id])->first();
        if (!$log) {
            return ["code" => Code::$WARNING, "msg" => "该日志不存在！"];
        }
        $msg = $log->release === 1 ? "回收" : "发布";
        $log->release = $log->release === 1 ? 2 : 1;
        if (!$log->save()) {
            return ["code" => Code::$WARNING, "msg" => $msg . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $msg . "成功！"];
    }

    /**
     * 获取日志
     * @param $start
     * @param $pageSize
     * @param $type
     * @return array
     */
    public function getRelease($start, $pageSize, $type)
    {
        $log = FrontLog::where(["release" => 1, "type" => $type])->orderBy('created_at', 'desc')->offset($start)
            ->limit($pageSize)->get();
        if ($log->isEmpty()) {
            return ["code" => Code::$WARNING, "msg" => "空空如也！", "data" => [], "total" => 0];
        }
        $total = FrontLog::where(["release" => 1, "type" => $type])->count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $log, "total" => $total];
    }
}
