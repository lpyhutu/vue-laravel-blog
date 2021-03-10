<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\RedisKey;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class FrontTotal extends Model
{
    protected $table = "blog_front_total";
    protected $dateFormat = 'U';
    protected $fillable = ["visitors_num", "visits_num", "visits_time", "article_num"];

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

        $total = FrontTotal::offset($start)->limit($pageSize)->get();
        if ($total->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $num = FrontTotal::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $num, "data" => $total];
    }

    /**
     * 数据统计
     * @return array
     */
    public function totalNum()
    {
        $total = FrontTotal::orderBy("created_at", "desc")->offset(0)->limit(15)->get();
        $user = FrontUser::orderBy("created_at", "desc")->offset(0)->limit(15)->get();
        $userAll = FrontUser::get();
        $visitsInterval = FrontUserVisitsInterval::get();
        $visitors_num = FrontTotal::sum("visitors_num");
        $visits_num = FrontTotal::sum("visits_num");
        $visits_time = FrontTotal::sum("visits_time");
        $wechat_visitors_num = WeChatUser::count();
        $wechat_visits_num = WeChatUser::sum("visits_num");
        $wechat_visits_time = WeChatUser::sum("visits_time");
        $article_num = FrontArticle::count();
        $article_verify_num = FrontArticle::where(["release" => 2])->count();
        $message_num = FrontMessage::count() + FrontMessageSub::count();
        $message_verify_num = FrontMessage::where(["release" => 2])->count() + FrontMessageSub::where(["release" => 2])->count();
        $link_num = FrontLink::count();
        $link_verity_num = FrontLink::where(["release" => 2])->count();
        $comment_num = FrontComment::count() + FrontCommentSub::count();
        $comment_verify_num = FrontComment::where(["release" => 2])->count() + FrontCommentSub::where(["release" => 2])->count();
        return ["code" => Code::$SUCCESS_NO_TIP,
            "data" => [
                "num" => [
                    "visitors_num" => $visitors_num,
                    "visits_num" => $visits_num,
                    "visits_time" => $visits_time,
                    "wechat_visitors_num" => $wechat_visitors_num,
                    "wechat_visits_num" => $wechat_visits_num,
                    "wechat_visits_time" => $wechat_visits_time,
                    "article_num" => $article_num,
                    "article_verify_num" => $article_verify_num,
                    "message_num" => $message_num,
                    "message_verify_num" => $message_verify_num,
                    "link_num" => $link_num,
                    "link_verity_num" => $link_verity_num,
                    "comment_num" => $comment_num,
                    "comment_verify_num" => $comment_verify_num,
                ],
                "total" => $total,
                "visitsInterval" => $visitsInterval,
                "user" => $user,
                "userAll" => $userAll
            ]
        ];
    }

    /**
     * 数据统计
     * @return array
     */
    public function num()
    {
        $visitsInterval = FrontUserVisitsInterval::count();
        $article_num = FrontArticle::where(["release" => 1])->count();
        return ["code" => Code::$SUCCESS_NO_TIP, "data" => [
            "visitsInterval" => $visitsInterval,
            "article_num" => $article_num
        ]];
    }

    /**
     * 浏览时长
     * @param string $uid uid
     * @return array|bool
     */
    public function visitsTime($uid)
    {
        $user = FrontUser::where(["id" => $uid])->first();
        if (!$user) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "该用户不存在!", "data" => []];
        }
        $user->increment("visits_time");
        $user->save();
        $this->IncrementOfDecrement("visits_time", 1, true);
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => []];
    }

    /**
     * key存在就自增||创建新的一条数据
     * @return bool
     */
    public function isCreated()
    {
        $total = FrontTotal::orderBy("created_at", "desc")->first();
        if (!$total) {
            return true;
        }
        $time = strtotime($total->created_at);
        $endTime = strtotime(date("y-m-d 23:59:59"));
        $startTime = strtotime(date("y-m-d 00:00:00"));
        if (Redis::exists(RedisKey::$TOTAL_LOCK)) {
            return false;
        }
        if ($time < $endTime && $time > $startTime) {
            return false;
        }
        return true;
    }

    /**
     * 自增||自减
     * @param string $field 字段
     * @param int $num 数据
     * @param bool $isIncrement 是否自增
     * @return bool
     */
    public function IncrementOfDecrement($field, $num = 1, $isIncrement = true)
    {
        $total = FrontTotal::orderBy("created_at", "desc")->first();
        if ($isIncrement) {
            $total->increment($field, $num);
        } else {
            $total->decrement($field, $num);
        }
        $res = $total->save();
        if ($res) {
            $this->setTotalLock();
            return true;
        }
        return false;
    }

    /**
     * 创建数据
     * @param array $data 数据
     * @return bool
     */
    public function createdPieceOfData($data)
    {
        $res = FrontTotal::create($data);
        if ($res) {
            $this->setTotalLock();
            return true;
        }
        return false;
    }

    /**
     * 设置锁
     * @return bool
     */
    public function setTotalLock()
    {
        $res = Redis::setex(RedisKey::$TOTAL_LOCK, strtotime(date("y-m-d 23:59:59")) - time(), 1);
        if ($res) {
            return true;
        }
        return false;
    }

    public function del($id)
    {
        $total = FrontTotal::destroy($id);
        if (!$total) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }
}
