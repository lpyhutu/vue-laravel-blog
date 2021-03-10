<?php

namespace App\Http\Controllers\Front;

use App\Http\Common\Ip;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\MessageRequest;
use App\Models\FrontComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comment;

    public function __construct()
    {
        $this->comment = new FrontComment();
    }

    /**
     * 获取
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $release = $request->input("release", 0);
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->comment->getAll($release, $start, $pageSize);
    }

    /**
     * 修改
     * @param MessageRequest $request
     * @return array
     */
    public function edit(MessageRequest $request)
    {
        $params = $request->all();
        return $this->comment->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id");
        return $this->comment->del(explode(",", $id));
    }

    /**
     * 添加
     * @param MessageRequest $request
     * @return array
     */
    public function add(MessageRequest $request)
    {
        $article_id = $request->input("article_id");
        $qq = $request->input("qq");
        $name = $request->input("name");
        $email = $request->input("email");
        $avatar = $request->input("avatar");
        $content = $request->input("content");
        $release = 1;
        return $this->comment->add($article_id, $qq, $name, $email, $avatar, $content, $release);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->comment->release($id);
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        $articleId = $request->input("article_id", 0);
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->comment->getRelease($articleId, $start, $pageSize);
    }

    /**
     * 点赞
     * @param IdRequest $request
     * @return array
     */
    public function thumb(IdRequest $request)
    {
        $id = $request->input("id", 0);
        $sub_id = $request->input("sub_id", 0);
        $uid = $request->input("uid");
        return $this->comment->thumb($id, $sub_id, "00" . $uid);
    }
}
