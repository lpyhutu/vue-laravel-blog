<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\RedisKey;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class WeChatUser extends Model
{
    protected $table = "blog_wechat_user";
    protected $dateFormat = 'U';
    protected $fillable = ["openid", "nick_name", "avatar_url", "gender", "visits_time", "visits_num", "last_at", "updated_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 用户登陆
     * @param $code
     * @return array
     */
    public function login($code)
    {
        $appid = 'wx5004d86351c41b88';
        $appsecret = '9290a7147a8509e3d4a147f7491552c6';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $res = file_get_contents($url);
        $openid = json_decode($res)->openid;
        $user = WeChatUser::where(["openid" => $openid])->first();
        if ($user) {
            $isVisits = Redis::zscore(RedisKey::$WECHAT_USER_VISITS_LIST, $user->id);
            if (!$isVisits) {
                $user->increment("visits_num");
            }
            $user->last_at = strtotime($user->updated_at);
            $user->save();
            Redis::zadd(RedisKey::$WECHAT_USER_VISITS_LIST, time(), $user->id);
            Redis::expire(RedisKey::$WECHAT_USER_VISITS_LIST, strtotime(date("y-m-d 23:59:59")) - time());
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $user];
        }
        $user = WeChatUser::create(["openid" => $openid, "visits_num" => 1, "avatar_url" => 0, "updated_at" => time(), "last_at" => time()]);
        if ($user) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $user];
        }
        return ["code" => Code::$WARNING, "msg" => "添加失败!", "data" => $user];
    }

    /**
     * 用户信息注册
     * @param $id
     * @param $code
     * @param $nick_name
     * @param $avatar_url
     * @param $gender
     * @return array
     */
    public function register($id, $code, $nick_name, $avatar_url, $gender)
    {
        $user = WeChatUser::where(["id" => $id])->first();
        if (!$user) {
            $this->login($code);
        }
        $user->nick_name = $nick_name;
        $user->avatar_url = $avatar_url;
        $user->gender = $gender;
        $user->save();
        if ($user) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $user];
        }
    }

    /**
     * 获取
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($start = 0, $pageSize = 15)
    {
        $user = WeChatUser::offset($start)->limit($pageSize)->get();
        if ($user->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = WeChatUser::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $user];
    }

    /**
     * 删除
     * @param string $ids
     * @return array
     */
    public function del($ids)
    {
        $user = WeChatUser::destroy($ids);
        if (!$user) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * 访问时间
     * @param $uid
     * @return array
     */
    public function visitsTime($uid)
    {
        $user = WeChatUser::where(["id" => $uid])->first();
        if (!$user) {
            return ["code" => Code::$WARNING, "msg" => "该用户不存在", "data" => $user];
        }
        $user->increment("visits_time");
        $user->save();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $user];
    }
}
