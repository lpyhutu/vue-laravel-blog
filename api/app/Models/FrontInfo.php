<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class FrontInfo extends Model
{
    protected $table = "blog_front_info";
    protected $dateFormat = 'U';
    protected $fillable = ["title", "email", "english", "copyright", "content", "record", "record_link", "sort", "release", "created_at"];

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
        $info = FrontInfo::orderBy('sort', 'asc')->offset($start)->limit($pageSize)->get();
        if ($info->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontInfo::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $info];
    }

    /**
     * 添加
     * @param $params
     * @return array
     */
    public function add($params)
    {
        $info = FrontInfo::create($params);
        if (!$info) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！"];
        }
        file_put_contents(public_path() . "/upload/info/" . $info->id . ".txt", $info->content);
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！"];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $info = FrontInfo::destroy($id);
        if (!$info) {
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
        $info = FrontInfo::where(["id" => $params["id"]])->update($params);
        if (!$info) {
            return ["code" => Code::$WARNING, "msg" => "修改失败！"];
        }
        $info = FrontInfo::where(["id" => $params["id"]])->first();
        file_put_contents(public_path() . "/upload/info/" . $info->id . ".txt", $info->content);
        return ["code" => Code::$SUCCESS, "msg" => "修改成功！"];
    }

    /**
     * 发布
     * @param int $id id
     * @return array
     */
    public function release($id)
    {
        $info = FrontInfo::where(["id" => $id])->first();
        if (!$info) {
            return ["code" => Code::$WARNING];
        }
        $info->release = $info->release === 1 ? 2 : 1;
        $msg = $info->release === 1 ? "回收" : "发布";
        if (!$info->save()) {
            return ["code" => Code::$WARNING, "msg" => $msg . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $msg . "成功！"];
    }

    /**
     * 获取已发布
     * @return array
     */
    public function getRelease()
    {
        $info = FrontInfo::where(["release" => 1])->orderBy('sort', 'asc')->get();
        if ($info->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "data" => []];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $info];

    }
}
