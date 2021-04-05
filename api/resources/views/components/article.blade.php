@foreach ($article as $item)
    {{Request()->route("11")}}
    <div class="article">
        <h1 class="ht-font-size-20px"><a href="{{route('detail',array("id"=>$item->id))}}"
                                         rel="noopener noreferrer">{{$item->title}}</a></h1>
        <div class="center">
            <img src="{{asset($item->cover_url)}}"
                 alt="{{mb_substr($item->title,0,15,"utf-8")}}" onerror="handleOnloadImg(this)">
            <div class="text"> 摘要：{{str_replace("#", "", $item->content)}}
            </div>
        </div>
        <div class="footer">
            <span>posted @</span>
            <span>{{$item->created_at}}</span>
            <span>{{ $item->author }}</span>
            <span>阅读({{ $item->read_num }})</span>
            <span>评论({{count($item->frontComment)+count($item->frontCommentSub)}})</span>
            <span>点赞({{$item->thumb_num}})</span>
        </div>
    </div>
@endforeach

<script>
    function handleOnloadImg(e) {
        e.src = "img/article.png"
        e.src.onerror = null; //控制不要一直跳动
    }
</script>
<style>

    .article {
        background-color: #fff;
        padding: 20px;
        /*margin-bottom: 15px;*/
        /*-webkit-transition: all 0.3s;*/
        /*-o-transition: all 0.3s;*/
        /*-moz-transition: all 0.3s;*/
        /*transition: all 0.3s;*/
        border-top: 1px dashed #fff;
        border-left: 1px dashed #fff;
        border-right: 1px dashed #fff;
        border-bottom: 1px dashed #d0d0d0;
    }

    .article h1 {
        display: -webkit-box;
        display: -moz-box;
        overflow: hidden;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .article:hover {
        /*transform: scale(1.02);*/
        border: 1px dashed #1890ff;
    }

    .article h1 a {
        color: #000000a6;
    }

    .article h1 a:hover {
        color: #1890ff;
        cursor: pointer;
    }

    .article > .center {
        display: flex;
        padding: 15px 0;
    }

    .article > .center img {
        min-width: 160px;
        height: 100px;
    }

    .article > .center .text {
        display: -webkit-box;
        display: -moz-box;
        overflow: hidden;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        padding-left: 10px;
        line-height: 180%;
        white-space: normal;
        word-wrap: break-word;
        word-break: break-all;
        text-overflow: ellipsis;
    }

    .article > .footer {
        color: #b3b0b0;
    }

    .article > .footer span {
        padding-right: 5px;
    }

    .paging {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        background: #fff;
        padding: 20px 20px 0px;
    }

    .paging .pagination {
        flex-wrap: wrap;
    }
</style>
