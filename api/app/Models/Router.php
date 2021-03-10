<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Router extends Model
{
    protected $table = "blog_router";
    protected $dateFormat = 'U';
    protected $fillable = ["api","remarks" ,"created_at"];

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
            $gallery = Router::get();
        }else{
            $gallery = Router::offset($start)->limit($pageSize)->get();
        }
        if ($gallery->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = Router::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $gallery];
    }

    /**
     * 刷新路由表
     * @return array
     */
    public function refresh()
    {
        $routers = Route::getRoutes()->get();
        foreach ($routers as $val) {
            $router = Router::where(["api" => $val->uri])->first();
            if (!$router) {
                Router::create(["api" => $val->uri]);
            }
        }
        return ["code" => Code::$SUCCESS, "msg" => "更新成功！", "data" => []];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $type = Router::destroy($id);
        if (!$type) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * 修改
     * @param $id
     * @param $remarks
     * @return array
     */
    public function edit($id,$remarks)
    {
        $router=Router::where(["id" => $id])->first();
        if(!$router){
            return ["code" => Code::$WARNING, "msg" => "该API不存在！","data"=>[]];
        }
        $router->remarks=$remarks;
        $router->save();
        if (!$router) {
            return ["code" => Code::$WARNING, "msg" => "修改失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "修改成功！"];
    }
}
