<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\MessageRequest;
use App\Models\FrontMessageSub;
use Illuminate\Http\Request;

class MessageSubController extends Controller
{
    protected $msgSub;

    public function __construct()
    {
        $this->msgSub = new FrontMessageSub();
    }

    /**
     * 获取
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $msg_id = $request->input("msg_id", 0);
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->msgSub->getAll($msg_id, $start, $pageSize);
    }

    /**
     * 修改
     * @param MessageRequest $request
     * @return array
     */
    public function edit(MessageRequest $request)
    {
        $params = $request->all();
        return $this->msgSub->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->msgSub->del(explode(",", $id));
    }

    /**
     * 添加
     * @param MessageRequest $request
     * @return array
     */
    public function add(MessageRequest $request)
    {
        $params = $request->all();
        return $this->msgSub->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->msgSub->release($id);
    }

    /**
     * 获取已发布
     * @return array
     */
    public function getRelease()
    {
        return $this->msgSub->getRelease();
    }

    /**
     * 评论
     * @param Request $request
     * @return array
     */
    public function comment(Request $request)
    {
        $params = $request->all();
        return $this->msgSub->comment($params);
    }

    /**
     * 评论子评论
     * @param Request $request
     * @return mixed
     */
    public function commentSub(Request $request)
    {
        $params = $request->all();
        return $this->msgSub->commentSub($params);
    }
}
