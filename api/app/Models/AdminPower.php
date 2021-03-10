<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminPower extends Model
{
    protected $table = "blog_admin_power";
    protected $dateFormat = 'U';
    protected $fillable = ["power", "rules", "release", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return HasOne
     */
    public function powerTitle()
    {
        return $this->hasOne('App\Models\AdminPowerLevel', 'id', "power");
    }

    /**
     * 获取
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($start = 0, $pageSize = 15)
    {

        $adminPower = AdminPower::with(["powerTitle" => function ($query) {
            return $query->where(["release" => 1]);
        }])->offset($start)->limit($pageSize)->get();
        if ($adminPower->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = AdminPower::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $adminPower];
    }

    /**
     * 添加
     * @param $power
     * @param $rules
     * @param $created_at
     * @return array
     */
    public function add($power, $rules, $created_at)
    {
        $adminPower = AdminPower::where(["power" => $power])->first();
        if ($adminPower) {
            return ["code" => Code::$WARNING, "msg" => "该组规则已存在，请直接修改！", "data" => []];
        }
        $adminPower = AdminPower::create(["power" => $power, "rules" => $rules, "created_at" => $created_at]);
        if (!$adminPower) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $adminPower];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $adminPower];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $adminPower = AdminPower::destroy($id);
        if (!$adminPower) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * 修改
     * @param $id
     * @param $power
     * @param $rules
     * @param $created_at
     * @return array
     */
    public function edit($id, $power, $rules, $created_at)
    {
        $adminPower = AdminPower::where(["id" => $id])->first();
        if (!$adminPower) {
            return ["code" => Code::$WARNING, "msg" => "该规则不存在！", "data" => []];
        }
        if ($adminPower->power !== $power) {
            $adminPower = AdminPower::where(["power" => $power])->first();
            if ($adminPower) {
                return ["code" => Code::$WARNING, "msg" => "该组规则已存在，请直接修改！", "data" => []];
            }
        }
        $adminPower = AdminPower::where(["id" => $id])->update(["power" => $power, "rules" => $rules, "created_at" => $created_at]);
        if (!$adminPower) {
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
        $adminPower = AdminPower::where(["id" => $id])->first();
        if (!$adminPower) {
            return ["code" => Code::$WARNING, "msg" => "该类别不存在！"];
        }
        $msg = $adminPower->release === 1 ? "回收" : "发布";
        $adminPower->release = $adminPower->release === 1 ? 2 : 1;
        if (!$adminPower->save()) {
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
        $adminPower = AdminPower::where(["release" => 1])->with(["article" => function ($query) {
            return $query->where(["release" => 1]);
        }])->get();
        if ($adminPower->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "data" => []];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $adminPower];
    }
}
