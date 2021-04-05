<?php

namespace App\Http\Middleware;

use App\Http\Common\Ip;
use App\Models\FrontUser;
use Closure;
use Illuminate\Support\Facades\Cache;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        abort(404);
        $ip = Ip::getClientIp();
        if (Cache::has($ip)) {
            return $next($request);
        }
        $user = new FrontUser();
        Cache::put($ip, $user->login($ip)["data"]["uid"], $user->login($ip)["data"]["time"] / 60);
        return $next($request);
    }
}
