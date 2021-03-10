<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Models\FrontDiscoloration;
use Illuminate\Http\Request;

class DiscolorationController extends Controller
{
    protected $discoloration;

    public function __construct()
    {
        $this->discoloration = new FrontDiscoloration();
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
        return $this->discoloration->getAll($start, $pageSize);
    }

    /**
     * 修改
     * @param Request $request
     * @return array
     */
    public function edit(Request $request)
    {
        $uid = $request->input("uid");
        $nick_name = $request->input("nick_name");
        $type = $request->input("type");
        $level = $request->input("level");
        $steps = $request->input("steps");
        return $this->discoloration->edit($uid, $nick_name, $type, $level, $steps);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id");
        return $this->discoloration->del(explode(",", $id));
    }

    /**
     * 添加
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        $uid = $request->input("uid");
        $nick_name = $request->input("nick_name");
        return $this->discoloration->add($uid, $nick_name);
    }

    /**
     * 获取当前
     * @param Request $request
     * @return array
     */
    public function current(Request $request)
    {
        $uid = $request->input("uid");
        $type = $request->input("type", 0);
        return $this->discoloration->current($uid, $type);
    }

    /**
     * 游戏排行
     */
    public function ranking()
    {
        return $this->discoloration->ranking();
    }

}
