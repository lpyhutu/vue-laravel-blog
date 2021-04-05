@if($pageNum>1)
    <nav aria-label="Page navigation example" class="nav-a">
        <ul class="pagination">
            <li class="page-item {{$page>1?'':'disabled'}}">
                <a class="page-link" href="{{route($route,array("page"=>$page-1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}"
                   aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for($i=0;$i<$pageNum;$i++)
                @if($pageNum<=5)
                    <li class="page-item {{($i+1)==$page?'active':''}}">
                        <a class="page-link"
                           href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                    </li>
                @elseif($pageNum>5)
                    @if($i<5&&$page<5)
                        <li class="page-item {{($i+1)==$page?'active':''}}">
                            <a class="page-link"
                               href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                        </li>
                    @elseif($i==$pageNum-2)
                        <li class="page-item {{$page<$pageNum-2?'disabled':''}}  {{($i+1)==$page?'active':''}}">
                            <a class="page-link"
                               href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$page<$pageNum-2?'...':$i+1}}</a>
                        </li>
                    @elseif($i==$pageNum-1)
                        <li class="page-item  {{($i+1)==$page?'active':''}}">
                            <a class="page-link"
                               href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                        </li>
                    @elseif($page>=5)
                        @if($i==0)
                            <li class="page-item {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                            </li>
                        @elseif($i==1)
                            <li class="page-item disabled {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">...</a>
                            </li>
                        @elseif($i==$page-3)
                            <li class="page-item {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                            </li>
                        @elseif($i==$page-2)
                            <li class="page-item {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                            </li>
                        @elseif($i==$page-1)
                            <li class="page-item {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                            </li>
                        @elseif($i==$page)
                            <li class="page-item {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                            </li>
                        @elseif($i==$page+1)
                            <li class="page-item {{($i+1)==$page?'active':''}}">
                                <a class="page-link"
                                   href="{{route($route,array("page"=>$i+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}">{{$i+1}}</a>
                            </li>
                        @endif
                    @endif
                @endif
            @endfor
            <li class="page-item  {{$page>$pageNum-1?'disabled':''}}">
                <a class="page-link" href="{{route('page',array("page"=>$page+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <nav aria-label="Page navigation example" class="nav-b ">
        <ul class="pagination">
            <li class="page-item {{$page>1?'':'disabled'}}">
                <a class="page-link" href="{{route($route,array("page"=>$page-1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}"
                   aria-label="Previous">
                    <span aria-hidden="true">上一页</span>
                </a>
            </li>
            <li>{{$page}}/{{$pageNum}}</li>
            <li class="page-item  {{$page>$pageNum-1?'disabled':''}}">
                <a class="page-link" href="{{route('page',array("page"=>$page+1,"type"=>Request()->route("type")==null?'':Request()->route("type"),"search"=>Request()->route("search")))}}" aria-label="Next">
                    <span aria-hidden="true">下一页</span>
                </a>
            </li>
        </ul>
    </nav>
@endif
<style>
    .nav-a {
        display: flex;
        flex: 1;
    }

    .nav-a .pagination {
        background: #fff;
        padding: 10px;
        flex: 1;
        justify-content: flex-end;
    }

    .nav-b {
        display: flex;
        display: none;
        flex: 1;
        align-items: center;
    }

    .nav-b .pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 1;
        background: #fff;
        padding: 10px;

    }

    .nav-b .page-link {
        border-radius: 0.3rem !important;
    }

    @media (max-width: 767px) {
        .nav-a {
            display: none;
        }

        .nav-b {
            display: block;
        }
    }
</style>
