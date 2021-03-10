<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class AdminPowerLevel extends Model
{
    protected $table = "blog_admin_power_level";
    protected $dateFormat = 'U';
    protected $fillable = ["title", "sort", "created_at"];

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
        if ($pageSize === 0) {
            $powerLevel = AdminPowerLevel::get();
        } else {
            $powerLevel = AdminPowerLevel::offset($start)->limit($pageSize)->get();
        }
        if ($powerLevel->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = AdminPowerLevel::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $powerLevel];
    }

    /**
     * 添加
     * @param string $title 类别标题
     * @param int $sort 权重
     * @param int $created_at 创建时间
     * @return array
     */
    public function add($title, $sort, $created_at)
    {
        $powerLevel = AdminPowerLevel::create(["title" => $title, "sort" => $sort, "created_at" => $created_at]);
        if (!$powerLevel) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $powerLevel];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $powerLevel];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $isPowerLevel = AdminUser::where(["power" => $id])->first();
        $isPower = AdminPower::where(["power" => $id])->first();
        if ($isPowerLevel || $isPower) {
            return ["code" => Code::$WARNING, "msg" => "管理员设置该等级，请删除后重试！"];
        }
        $powerLevel = AdminPowerLevel::destroy($id);
        if (!$powerLevel) {
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
        $powerLevel = AdminPowerLevel::where(["id" => $params["id"]])->update($params);
        if (!$powerLevel) {
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
        $powerLevel = AdminPowerLevel::where(["id" => $id])->first();
        if (!$powerLevel) {
            return ["code" => Code::$WARNING, "msg" => "该数据不存在！"];
        }
        $msg = $powerLevel->release === 1 ? "回收" : "发布";
        $powerLevel->release = $powerLevel->release === 1 ? 2 : 1;
        if (!$powerLevel->save()) {
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
        $powerLevel = AdminPowerLevel::where(["release" => 1])->get();
        if ($powerLevel->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "data" => []];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $powerLevel];
    }
}
