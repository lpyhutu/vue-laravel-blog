<div class="comment-list">
    @foreach($comment as $item)
        <div class="media">
            <img src="{{$item->avatar}}"
                 class="mr-3" alt="...">
            <div class="media-body">
                <div class="title"><span style="color: rgb(238, 78, 3)">{{$item->master===1?'站长':""}}</span><span>{{$item->name}}</span> <span>{{$item->created_at}}</span></div>
                <p class="ht-content">{{$item->content}}</p>
                <div class="footer">
                <span class="ht-like">
                    <icon class="iconfont icon-like"></icon>
                    <span>{{$item->thumb_num}}</span>
                    <input class="currentId" value="{{$item->id}}" name="0" style="display: none">
                </span>
                    <span class="add-comment">
                    <icon class="iconfont icon-comment"></icon>
                </span>
                </div>

                <div class="comment-flag">
                    <x-comment url="{{session('urlOne')}}" commentId="{{$item->id}}" emotionDom="emotion{{$item->id}}"
                               currentEmotionDom="currentEmotionDom{{$item->id}}"></x-comment>
                </div>

                @foreach($item->msgSub as $itemTwo)
                    <div class="media mt-3">
                        <div class="media-body">
                            <div class="title">
                                <span><span style="color: rgb(238, 78, 3)">{{$itemTwo->master===1?'站长':""}}</span>{{$itemTwo->name}}@<span
                                        style="color: rgb(238, 78, 3)">{{$itemTwo->be_master===1?'站长':""}}</span> {{$itemTwo->be_name}}</span>
                                <span>{{$itemTwo->created_at}}</span>
                            </div>
                            <p>{{$itemTwo->content}}</p>
                            <div class="footer">
                        <span class="ht-like">
                            <icon class="iconfont icon-like"></icon>
                            <span>{{$itemTwo->thumb_num}}</span>
                             <input class="subId" value="{{$itemTwo->id}}" name="{{$itemTwo->id}}"
                                    style="display: none">
                        </span>
                                <span class="add-comment">
                            <icon class="iconfont icon-comment"></icon>
                        </span>
                            </div>
                            <div class="comment-flag">
                                <x-comment url="{{session('urlTwo')}}" commentId="{{$itemTwo->id}}"
                                           emotionDom="emotion{{$item->id}}B{{$itemTwo->id}}"
                                           currentEmotionDom="currentEmotionDom{{$item->id}}B{{$itemTwo->id}}"></x-comment>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
    $(function () {
        function handleContent() {
            const contentArr = $(".ht-content");
            for (let i = 0; i < contentArr.length; i++) {
                const {innerText} = $(".ht-content")[i];
                const content=changeEmotion(innerText);
                $(".ht-content")[i].outerHTML = `<p class="ht-content">${content}</p>`
            }
        }

        function changeEmotion(str) {
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
            return str.replace(/\[[\u4E00-\u9FA5]{1,4}\]/gi, (words) => {
                let word = words.replace(/\[|\]/gi, '')
                let index = emotion.indexOf(word)
                if (index !== -1) {
                    return `<img style="width:25px;height:25px" src="{{asset('upload/img/emotion/${index}.png')}}" alt="${word}" align="middle">`
                } else {
                    return words
                }
            })
        }

        handleContent()
        $('.add-comment').click(function () {
            let current = $(this)
            if ($(this).parent().next()[0].style.display === "" || $(this).parent().next()[0].style.display === "none") {
                $(this).parent().next().css("display", "block")
                $('.add-comment').not(current).parent().next().css("display", "none")
            } else {
                $(this).parent().next().css("display", "none")
            }
        })
        $(".ht-like").click(function () {
            const _this = this;
            const id = $(this).find("input").val();
            const sub_id = $(this).children("input").attr("name")
            $.post("/{{session('urlThumb')}}",
                {
                    '_token': '{{csrf_token()}}',
                    id: id,
                    sub_id: sub_id
                },
                function (res) {
                    const {code, data} = res
                    if (code === 1) {
                        $(_this).children("span").text(data.thumb_num)
                        $(".t-thumb-suc").toast('show')
                    } else {
                        $(".t-thumb-too").toast('show')
                    }
                });
        })
    })
</script>
<style>
    .comment-list {
        padding: 20px 0;
    }

    .comment-flag {
        display: none;
    }

    .comment-list > .media {
        padding: 5px 0;
    }

    .comment-list > .media img {
        width: 35px;
        height: 35px;
    }

    .comment-list .media-body .title {
        padding-bottom: 5px;
        color: rgba(0, 0, 0, .45);
    }

    .comment-list .footer span {
        margin-right: 5px;
        font-size: 12px;
        cursor: pointer;
    }
</style>
