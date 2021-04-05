<?php

namespace App\Http\Controllers\Admin;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
use App\Http\Requests\IdRequest;
use App\Http\Requests\LoginRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $adminUser;


    public function __construct()
    {
        $this->adminUser = new AdminUser();
    }

    public function index(Request $request)
    {
        echo date("y-m-d", strtotime("2020-11-11 23:59:59"));
//        echo time("2020-11-11 23:59:59");
    }

    /**
     * 管理员登陆
     * @param LoginRequest $request username 账号,password 密码,captchaCode 验证码,captchaKey 验证码唯一值
     * @return array
     */
    public function login(LoginRequest $request)
    {
        $params = $request->all();
        $ip = Ip::getClientIp();
        return $this->adminUser->login($params["username"], $params["password"], $ip, $params["captchaCode"], $params["captchaKey"]);
    }

    /**
     * token刷新
     * @return int[]
     */
    public function refreshToken()
    {
        return ["code" => 1];
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
        return $this->adminUser->getAll($start, $pageSize);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id");
        return $this->adminUser->del(explode(",", $id));
    }

    /**
     * 添加
     * @param AdminUserRequest $request
     * @return array
     */
    public function add(AdminUserRequest $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");
        $power = $request->input("power");
        $created_at = $request->input("created_at");
        return $this->adminUser->add($username, $password, $power, $created_at);
    }

    /**
     * 修改
     * @param AdminUserRequest $request
     * @return array
     */
    public function edit(AdminUserRequest $request)
    {
        $id = $request->input("id");
        $username = $request->input("username");
        $password = $request->input("password");
        $power = $request->input("power");
        $created_at = $request->input("created_at");
        return $this->adminUser->edit($id, $username, $password, $power, $created_at);
    }

}
