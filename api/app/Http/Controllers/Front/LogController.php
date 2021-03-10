<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\LogRequest;
use App\Models\FrontLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $log;

    public function __construct()
    {
        $this->log = new FrontLog();
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
        $type = $request->input("type", 0);
        return $this->log->getAll($type,$start, $pageSize);
    }

    /**
     * 修改
     * @param LogRequest $request
     * @return array
     */
    public function edit(LogRequest $request)
    {
        $params = $request->all();
        return $this->log->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->log->del(explode(",", $id));
    }

    /**
     * 添加
     * @param LogRequest $request
     * @return array
     */
    public function add(LogRequest $request)
    {
        $params = $request->all();
        return $this->log->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->log->release($id);
    }
//
//    /**
//     * 获取已发布
//     * @param Request $request
//     * @return array
//     */
//    public function getRelease(Request $request)
//    {
//        return $this->log->getRelease();
//    }
}
