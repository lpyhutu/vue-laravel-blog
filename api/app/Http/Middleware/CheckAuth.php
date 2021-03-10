<?php

namespace App\Http\Middleware;

use App\Http\Common\Code;
use App\Models\AdminPower;
use App\Models\Router;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckAuth extends BaseMiddleware
{

    /**
     * token检测、刷新
     * @param $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        //检测请求头是否带token
        if (!$this->auth->parser()->setRequest($request)->hasToken()) {
            return response()->json(["code" => Code::$ERROR_REQUEST, "msg" => "异常请求！"]);
        }
        try {
            //判断是否登陆
            $auth = $this->auth->parseToken()->authenticate();
            if (!$auth) {
                return response()->json(["code" => Code::$LOGIN_NOT, "msg" => "该管理员未登陆！"]);
            }
            $api = request()->route()->uri;
            //刷新token
            if ($api === "api/admin/refreshToken") {
                return response()->json($this->refreshToken());
            }
            //退出登陆
            if ($api === "api/admin/logout") {
                auth()->logout();
                return response()->json(["code" => Code::$SUCCESS, "msg" => "注销成功！"]);
            }
            //权限
            if ($auth->power === 0) {
                return $next($request);
            }
            $router = Router::where(["api" => $api])->first();
            if (!$router) {
                return response()->json(["code" => Code::$WARNING, "msg" => "异常请求！"]);
            }
            $adminPower = AdminPower::where(["power" => $auth->power, "release" => 1])->first();
            if (!$adminPower) {
                return response()->json(["code" => Code::$WARNING, "msg" => "该管理组未设置路由规则！"]);
            }
            $rules = explode(",", $adminPower->rules);
            for ($i = 0; $i < count($rules); $i++) {
                if ($rules[$i] == $router->id) {
                    return $next($request);
                }
            }
            return response()->json(["code" => Code::$WARNING, "msg" => "管理员没有该操作权限！"]);
        } catch (JWTException $e) {
            try {
                return response()->json($this->refreshToken());
            } catch (JWTException $e) {
                //token过期，重新登陆
                return response()->json(["code" => Code::$LOGIN_EXPIRE, "msg" => "身份效验过期，请重新登陆！"]);
            }
        }
    }

    /**
     * token刷新
     * @return array
     */
    public function refreshToken()
    {
        $token = $this->auth->refresh();
        $res = [
            'token' => $token,
            'type' => 'bearer',
            'expires' => $this->auth->factory()->getTTL() * 60
        ];
        return ["code" => Code::$TOKEN_REFRESH_SUCCESS, "msg" => "刷新成功！", "data" => $res];
    }
}
