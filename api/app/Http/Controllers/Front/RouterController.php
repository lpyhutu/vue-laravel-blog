<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Models\Router;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
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
        return $this->router->getAll($start, $pageSize);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id");
        return $this->router->del(explode(",", $id));
    }

    /**
     * 路由表更新
     * @return array
     */
    public function refresh()
    {
        return $this->router->refresh();
    }

    /**
     * 修改
     * @param Request $request
     * @return array
     */
    public function edit(Request $request)
    {
        $id=$request->input("id");
        $remarks=$request->input("remarks");
        return $this->router->edit($id,$remarks);
    }
}
