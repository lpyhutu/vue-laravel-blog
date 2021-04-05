<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["middleware" => "clr"], function () {
    Route::group(["middleware" => "check.login"], function () {
        Route::get('/', "Index\IndexController@index")->name("/"); //首页
        Route::get('/page/{page?}/{type?}/{search?}', "Index\IndexController@index")->name("page");
        Route::get('/search/{page?}/{title?}', "Index\IndexController@search")->name("search");
        Route::get('/visitsTime', "Index\IndexController@visitsTime")->name("visitsTime");
        Route::get('/detail/{id}', "Index\DetailController@detail")->name("detail"); //文章详情
        Route::post('/articlethumb', "Index\DetailController@thumb")->name("articlethumb"); //文章点赞
        Route::post('/articlecommentthumb', "Index\DetailController@articleCommentThumb")->name("articlecommentthumb"); //评论留言点赞
        Route::post('/articlecomment', "Index\DetailController@articleComment")->name("articlecomment"); //文章留言
        Route::post('/articlecommentone', "Index\DetailController@articleCommentOne")->name("articlecommentone"); //评论文章留言
        Route::post('/articlecommenttwo', "Index\DetailController@articleCommentTwo")->name("articlecommenttwo"); //评论文章子留言

        Route::get('/message', "Index\MessageController@message"); //留言板
        Route::post('/messagecommentthumb', "Index\MessageController@messageCommentThumb")->name("messagecommentthumb"); //留言点赞
        Route::post('/messagecomment', "Index\MessageController@messageComment")->name("messagecomment"); //留言
        Route::post('/messagecommentone', "Index\MessageController@messageCommentOne")->name("messagecommentone"); //评论留言
        Route::post('/messagecommenttwo', "Index\MessageController@messageCommentTwo")->name("messagecommenttwo"); //评论子留言

        Route::get('/link', "Index\LinkController@link"); //友链
        Route::post('/applyLink', "Index\LinkController@applyLink"); //友链申请

        Route::get('/about', "Index\AboutController@about"); //关于
    });

});


