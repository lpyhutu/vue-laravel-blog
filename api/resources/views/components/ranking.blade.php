<x-card title="阅读排行">
    <div class="ranking">
        @foreach($reading as $key=>$item)
            <a href="{{route('detail',array("id"=>$item["id"]))}}"> <span>{{$key+1}}、</span>
                <span>{{$item["title"]}}
            </span>
                <span>({{$item["read_num"]}})</span>
            </a>
        @endforeach
    </div>
</x-card>

<style>
    .ranking > a {
        cursor: pointer;
        padding: 8px 0px;
        border-bottom: 1px dashed #eee;
        line-height: 180%;
        display: inline-block;
        color: #000000a6;


    }

    .ranking > a:hover {
        color: #1890ff;
    }
</style>
