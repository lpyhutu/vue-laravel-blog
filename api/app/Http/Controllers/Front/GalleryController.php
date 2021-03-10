<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $gallery;

    public function __construct()
    {
        $this->gallery = new Gallery();
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
        return $this->gallery->getAll($start, $pageSize);
    }

    /**
     * 删除
     * @param IdRequest $request
     * @return array
     */
    public function delete(IdRequest $request)
    {
        $id = $request->input("id");
        return $this->gallery->del(explode(",", $id));
    }
}
