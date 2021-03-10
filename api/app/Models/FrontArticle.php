<?php

namespace App\Models;

use App\Http\Common\Code;
use App\Http\Common\RedisKey;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Redis;

class FrontArticle extends Model
{
    protected $table = "blog_front_article";
    protected $dateFormat = 'U';
    protected $fillable = ["title", "author", "cover_url", "email", "type", "img_url", "content", "release", "read_num", "thumb_num", "sort", "created_at"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 文章类别
     * @return HasOne
     */
    public function frontType()
    {
        return $this->hasOne('App\Models\FrontTypeArticle', 'id', "type");
    }

    /**
     * 留言
     * @return HasMany
     */
    public function frontComment()
    {
        return $this->hasMany('App\Models\FrontComment', 'article_id', "id");
    }

    /**
     * 子留言
     * @return HasMany
     */
    public function frontCommentSub()
    {
        return $this->hasMany('App\Models\FrontCommentSub', 'article_id', "id");
    }

    /**
     * 获取
     * @param int $release 状态
     * @param int $start 起始
     * @param int $pageSize 显示多少条
     * @return array
     */
    public function getAll($release = 0, $start = 0, $pageSize = 15)
    {
        $condition = [];
        if ($release !== 0) {
            $condition = ["release" => $release];
        }
        $article = FrontArticle::with('frontType')
            ->where($condition)
            ->orderBy('sort', 'asc')
            ->offset($start)
            ->limit($pageSize)
            ->get();
        if ($article->isEmpty()) {
            return [
                "code" => Code::$SUCCESS_NO_TIP,
                "msg" => "success",
                "total" => 0,
                "data" => []
            ];
        }
        $total = FrontArticle::where($condition)->count();
        return [
            "code" => Code::$SUCCESS_NO_TIP,
            "msg" => "success",
            "total" => $total,
            "data" => $article,
        ];
    }

    /**
     * 添加
     * @param $params
     * @return array
     */
    public function add($params)
    {
        $params["img_url"] = $this->getAllImgUrl($params["content"]);
        $article = FrontArticle::create($params);
        if (!$article) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！"];
        }
        file_put_contents(public_path() . "/upload/article/" . $article->id . ".txt", $article->content);
        $total = new FrontTotal();
        if ($total->isCreated()) {
            $total->createdPieceOfData(["article_num" => 1]);
        } else {
            $total->IncrementOfDecrement("article_num", 1, true);
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $article];
    }

    /**
     * 删除
     * @param array $ids
     * @return array
     */
    public function del($ids)
    {
        $type = FrontArticle::destroy($ids);
        if (!$type) {
            return ["code" => Code::$WARNING, "删除失败！"];
        }
        $total = new FrontTotal();
        if ($total->isCreated()) {
            $total->createdPieceOfData(["article_num" => -count($ids)]);
        } else {
            $total->IncrementOfDecrement("article_num", count($ids), false);
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
        $params["img_url"] = $this->getAllImgUrl($params["content"]);
        $article = FrontArticle::where(["id" => $params["id"]])->update($params);
        if (!$article) {
            return ["code" => Code::$WARNING, "msg" => "修改失败！"];
        }
        $article = FrontArticle::where(["id" => $params["id"]])->first();
        file_put_contents(public_path() . "/upload/article/" . $article->id . ".txt", $article->content);
        return ["code" => Code::$SUCCESS, "msg" => "修改成功！"];
    }

    /**
     * 发布
     * @param int $id id
     * @return array
     */
    public function release($id)
    {
        $article = FrontArticle::where(["id" => $id])->first();
        if (!$article) {
            return ["code" => Code::$WARNING, "msg" => "该文章不存在！"];
        }
        if ($article->release === 1) {
            $msg = "回收";
            $article->release = 2;
        } else {
            $msg = "发布";
            $article->release = 1;
            $this->postBaiDuUrl($article->id);
        }
        // $msg = $article->release === 1 ? "回收" : "发布";
        // $article->release = $article->release === 1 ? 2 : 1;
        // $article->release === 1 ? "" : $this->postBaiDuUrl($article->id);
        $res = $article->save();
        if (!$res) {
            return ["code" => Code::$WARNING, "msg" => $msg . "失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => $msg . "成功！"];
    }

    /**
     * 百度收录
     * @param $id
     */
    public function postBaiDuUrl($id)
    {
        $urls = array(
            'https://www.lpyhutu.cn/detail/' . $id,
        );
        $api = 'http://data.zz.baidu.com/urls?site=https://www.lpyhutu.cn&token=2zVGNl4Ki3fUWruE';
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        // echo $result;
    }

    /**
     * 搜索
     * @param string $title
     * @param int $start
     * @param int $pageSize
     * @return array
     */
    public function search($title, $start = 0, $pageSize = 15)
    {
        $article = FrontArticle::with('frontType')
            ->with(["frontComment" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->with(["frontCommentSub" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->where("title", "like", "%" . $title . "%")
            ->where(["release" => 1])
            ->orderBy('sort', 'asc')
            ->offset($start)->limit($pageSize)->get();
        if ($article->isEmpty()) {
            return ["code" => Code::$INFO, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = FrontArticle::where("title", "like", "%" . $title . "%")->count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $article];
    }

    /**
     * 获取已发布
     * @param int $start
     * @param int $pageSize
     * @return array
     */
    public function getRelease($start = 0, $pageSize = 15)
    {
        $article = FrontArticle::with('frontType')
            ->with(["frontComment" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->with(["frontCommentSub" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->where(["release" => 1])
            ->orderBy('created_at', 'desc')
            ->orderBy('sort', 'asc')
            ->offset($start)
            ->limit($pageSize)
            ->get();
        $readingRanking = FrontArticle::where(["release" => 1])
            ->orderBy('read_num', 'desc')
            ->offset(0)
            ->limit(10)
            ->get();
        $total = FrontArticle::where(["release" => 1])->count();
        return [
            "code" => Code::$SUCCESS_NO_TIP,
            "msg" => "success",
            "total" => $total,
            "data" => $article,
            "readingRanking" => $readingRanking,
        ];
    }

    /**
     * 详情
     * @param int $id 文章ID
     * @param string $uid uid
     * @return array
     */
    public function detail($id, $uid)
    {
        $article = FrontArticle::with('frontType')
            ->where(["release" => 1, "id" => $id])
            ->get();
        if ($article->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "该文章不存在！", "data" => $article];
        }
        //点击量
        $red = Redis::zscore(RedisKey::$ARTICLE_READ_NUM, $uid . $id);
        if (!$red) {
            $res = FrontArticle::where(["id" => $id])
                ->update(["read_num" => $article[0]->read_num + 1]);
            if ($res) {
                Redis::zadd(RedisKey::$ARTICLE_READ_NUM, 1, $uid . $id);
                Redis::expire(RedisKey::$ARTICLE_READ_NUM, strtotime(date("y-m-d 23:59:59")) - time());
            }
        }
        $upArticle = FrontArticle::where("id", ">", $id)->where(["release" => 1])->limit(1)->first();
        $downArticle = FrontArticle::where("id", "<", $id)->where(["release" => 1])->orderBy('id', 'desc')->limit(1)->first();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $article, "upArticle" => $upArticle, "downArticle" => $downArticle];

    }

    /**
     * 阅读排行
     * @return mixed
     */
    public function readingRanking()
    {
        $article = FrontArticle::where(["release" => 1])
            ->orderBy('read_num', 'desc')
            ->offset(0)
            ->limit(10)
            ->get();
        if ($article->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "该文章不存在！", "data" => $article];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $article];

    }

    /**
     * @param int $id 文章ID
     * @param int $uid uid
     * @return array
     */
    public function thumb($id, $uid)
    {
        $article = FrontArticle::where(["release" => 1, "id" => $id])
            ->first();
        if (!$article) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "该文章不存在！", "data" => $article];
        }
        $red = Redis::zscore(RedisKey::$ARTICLE_THUMB_NUM, $uid . "." . $id);
        if ($red) {
            return ["code" => Code::$INFO, "msg" => "赞多了容易骄傲！"];
        }
        $res = $article->increment("thumb_num");
        if ($res) {
            Redis::zadd(RedisKey::$ARTICLE_THUMB_NUM, 1, $uid . "." . $id);
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success"];
    }

    /**
     * 获取文章图片路径
     * @param $str
     * @return false|int|string
     */
    public function getAllImgUrl($str)
    {
        $reg = '/((http|https):\/\/)+(\w+\.)+(\w+)[\w\/\.\-]*(jpg|gif|png)/';
        $matches = array();
        preg_match_all($reg, $str, $matches);
        if (count($matches[0]) === 0) {
            return 0;
        }
        foreach ($matches[0] as $val) {
            $gallery = new Gallery();
            $gallery->add(explode("public/", $val)[1]);
        }
        return json_encode($matches[0]);
    }

    /**
     * 当前类别文章
     * @param $type
     * @param $start
     * @param $pageSize
     * @return array
     */
    public function currentTypeArticle($type, $start, $pageSize)
    {
        $article = FrontArticle::where(["release" => 1, "type" => $type])
            ->with(["frontComment" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->with(["frontCommentSub" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->offset($start)
            ->limit($pageSize)
            ->get();
        if ($article->isEmpty()) {
            return ["code" => Code::$WARNING, "msg" => "空空如也！", "data" => $article];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $article];
    }

    /**
     * 当前类别文章wechat
     * @param $type
     * @return array
     */
    public function currentType($type)
    {
        $article = FrontArticle::where(["release" => 1, "type" => $type])
            ->with(["frontComment" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->with(["frontCommentSub" => function ($query) {
                return $query->where(["release" => 1]);
            }])
            ->get();
        if ($article->isEmpty()) {
            return ["code" => Code::$WARNING, "msg" => "空空如也！", "data" => $article];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "data" => $article];
    }

}
