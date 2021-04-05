<?php


namespace App\Http\Common;


use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class Email
{
    /**
     * 友链申请
     */
    public static function linkApply()
    {
        Mail::send("mail.LinkApply", [], function (Message $message) {
            $message->to("1048672466@qq.com");
            $message->subject("糊涂博客——友链申请");
        });
        if (Mail::failures()) {
            return ["code" => 0, "msg" => "warning"];
        }
        return ["code" => 1, "msg" => "success"];
    }

    /**
     * 友链审核
     * @param $email
     * @return array
     */
    public static function linkReply($email)
    {
        Mail::send("mail.LinkReply", [], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject("糊涂博客——友链审核");
        });
        if (Mail::failures()) {
            return ["code" => 0, "msg" => "warning"];
        }
        return ["code" => 1, "msg" => "success"];
    }

    /**
     * 网站留言
     */
    public static function message()
    {
        Mail::send("mail.Message", [], function (Message $message) {
            $message->to("1048672466@qq.com");
            $message->subject("糊涂博客——网站留言");
        });
        if (Mail::failures()) {
            return ["code" => 0, "msg" => "warning"];
        }
        return ["code" => 1, "msg" => "success"];
    }

    /**
     * 网站留言回复
     * @param $email
     * @param $name
     * @return array
     */
    public static function messageReply($email, $name)
    {
        Mail::send("mail.MessageReply", ["name" => $name], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject("糊涂博客——留言回复");
        });
        if (Mail::failures()) {
            return ["code" => 0, "msg" => "warning"];
        }
        return ["code" => 1, "msg" => "success"];
    }

    /**
     * 文章评论
     * @param $id
     * @return array
     */
    public static function comment($id)
    {
        Mail::send("mail.Comment", ["id" => $id], function (Message $message) {
            $message->to("1048672466@qq.com");
            $message->subject("糊涂博客——文章评论");
        });
        if (Mail::failures()) {
            return ["code" => 0, "msg" => "warning"];
        }
        return ["code" => 1, "msg" => "success"];
    }

    /**
     * 文章留言回复
     * @param $id
     * @param $email
     * @return array
     */
    public static function commentReply($id, $email)
    {
        Mail::send("mail.CommentReply", ["id" => $id], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject("糊涂博客——留言回复");
        });
        if (Mail::failures()) {
            return ["code" => 0, "msg" => "warning"];
        }
        return ["code" => 1, "msg" => "success"];
    }

}
