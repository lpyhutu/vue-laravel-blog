<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\RedisKey;
use DateTimeInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminUser extends Authenticatable implements JWTSubject
{

    protected $table = "blog_admin_user";
    protected $dateFormat = 'U';
    protected $fillable = ["username", "password", "power", "created_at"];
    protected $hidden = ["password"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * @return HasOne
     */
    public function powerTitle()
    {
        return $this->hasOne('App\Models\AdminPowerLevel', 'id', "power");
    }

    /**
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $ip ip地址
     * @param int $captchaCode 验证码
     * @param string $captchaKey 验证码标识
     * @return array
     */
    public function login($username, $password, $ip, $captchaCode, $captchaKey)
    {
        //验证码认证
        if (!captcha_api_check($captchaCode, $captchaKey)) {
            return ["code" => Code::$WARNING, "msg" => "验证码错误！"];
        }
//       密码错误超5次
        $isLock = Redis::zscore(RedisKey::$ADMIN_LOGIN_REQUEST_LIST, $ip);
        if ($isLock) {
            return ["code" => Code::$WARNING, "msg" => "异常请求，请换设备或明日再试！"];
        }
        //token认证
        if (!$token = JWTAuth::attempt(["username" => $username, "password" => $password])) {
            $loginNum = Redis::get(RedisKey::$ADMIN_LOGIN_REQUEST_LOCK . ":" . $ip);
            $maxNum = 5;
            $time = strtotime(date("y-m-d 23:59:59")) - time();
            if ($loginNum >= $maxNum) {
                Redis::zadd(RedisKey::$ADMIN_LOGIN_REQUEST_LIST, 1, $ip);
                Redis::expire(RedisKey::$ADMIN_LOGIN_REQUEST_LIST, $time);
            }
            if ($loginNum) {
                Redis::incr(RedisKey::$ADMIN_LOGIN_REQUEST_LOCK . ":" . $ip);
            } else {
                Redis::setex(RedisKey::$ADMIN_LOGIN_REQUEST_LOCK . ":" . $ip, $time, 1);
            }
            $num = $maxNum - $loginNum;
            return ["code" => Code::$WARNING, "msg" => "账号或密码错误,还有" . $num . "次机会！"];
        }
        //上一次登陆时间
        $adminUser = AdminUser::where(["username" => $username])->first();
        $adminUser->last_at = $adminUser->updated_at->timestamp;
        $adminUser->last_ip = $adminUser->ip;
        $adminUser->ip = $ip;
        $adminUser->save();
        $res = [
            'token' => $token,
            'type' => 'bearer',
            'expires' => JWTAuth::factory()->getTTL() * 60,
        ];
        return ["code" => Code::$SUCCESS, "msg" => "登陆成功!", "data" => $res];
    }

    /**
     * 获取
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($start = 0, $pageSize = 15)
    {

        $adminUser = AdminUser::with(["powerTitle" => function ($query) {
            return $query->where(["release" => 1]);
        }])->whereNotIn("power", [0])->offset($start)->limit($pageSize)->get();

        if ($adminUser->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = AdminUser::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $adminUser];
    }


    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $adminUser = AdminUser::destroy($id);
        if (!$adminUser) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * 添加
     * @param $username
     * @param $password
     * @param $power
     * @param $created_at
     * @return array
     */
    public function add($username,$password,$power,$created_at)
    {
        $isAdminUser=AdminUser::where(["username"=>$username])->first();
        if($isAdminUser){
            return ["code" => Code::$WARNING, "msg" => "该用户已存在！", "data" => []];
        }
        $adminUser = AdminUser::create(["username" => $username, "password" => Hash::make($password), "power"=>$power,"created_at" => $created_at]);
        if (!$adminUser) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $adminUser];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $adminUser];
    }

    /**
     * @param $id
     * @param $username
     * @param $password
     * @param $power
     * @param $created_at
     * @return array
     */
    public function edit($id,$username,$password,$power,$created_at)
    {
        $isAdminUser=AdminUser::where(["id"=>$id])->first();
        if(!$isAdminUser){
            return ["code" => Code::$WARNING, "msg" => "该用户不存在！", "data" => []];
        }
        if($isAdminUser->username!==$username){
            $isAdminUser=AdminUser::where(["username"=>$username])->first();
            if($isAdminUser){
                return ["code" => Code::$WARNING, "msg" => "该用户已存在！", "data" => []];
            }
        }
        $adminUser = AdminUser::where(["id" => $id])->update(["username" => $username, "password" => Hash::make($password), "power"=>$power,"created_at" => $created_at]);
        if (!$adminUser) {
            return ["code" => Code::$WARNING, "msg" => "修改失败！","data"=>[]];
        }
        return ["code" => Code::$SUCCESS, "msg" => "修改成功！","data"=>[]];
    }
    /**
     * token
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * token
     * @return mixed
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
