<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPowerRequest;
use App\Http\Requests\IdRequest;
use App\Http\Requests\TypeRequest;
use App\Models\AdminPower;
use Illuminate\Http\Request;

class PowerController extends Controller
{
    protected $power;

    public function __construct()
    {
        $this->power = new AdminPower();
    }

    /**
     * 获取
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->power->getAll($start, $pageSize);
    }

    /**
     * 修改
     * @param AdminPowerRequest $request
     * @return array
     */
    public function edit(AdminPowerRequest $request)
    {
        $id = $request->input("id");
        $power = $request->input("power");
        $rules = $request->input("rules");
        $created_at = $request->input("created_at");
        return $this->power->edit($id, $power, $rules, $created_at);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->power->del(explode(",", $id));
    }

    /**
     * 添加
     * @param AdminPowerRequest $request
     * @return array
     */
    public function add(AdminPowerRequest $request)
    {
        $power = $request->input("power");
        $rules = $request->input("rules");
        $created_at = $request->input("created_at");
        return $this->power->add($power, $rules, $created_at);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->power->release($id);
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        return $this->power->getRelease();
    }
}
