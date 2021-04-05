<div class="type">
    <x-card title="文章类别">
        @foreach($type as $item)
            <a href="{{route('page',array("page"=>1,"type"=>$item["id"]))}}">{{$item["title"]}}({{count($item["article"])}})</a>
        @endforeach
    </x-card>
</div>
<style>
    .type {
        margin: 15px 0;
    }

    .type a {
        cursor: pointer;
        padding: 12px 0px;
        border-bottom: 1px dashed #eee;
        color: #000000a6;
        display: block;
    }

    .type a:hover {
        color: #1890ff;
    }
</style>
