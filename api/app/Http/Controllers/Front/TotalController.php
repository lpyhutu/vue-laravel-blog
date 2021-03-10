<?php


namespace App\Http\Controllers\Front;


use App\Http\Common\Ip;
use App\Http\Requests\IdRequest;
use App\Models\FrontTotal;
use Illuminate\Http\Request;

class TotalController
{
    protected $total;

    public function __construct()
    {
        $this->total = new FrontTotal();
    }

    /**
     * 获取
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->total->getAll($start, $pageSize);
    }

    /**
     * 浏览时长
     * @param Request $request
     * @return array|bool
     */
    public function visitsTime(Request $request)
    {
        $ip = Ip::getClientIp();
        $uid = $request->input("uid");
        return $this->total->visitsTime($uid);
    }

    /**
     * 后台数据统计
     * @return array
     */
    public function totalNum()
    {
        return $this->total->totalNum();
    }

    /**
     * 前台数据统计
     * @return array
     */
    public function num()
    {
        return $this->total->num();
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id");
        return $this->total->del(explode(",", $id));
    }
}
