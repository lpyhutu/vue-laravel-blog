@extends('layouts/default')
@section('title',$title)
@section('main')
    <div class="ht-link">
        <x-title title="温馨提示"></x-title>
        <div class="tip">
            <p>
                1、本站欢迎交换友链，如果想和本站交换友情链接的，欢迎在此申请；
            </p>
            <p>2、网站内容健康积极向上，对网站收录量无要求；</p>
            <p>3、审核结果均以邮件形式通知，请输入常用有效邮箱；</p>
            <p>
                4、若无意外，在申请友链后24小时内完成审核并录入站点，如超时还未审核完成，请留言或者私信给我。
            </p>
        </div>
        <x-apply-link></x-apply-link>
        <x-title title="链接列表"></x-title>
        <div class="list">
            @foreach($link as $item)
                <a href="{{$item->site}}" target="_blank" class="item">
                    <img
                        src="{{asset($item->img_url)}}"
                        alt="{{$item->title}}"/>
                    <span>{{$item->title}}</span>
                </a>
            @endforeach
        </div>
    </div>
    <style>
        .ht-link {
            padding: 20px;
            background: #fff;
        }

        .ht-link > .tip {
            padding: 10px 0;
        }

        .ht-link .list {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;

        }

        .ht-link .list a {
            cursor: pointer;
            color: #000000a6;
            padding: 5px 10px;
            display: flex;
            align-items: center;
        }

        .ht-link .list > a:hover {
            color: #1890ff;
        }

        .ht-link .list a img {
            width: 25px;
            height: 25px;
        }

        .ht-link .list a span {
            padding-left: 5px;
        }
    </style>

@endsection

