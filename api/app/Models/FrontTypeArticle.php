<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FrontTypeArticle extends Model
{
    protected $table = "blog_front_type_article";
    protected $dateFormat = 'U';
    protected $fillable = ["title", "sort", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 文章类别
     * @return hasMany
     */
    public function article()
    {
        return $this->hasMany('App\Models\FrontArticle', 'type', "id");
    }

    /**
     * 获取
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($start = 0, $pageSize = 15)
    {

        $type = FrontTypeArticle::orderBy('sort', 'asc')->with(["article" => function ($query) {
            return $query->where(["release" => 1]);
        }])->offset($start)->limit($pageSize)->get();
        if ($type->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontTypeArticle::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $type];
    }

    /**
     * 添加
     * @param string $title 类别标题
     * @param int $sort 权重
     * @param int $created_at 创建时间
     * @return array
     */
    public function add($title, $sort, $created_at)
    {
        $type = FrontTypeArticle::create(["title" => $title, "sort" => $sort, "created_at" => $created_at]);
        if (!$type) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $type];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $type];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $isArticleType = FrontArticle::where(["type" => $id])->first();
        if ($isArticleType) {
            return ["code" => Code::$WARNING, "msg" => "文章设置该类别，请删除后重试！"];
        }
        $type = FrontTypeArticle::destroy($id);
        if (!$type) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }

    /**
     * 修改
     * @param $params
     * @return array
     */
    public function edit($params)
    {
        $type = FrontTypeArticle::where(["id" => $params["id"]])->update($params);
        if (!$type) {
            return ["code" => Code::$WARNING, "msg" => "修改失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "修改成功！"];
    }

    /**
     * 发布
     * @param int $id id
     * @return array
     */
    public function release($id)
    {
        $type = FrontTypeArticle::where(["id" => $id])->first();
        if (!$type) {
            return ["code" => Code::$WARNING, "msg" => "该类别不存在！"];
        }
        $msg = $type->release === 1 ? "回收" : "发布";
        $type->release = $type->release === 1 ? 2 : 1;
        if (!$type->save()) {
            return ["code" => Code::$WARNING, "msg" => $msg . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $msg . "成功！"];
    }

    /**
     * 获取已发布
     * @return array
     */
    public function getRelease()
    {
        $type = FrontTypeArticle::where(["release" => 1])->with(["article" => function ($query) {
            return $query->where(["release" => 1]);
        }])->get();
        if ($type->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "data" => []];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $type];
    }
}
