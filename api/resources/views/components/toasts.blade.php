<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div id="liveToast" class="toast hide {{$current}}" role="alert" aria-live="assertive" aria-atomic="true"
         data-delay="2500">
        <div class="toast-header">
            <img src="{{asset('img/logo.png')}}" class="rounded mr-2" alt="logo" style="height: 18px;width: 18px">
            <strong class="mr-auto">温馨提示</strong>
            <small>最新消息</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {{$msg}}
        </div>
    </div>
</div>
