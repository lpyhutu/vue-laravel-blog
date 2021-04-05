<?php

namespace App\Http\Controllers\Index;

use App\Http\Common\Code;
use App\Http\Controllers\Controller;
use App\Models\FrontLink;
use App\Models\Gallery;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected $link;
    protected $gallery;

    public function __construct()
    {
        $this->link = new FrontLink();
        $this->gallery = new Gallery();
    }

    public function link(Request $request)
    {
        $link = $this->link->getRelease();
        return view(
            "front.link",
            [
                "link" => $link["data"],
                "path" => $request->path(),
                "title" => "友情链接 - 网页设计，模板分享，源码下载 - 糊涂博客",
                "keywords" => "友链,友链申请",
                "description" => "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。"
            ]
        );
    }

    public function applyLink(Request $request)
    {
        $title = $request->input("title");
        $email = $request->input("email");
        $site = $request->input("site");
        $file = $request->file('file');
        $allowed_extensions = ["png", "jpg", "gif"];
        if (!in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            abort(500, "File upload category error.");
        }
        $destinationPath = 'upload/logo/' . date("Ymd") . '/';
        $extension = $file->getClientOriginalExtension();
        $fileName = md5(time() . rand(1, 1000)) . '.' . $extension;
        $file->move($destinationPath, $fileName);
        $fileName = $destinationPath . $fileName;
        $this->gallery->add($fileName);
        $link = $this->link->add(["img_url" => $fileName, "title" => $title, "site" => $site, "email" => $email]);
        if ($link["code"] === 1001) {
            return redirect("link");
        }
        return redirect()->back();
    }

}
