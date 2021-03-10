<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FrontDiscoloration extends Model
{
    protected $table = "blog_front_discoloration";
    protected $dateFormat = 'U';
    protected $fillable = ["uid", "nick_name", "type", "level", "steps", "created_at"];

//    protected $casts = [
//        'created_at' => 'datetime:Y-m-d H:i:s',
//        'updated_at' => 'datetime:Y-m-d H:i:s',
//    ];

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

        $discoloration = FrontDiscoloration::offset($start)->limit($pageSize)->get();
        if ($discoloration->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontDiscoloration::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $discoloration];
    }

    /**
     * 添加
     * @param $uid
     * @param $nick_name
     * @return array
     */
    public function add($uid, $nick_name)
    {
        $isDiscoloration = FrontDiscoloration::where(["uid" => $uid])->first();
        if ($isDiscoloration) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "已添加！", "data" => $isDiscoloration];
        }
        $discoloration = FrontDiscoloration::create(["uid" => $uid, "nick_name" => $nick_name]);
        if (!$discoloration) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $discoloration];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $discoloration];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $discoloration = FrontDiscoloration::destroy($id);
        if (!$discoloration) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * @param $uid
     * @param $nick_name
     * @param $type
     * @param $level
     * @param $steps
     * @return array
     */
    public function edit($uid, $nick_name, $type, $level, $steps)
    {
        $discoloration = FrontDiscoloration::where(["uid" => $uid, "type" => $type])->first();
        if ($discoloration) {
            if ($level > $discoloration->level) {
                $discoloration->level = $level;
                $discoloration->steps = $steps;
            }
            if ($level == $discoloration->level) {
                if ($discoloration->steps > $steps) {
                    $discoloration->steps = $steps;
                }
            }
            $discoloration->save();
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "更新成功", "date" => $discoloration];
        }
        $discoloration = FrontDiscoloration::create(["uid" => $uid, "nick_name" => $nick_name, "type" => $type, "level" => $level, "steps" => $steps]);
        if (!$discoloration) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "更新失败！"];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "更新成功！"];
    }

    /**
     * @param $uid
     * @param int $type
     * @return array
     */
    public function current($uid, $type = 0)
    {
        if ($type == 0) {
            $condition = ["uid" => $uid];
        } else {
            $condition = ["uid" => $uid, "type" => $type];
        }
        $discoloration = FrontDiscoloration::where($condition)->get();
        if ($discoloration->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "data" => []];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $discoloration];
    }

    /**
     * 排行榜
     * @return array
     */
    public function ranking()
    {
        $ordinary = FrontDiscoloration::where(["type" => 1])->orderBy('level', 'desc')->orderBy('steps', 'asc')
            ->offset(0)
            ->limit(5)->get();
        $advanced = FrontDiscoloration::where(["type" => 2])->orderBy('level', 'desc')->orderBy('steps', 'asc')
            ->offset(0)
            ->limit(5)->get();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => [
            "ordinary" => $ordinary,
            "advanced" => $advanced
        ]];
    }
}
