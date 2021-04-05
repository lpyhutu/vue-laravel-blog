@extends('layouts/default')
@section('title',$title)
@section('main')
    <div class="ht-message">
        <x-title title="温馨提示"></x-title>
        <div class="tip">
            <p>1、欢迎大家在这留言或提意见建议；</p>
            <p>
                2、留言内容要健康积极向上，不得刷评论、发表不良信息；
            </p>
            <p>3、回复均以邮件形式通知，请输入常用有效邮箱；</p>
            <p>
                4、如果发现某些功能不能使用，请联系邮箱
                1048672466@qq.com。
            </p>
        </div>
        <x-comment url="{{session('url')}}" emotionDom="emotion" currentEmotionDom="currentEmotionDom"></x-comment>
        <x-title title="留言列表"></x-title>
        <x-comment-list :comment="$comment"></x-comment-list>
        <x-toasts msg="感谢您的支持." current="t-thumb-suc"></x-toasts>
        <x-toasts msg="赞多了容易骄傲." current="t-thumb-too"></x-toasts>
    </div>

    <style>
        .ht-message {
            padding: 20px;
            background: #fff;
        }

        .ht-message > .tip {
            padding: 10px 0;
        }
    </style>
@endsection

