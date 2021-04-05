<div class="link">
    <x-card title="链接推荐">
        <div class="list">
            @foreach($link as $item)
                <a href="{{$item['site']}}" target="_blank">
                    <img
                        src="{{asset($item["img_url"])}}"
                        alt="">
                    <span>{{$item["title"]}}</span>
                </a>
            @endforeach
        </div>

    </x-card>
</div>
<style>
    .link {
        margin-top: 15px;

    }

    .link .list {
        display: flex;
        flex-wrap: wrap;
    }

    .link .list > a {
        display: flex;
        align-items: center;
        cursor: pointer;
        color: #000000a6;
        padding: 5px 10px;
    }

    .link .list > a img {
        width: 28px;
        height: 28px;
    }

    .link .list > a span {
        padding-left: 5px;
    }

    .link .list > a:hover {
        color: #1890ff;
        cursor: pointer;
    }
</style>
