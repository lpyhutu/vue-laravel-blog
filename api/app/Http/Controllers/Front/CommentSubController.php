<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\MessageRequest;
use App\Models\FrontCommentSub;
use Illuminate\Http\Request;

class CommentSubController extends Controller
{
    protected $commentSub;

    public function __construct()
    {
        $this->commentSub = new FrontCommentSub();
    }

    /**
     * 获取
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $msg_id = $request->input("msg_id", 0);
        $article_id = $request->input("article_id", 0);
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->commentSub->getAll($msg_id, $article_id, $start, $pageSize);
    }

    /**
     * 修改
     * @param MessageRequest $request
     * @return array
     */
    public function edit(MessageRequest $request)
    {
        $params = $request->all();
        return $this->commentSub->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->commentSub->del(explode(",", $id));
    }

    /**
     * 添加
     * @param MessageRequest $request
     * @return array
     */
    public function add(MessageRequest $request)
    {
        $params = $request->all();
        return $this->commentSub->add($params);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->commentSub->release($id);
    }

    /**
     * 获取已发布
     * @return array
     */
    public function getRelease()
    {
        return $this->commentSub->getRelease();
    }

    /**
     * 评论
     * @param Request $request
     * @return array
     */
    public function comment(Request $request)
    {
        $params = $request->all();
        return $this->commentSub->comment($params);
    }

    /**
     * 评论子评论
     * @param Request $request
     * @return mixed
     */
    public function commentSub(Request $request)
    {
        $params = $request->all();
        return $this->commentSub->commentSub($params);
    }
}
