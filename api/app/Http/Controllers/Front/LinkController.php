<?php

namespace App\Http\Controllers\Front;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\LinkRequest;
use App\Models\FrontLink;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected $link;

    public function __construct()
    {
        $this->link = new FrontLink();
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
        return $this->link->getAll($start, $pageSize);
    }

    /**
     * 修改
     * @param LinkRequest $request
     * @return array
     */
    public function edit(LinkRequest $request)
    {
        $params = $request->all();
        return $this->link->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->link->del(explode(",", $id));
    }

    /**
     * 添加
     * @param LinkRequest $request
     * @return array
     */
    public function add(LinkRequest $request)
    {
        $params = $request->all();
        return $this->link->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->link->release($id);
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */

    public function getRelease(Request $request)
    {
        return $this->link->getRelease();
    }

    /**
     * 链接访问量
     * @param IdRequest $request
     * @return mixed
     */
    public function visitNum(IdRequest $request)
    {
        $id = $request->input("id");
        $uid = $request->input("uid");
        return $this->link->visitNum($id, $uid);
    }
}
