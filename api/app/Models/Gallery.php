<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = "blog_gallery";
    protected $dateFormat = 'U';
    protected $fillable = ["img_url", "created_at"];

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
            $gallery = Gallery::get();
        } else {
            $gallery = Gallery::offset($start)->limit($pageSize)->get();
        }
        if ($gallery->isEmpty()) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "空空如也！", "total" => 0, "data" => []];
        }
        $total = Gallery::count();
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success", "total" => $total, "data" => $gallery];
    }

    /**
     * 添加图片
     * @param $img_url
     * @return array
     */
    public function add($img_url)
    {
        $gallery = Gallery::where(["img_url" => $img_url])->first();
        if ($gallery) {
            return ["code" => Code::$WARNING, "msg" => "该图片已存在.", "data" => []];
        }
        $gallery = Gallery::create(["img_url" => $img_url]);
        if (!$gallery) {
            return ["code" => Code::$WARNING, "msg" => "添加失败！", "data" => $gallery];
        }
        return ["code" => Code::$SUCCESS, "msg" => "添加成功！", "data" => $gallery];
    }

    /**
     * 删除
     * @param string $id
     * @return array
     */
    public function del($id)
    {
        $type = Gallery::destroy($id);
        if (!$type) {
            return ["code" => Code::$WARNING, "msg" => "删除失败！"];
        }
        return ["code" => Code::$SUCCESS, "msg" => "删除成功！"];
    }
}
