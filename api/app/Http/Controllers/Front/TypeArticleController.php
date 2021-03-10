<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\TypeRequest;
use App\Models\FrontTypeArticle;
use Illuminate\Http\Request;

class TypeArticleController extends Controller
{
    protected $type;

    public function __construct()
    {
        $this->type = new FrontTypeArticle();
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
        return $this->type->getAll($start, $pageSize);
    }

    /**
     * 修改
     * @param TypeRequest $request
     * @return array
     */
    public function edit(TypeRequest $request)
    {
        $params = $request->all();
        return $this->type->edit($params);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->type->del(explode(",", $id));
    }

    /**
     * 添加
     * @param TypeRequest $request
     * @return array
     */
    public function add(TypeRequest $request)
    {
        $title = $request->input("title");
        $sort = $request->input("sort");
        $created_at = $request->input("created_at");
        return $this->type->add($title, $sort, $created_at);
    }

    /**
     * 发布
     * @param IdRequest $request
     * @return array
     */
    public function release(IdRequest $request)
    {
        $id = $request->post("id");
        return $this->type->release($id);
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        return $this->type->getRelease();
    }
}
