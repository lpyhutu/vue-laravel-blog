@extends('layouts/default')
@section('title',$title)
@section('main')
    <div class="detail">
        <h1 class="title ht-font-size-22px">{{$article[0]->title}}</h1>
        <div class="info">
            <div class="item ">
                <div>分类</div>
                <div class="item-1">{{$article[0]->frontType->title}}</div>
            </div>
            <div class="item">
                <div>时间
                </div>
                <div class="item-2">{{$article[0]->created_at}}
                </div>
            </div>
            <div class="item">
                <div>访问</div>
                <div class="item-3">{{$article[0]->read_num}}</div>
            </div>
        </div>
        {!! editor_css() !!}
        {!! editor_js() !!}
        <article id="test-editormd-view" style="padding: 5px !important;">
            <div id="a-text" style="display:none;">{{$article[0]->content}}</div>
            <textarea id="append-test" style="display:none;"></textarea>
        </article>
        <div class="button">
            <button class="btn btn-primary btn-sm btn-article">
                <icon class="iconfont icon-like"></icon>
                <span style="padding-left: 5px;" class="thumb-num">{{$article[0]->thumb_num}}</span>
            </button>
        </div>
        <div class="other ht-flex">
            <div class="left">
                <img src="{{asset('img/qqgroup.jpg')}}" alt="QQ群二维码"/>
            </div>
            <div class="right">
                <div class="">
                    <span>作者：</span>
                    <span>{{$article[0]->author}}</span>
                </div>
                <div class="">
                    <span>邮箱：</span>
                    <span>{{$article[0]->email}}</span>
                </div>
                <div class="">
                    <span>链接：</span>
                    <span>
                    <a href="{{url("detail/".$article[0]->id)}}">{{url("detail/".$article[0]->id)}}</a>
                </span>
                </div>
                <div class="">
                    <span>原创文章，转载请标明出处，扫码加入学习交流群</span>
                </div>
            </div>
        </div>
        <div class="up-down">
            @if($downArticle!=null)
                <a href="{{url('detail/'.$downArticle->id)}}" class="item">上一篇：{{$downArticle->title}}</a>
            @endif
            @if($upArticle!=null)
                <a href="{{url('detail/'.$upArticle->id)}}" class="item">下一篇：{{$upArticle->title}}</a>
            @endif

        </div>
        <x-comment url="{{session('url')}}" emotionDom="emotion" currentEmotionDom="currentEmotionDom"></x-comment>
        <x-title title="留言列表"></x-title>
        <x-comment-list :comment="$comment"></x-comment-list>
        <x-toasts msg="感谢您的支持." current="t-thumb-suc"></x-toasts>
        <x-toasts msg="赞多了容易骄傲." current="t-thumb-too"></x-toasts>
    </div>
    <script>
        $(function () {
            $(".btn-article").click(function () {
                $.post("/articlethumb",
                    {'_token': '{{csrf_token()}}'},
                    function (res) {

                        const {code, data} = res
                        if (code === 1) {
                            $(".thumb-num").text(data.thumb_num)
                            $(".t-thumb-suc").toast('show')
                        } else {
                            $(".t-thumb-too").toast('show')
                        }
                    });
            })
            let testEditormdView;
            testEditormdView = editormd.markdownToHTML("test-editormd-view", {
                markdown: $("#a-text").text(),
                htmlDecode: "style,script,iframe",
                tocm: true,
                emoji: true,
                taskList: true,
                tex: true,
                flowChart: true,
                sequenceDiagram: true,
            });
        })
    </script>
    <style>

        .detail {
            padding: 30px 20px;
            background: #fff;
        }

        .detail > .title {
            text-align: center;
            padding-bottom: 10px;
        }

        .detail > .info {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail > .info > .item {
            display: flex;
            margin-right: 10px;
            font-size: 12px;
            color: #fff;
        }

        .detail > .info > .item div {
            display: flex;
            align-items: center;
            padding: 2px 3px;
        }

        .detail > .info > .item div:first-child {
            background-color: #000;

        }

        .detail article {
            margin: 30px 0;
        }

        .detail .button {
            display: flex;
            justify-content: center;
        }

        .detail .other {
            display: flex;
            margin: 10px 0 30px;
            padding: 10px;
            border-left: 3px solid #1890ff;
            background: #edf2f6;

        }

        .detail .other > .left {
            margin-right: 10px;


        }

        .detail .other > .left img {
            background: #fff;
            padding: 5px;
            height: 80px;
            width: 80px;
        }

        @media (max-width: 400px) {
            .other > .left img {
                display: none;
            }
        }

        .detail .other > .right {
            line-height: 160%;


        }

        .detail .other > .right a {
            text-decoration: none;
        }

        .detail .item-1 {
            background: rgb(1, 150, 155);
        }

        .detail .item-2 {
            background: #1890ff;
        }

        .detail .item-3 {
            background: rgb(207, 187, 5);
        }

        .detail .up-down {
            padding-bottom: 10px;
        }

        .detail .up-down a {
            display: block;
            color: #000000a6;
            padding: 5px 0;
        }

        .detail .up-down a:hover {
            color: #1890ff;
            cursor: pointer;
        }
    </style>

@endsection
