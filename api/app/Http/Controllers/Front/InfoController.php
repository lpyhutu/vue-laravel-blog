<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\InfoRequest;
use App\Models\FrontInfo;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    protected $info;

    public function __construct()
    {
        $this->info = new FrontInfo();
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
        return $this->info->getAll($start, $pageSize);
    }

    /**
     * 修改
     * @param InfoRequest $request
     * @return array
     */
    public function edit(InfoRequest $request)
    {
        $params = $request->all();
        return $this->info->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->info->del(explode(",", $id));
    }

    /**
     * 添加
     * @param InfoRequest $request
     * @return array
     */
    public function add(InfoRequest $request)
    {
        $params = $request->all();
        return $this->info->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->info->release($id);
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        return $this->info->getRelease();
    }
}
