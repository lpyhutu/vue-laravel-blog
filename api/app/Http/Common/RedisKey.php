<?php


namespace App\Http\Common;

class RedisKey
{
    /**
     * PC端
     * @var string
     */
    public static $ARTICLE_READ_NUM = "article:read:num";//文章阅读量
    public static $ARTICLE_THUMB_NUM = "article:thumb:num";//文章点赞
    public static $COMMENT_THUMB_NUM = "comment:thumb:num";//评论点赞
    public static $MESSAGE_THUMB_NUM = "message:thumb:num";//留言点赞
    public static $LINK_VISIT_NUM = "link:visit:num";//链接访问量
    public static $TOTAL_LOCK = "total:isCreated:lock";//每天数据统计，存在即自增，不存在即添加一条数据
    public static $USER_LOGIN_LIST = "user:login:list";//用户当前是否第一次登陆
    public static $USER_REGISTER_LIST = "user:register:list";//用户是否第一次访问
    public static $USER_BLACK_LIST = "user:black:list";//黑名单
    public static $USER_FREQUENT_REQUEST_LIST = "user:frequent:request:list";//频繁请求
    public static $USER_FREQUENT_REQUEST_LOCK = "user:frequent:request:lock";//频繁请求锁
    public static $ADMIN_LOGIN_REQUEST_LOCK = "admin:login:request:lock";//后台登陆密码错误锁
    public static $ADMIN_LOGIN_REQUEST_LIST = "admin:login:request:list";//后台登陆密码错误列表

    /**
     * WeChat端
     */
    public static $WECHAT_USER_VISITS_LIST = "wechat:user:visits:list";//用户当天首次访问

}
