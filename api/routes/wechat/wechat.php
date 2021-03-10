<?php

use Illuminate\Support\Facades\Route;

Route::group(["namespace" => "WeChat", "prefix" => "wechat"], function () {
    Route::post("article/get", "ArticleController@getRelease"); //获取已发布文章
    Route::post("article/detail", "ArticleController@detail"); //获取已发布文章
    Route::post("article/thumb", "ArticleController@thumb"); //文章点赞
    Route::post("article/currentTypeArticle", "ArticleController@currentTypeArticle"); //当前类别文章
    Route::post("article/search", "ArticleController@search"); //文章搜索
    Route::post("type/get", "TypeArticleController@getRelease"); //文章类别
    Route::post("log/get", "LogController@getRelease"); //日志
    Route::post("user/login", "UserController@login"); //用户登陆
    Route::post("user/register", "UserController@register"); //用户信息注册
    Route::post("user/visitsTime", "UserController@visitsTime"); //用户浏览时长

    Route::get("user/index", "UserController@index"); //测试
});
