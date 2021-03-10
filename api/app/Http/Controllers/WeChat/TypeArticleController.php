<?php

namespace App\Http\Controllers\WeChat;

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
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        return $this->type->getRelease();
    }
}
