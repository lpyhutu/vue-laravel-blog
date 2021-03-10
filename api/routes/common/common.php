<?php
use Illuminate\Support\Facades\Route;

/**
 * 通用
 */
Route::group(["namespace" => "Common", "prefix" => "common"], function () {
    Route::post("captcha", "CommonController@captcha");  //验证码
    Route::post("upload", "CommonController@upload");//文件上传
    Route::post("uploadLogo", "CommonController@uploadLogo");//Logo上传


    Route::post("remove", "CommonController@remove");//文件删除
});
