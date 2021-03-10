<?php

namespace App\Http\Middleware;

use App\Http\Common\Code;
use App\Http\Common\Ip;
use App\Http\Common\RedisKey;
use App\Models\FrontUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckRequest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        return $next($request);
        $ip = Ip::getClientIp();
        //黑名单中是否存在该IP
        $isBlack = Redis::zscore(RedisKey::$USER_BLACK_LIST, $ip);
        if ($isBlack) {
            return ["code" => Code::$USER_BLACK, "msg" => "由于您近期异常请求过于频繁，已限制访问。如需取消限制，请联系管理员：邮箱1048672466@qq.com!"];
        }
        $user = new FrontUser();
        $isUser = $user->where(["ip" => $ip])->first();
        //数据库中已设置为黑名单或频繁请求数大于等于10
        if($isUser){
            if ($isUser->black_list === 1 || $isUser->frequent_num >= 10) {
                $isUser->black_list = 1;
                $isUser->save();
                Redis::zadd(RedisKey::$USER_BLACK_LIST, 1, $isUser->ip);
                return ["code" => Code::$USER_BLACK, "msg" => "由于您近期异常请求过于频繁，已限制访问。如需取消限制，请联系管理员：邮箱1048672466@qq.com!"];
            }
        }
        $time = 5;
        $limit = 20;
        $lock_time = 60;
        //频繁请求列表
        $start_time = Redis::zscore(RedisKey::$USER_FREQUENT_REQUEST_LIST, $ip);
        if (time() - $start_time < $lock_time) {
            //返回剩余时间
            return response(["code" => Code::$USER_FREQUENT, "msg" => "频繁请求！", "data" => $lock_time - (time() - $start_time)]);
        }
        $frequentLock = RedisKey::$USER_FREQUENT_REQUEST_LOCK . ":" . $ip;
        $isFrequent = Redis::get($frequentLock);
        //设置锁
        if (!$isFrequent) {
            Redis::setex($frequentLock, $time, 1); //设置锁
            return $next($request);
        }
        Redis::incr($frequentLock);
        //设定时间内请求次数大于设定次数，触发防刷机制
        if ($isFrequent > $limit) {
            Redis::zadd(RedisKey::$USER_FREQUENT_REQUEST_LIST, time(), $ip);
            Redis::expire(RedisKey::$USER_FREQUENT_REQUEST_LIST, 60 * 5);
            $isUser->increment("frequent_num");
            $isUser->save();
        }
        return $next($request);
    }
}
