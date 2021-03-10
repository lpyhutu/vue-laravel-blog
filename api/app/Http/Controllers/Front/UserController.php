<?php

namespace App\Http\Controllers\Front;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Models\FrontUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new FrontUser();
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
        return $this->user->getAll($start, $pageSize);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->user->del(explode(",", $id));
    }

    /**
     * 添加
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        $params = $request->all();
        return $this->user->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->input("id", 0);
        return $this->user->release($id);
    }

    public function login(Request $request)
    {
        $ip = Ip::getClientIp();
        return $this->user->login($ip);
    }
}
