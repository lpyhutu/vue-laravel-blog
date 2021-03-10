<?php

use Illuminate\Support\Facades\Route;

/**
 * PC端前台
 */
Route::post("user/login", "Front\UserController@login");//访问
Route::group(["middleware" => "request.jwt"], function () {
    Route::post("common/qqInfo", "Common\CommonController@qqInfo");//qq详情
    Route::post("article/article", "Front\ArticleController@getRelease");//文章列表
    Route::post("article/detail", "Front\ArticleController@detail");//文章详情
    Route::post("article/thumb", "Front\ArticleController@thumb");//文章点赞
    Route::post("article/ranking", "Front\ArticleController@ranking");//阅读排行
    Route::post("article/search", "Front\ArticleController@search");//搜索
    Route::post("article/type", "Front\ArticleController@type");//当前类别文章

    Route::post("type/get", "Front\TypeArticleController@getRelease"); //文章类别
    Route::post("link/link", "Front\LinkController@getRelease");//链接列表
    Route::post("link/visitNum", "Front\LinkController@visitNum");//链接访问量
    Route::post("link/apply", "Front\LinkController@add");//申请链接
    Route::post("info/info", "Front\InfoController@getRelease");//基本信息
    Route::post("msg/msg", "Front\MessageController@getRelease");//留言列表
    Route::post("msg/add", "Front\MessageController@add");//留言
    Route::post("msg/thumb", "Front\MessageController@thumb");//留言点赞
    Route::post("msgSub/comment", "Front\MessageSubController@comment");//留言评论
    Route::post("msgSub/commentSub", "Front\MessageSubController@commentSub");//子留言评论
    Route::post("comment/comment", "Front\CommentController@getRelease");//评论列表
    Route::post("comment/thumb", "Front\CommentController@thumb");//评论点赞
    Route::post("comment/add", "Front\CommentController@add");//评论
    Route::post("commentSub/comment", "Front\CommentSubController@comment");//评论
    Route::post("commentSub/commentSub", "Front\CommentSubController@commentSub");//子评论
    Route::post("total/visitsTime", "Front\TotalController@visitsTime");//浏览时长
    Route::post("total/num", "Front\TotalController@num");//统计

    Route::post("discoloration/current", "Front\DiscolorationController@current");//获取信息
    Route::post("discoloration/add", "Front\DiscolorationController@add");//添加游戏用户
    Route::post("discoloration/edit", "Front\DiscolorationController@edit");//更新游戏用户信息
    Route::post("discoloration/ranking", "Front\DiscolorationController@ranking");//游戏排行

    Route::get("index/index", "Index\IndexController@index");
});
