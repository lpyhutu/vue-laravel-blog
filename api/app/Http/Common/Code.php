<?php


namespace App\Http\Common;


class Code
{
    public static $SUCCESS_NO_TIP = 1;
    public static $SUCCESS = 1001;//成功
    public static $INFO = 1002;//提示
    public static $WARNING = 1003;//警告
    public static $ERROR = 1004;//错误
    public static $ERROR_REQUEST = 1005;//异常请求
    public static $LOGIN_NOT = 1006;//未登陆
    public static $LOGIN_EXPIRE = 1007;//效验过期
    public static $TOKEN_REFRESH_SUCCESS = 1008;//刷新成功
    public static $USER_BLACK = 1009;//黑名单
    public static $USER_FREQUENT = 1010;//频繁请求
}
