<div class="user">
    <x-card title="网站信息">

        <div class="item">
            <icon class="iconfont icon-user"></icon>
            <span>博主：</span>
            <span>糊涂</span>
        </div>
        <div class="item">
            <icon class="iconfont icon-github-fill"></icon>
            <span>Github：</span><span>
                <a href="https://github.com/lpyhutu" target="_blank">Github</a></span>
        </div>
        <div class="item">
            <icon class="iconfont icon-mail"></icon>
            <span>联系邮箱：</span><span><a href=" http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=1048672466@qq.com"
                                       target="_blank">1048672466@qq.com</a></span>
        </div>
        <div class="item">
            <icon class="iconfont icon-team"></icon>
            <span>在线人数：</span>
            <span class="online">0</span>
        </div>
        <div class="item">
            <icon class="iconfont icon-file-text"></icon>
            <span>文章数量：</span>
            <span>{{json_decode($total)->article_num}}</span>
        </div>
        <div class="item">
            <icon class="iconfont icon-areachart"></icon>
            <span>访问总量：</span>
            <span>{{json_decode($total)->visitsInterval}}</span>
        </div>

    </x-card>
</div>
<script>
    $(function () {
        function handleOnline() {
            const url = "wss://wss.lpya.cn/blog";
            if (window.WebSocket) {
                const websocket = new WebSocket(url);
                websocket.onopen = function (e) {
                    send()
                }
                websocket.onmessage = function (e) {
                    const data = JSON.parse(e.data);
                    if (data.type === "online") {
                        $(".online").text(data.data.online)
                    }
                }
                function send() {
                    websocket.send(JSON.stringify({
                        type: "front",
                        group: "front_login",
                    }));
                }
            }
        }

        handleOnline()
    })
</script>
<style>
    .user .item {
        padding: 8px 0;
    }

    .user .item span {
        padding-left: 5px;
    }
</style>
