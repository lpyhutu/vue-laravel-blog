<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\FrontInfo;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $info;

    public function __construct()
    {
        $this->info = new FrontInfo();
    }

    public function about(Request $request)
    {
        $info = $this->info->getRelease();
        return view(
            "front.about",
            [
                "info" => $info["data"],
                "path" => $request->path(),
                "title" => "关于我 - 网页设计，模板分享，源码下载 - 糊涂博客",
                "keywords" => "关于,网站信息,站长信息",
                "description" => "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。"
            ]
        );
    }
}
