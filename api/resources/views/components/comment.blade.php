<form class="comment" novalidate action="{{route($url)}}" method="post" onsubmit="return handleComment(this)">
    {{csrf_field()}}
    <div class="form-row">
        <img class="d-avatar" src="{{asset('img/avatar.png')}}" alt="头像">
        <div class="col-md-3 mb-3">
            <input type="text" name="qq" class="d-qq form-control form-control-sm" required
                   placeholder="请输入QQ号">
            <div class="invalid-feedback">
                QQ格式错误.
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" name="email" class="d-email form-control form-control-sm" required readonly
                   placeholder="邮箱（自动获取）">
            <div class="invalid-feedback">
                Email格式错误.
            </div>
        </div>
    </div>
    <input type="text" name="comment_id" value="{{$commentId}}" style="display: none">
    <div class="form-row" style="padding: 5px 0 15px;">
        <textarea name="content" class="d-content form-control form-control-sm" required rows="5"></textarea>
        <div class="invalid-feedback">
            说点什么好呢.
        </div>
    </div>
    <div class="footer">
        <icon id="{{$emotionDom}}" class="iconfont icon-Ovalx" title="<span style='font-size:12px'>表情包</span>"
              data-container="body"
              data-toggle="popover" data-placement="top"
              data-content=""></icon>
        <button class="btn btn-primary btn-sm" type="submit">
            <icon class="iconfont icon-comment"></icon>
            <span style="padding-left: 5px;">评论</span>
        </button>
    </div>
    <x-toasts msg="QQ账号格式错误." current="t-qq"></x-toasts>
    <x-toasts msg="说什么什么好呢." current="t-content"></x-toasts>
</form>
<script>
    function handleComment() {
        const qq = $(".d-qq").val();
        const content = $(".d-content").val();
        if (qq === "" || content === "") {
            return false
        }
        return true;
    }

    function handleCurrentEmotion(e) {
        console.log(e)
    }

    $(function () {
        function handleEmotion() {
            const emotion = [
                "那么大",
                "可怜",
                "酷",
                "邪笑",
                "得意",
                "坏笑",
                "抓狂",
                "哭笑",
                "钱",
                "亲亲",
                "恐惧",
                "可爱",
                "抠鼻",
                "无语",
                "互粉",
                "哭",
                "大哭",
                "委屈",
                "色",
                "鄙视",
                "亲",
                "再见",
                "无力",
                "怒",
                "害羞",
                "你懂的",
                "求关注",
                "看你的",
                "比耶",
                "哭笑不得",
                "喜欢",
                "踩",
                "大笑",
                "困",
                "惊讶",
                "爱心",
                "疑问",
                "忍不住",
                "鼓掌",
                "金牙",
                "傻了",
                "衰",
                "偷笑",
                "思考",
                "吐血",
                "可爱的",
                "嘘",
                "尴尬",
                "傲慢",
                "傻帽",
                "笑笑",
                "戴口罩",
                "调皮",
                "晕",
                "闭嘴",
                "吃瓜",
                "咧嘴",
                "无语中",
                "小眼睛",
                "点赞",
                "吐",
                "玫瑰",
                "狗头",
                "去污粉",
                "六六六",
            ]
            let html = "";
            emotion.map((item, index) => {
                html = html + `<div class='list {{$currentEmotionDom}}' onclick='handleCurrentEmotion()'><img class='emotion-img' src='{{asset('/upload/img/emotion/${index}.png')}}' alt='[${item}]' title='${item}'></div>`
            })
            return `<div class='emotion'>${html}</div>`
        }

        $("#{{$emotionDom}}").popover(
            {
                html: true,
                content: handleEmotion(),
            }).on("shown.bs.popover", function () {
            $(".{{$currentEmotionDom}}").click(function () {
                const emotionText = $(this).children("img").attr("alt")
                const content = $(".d-content").val();
                $(".d-content").val(content + emotionText)
                $("#emotion").popover("hide")

            })
        });
        $('.d-qq').blur(function () {
            const qq = $(this).val();
            const reg = /^[1-9][0-9]{4,10}$/;
            if (!reg.test(qq)) {
                $('.d-qq').val("");
                $(".t-qq").toast('show')
                return false;
            }
            $('.d-qq').val(qq);
            $('.d-email').val(`${qq}@qq.com`);
            $(".d-avatar").attr("src", `https://q.qlogo.cn/headimg_dl?dst_uin=${qq}&spec=100`);
        })

        function handleComment() {
            window.addEventListener('load', function () {
                let forms = document.getElementsByClassName('comment');
                let validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        }

        handleComment()


    })
</script>

<style>

    .comment {
        padding: 10px;
    }

    .comment .footer {
        display: flex;
        justify-content: space-between;
    }

    .comment .form-row > img {
        height: 30px;
        margin-bottom: 10px;
    }

    .emotion {
        width: 265px;
        display: flex;
        flex-wrap: wrap;

    }

    .emotion .list {
        padding: 2px;
        cursor: pointer;
    }

    .emotion .list img {
        width: 24px;
    }
</style>
