<template>
    <div class="comment">
        <div class="user ht-flex">
            <div class="item">
                <img src="../assets/img/avatar.png" alt="" />
            </div>
            <div class="item">
                <a-input placeholder="请输入QQ号"></a-input>
            </div>
            <div class="item">
                <a-input placeholder="昵称（自动获取）" disabled></a-input>
            </div>
            <div class="item">
                <a-input placeholder="邮箱（自动获取）" disabled></a-input>
            </div>
        </div>
        <div class="text">
            <a-textarea
                placeholder="说点什么好呢？"
                :auto-size="{ minRows: 5, maxRows: 7 }"
            />
        </div>
        <div class="action ht-flex ht-row-between">
            <div class="item">
                <a-popover v-model="visible" title="表情包" trigger="click">
                    <div slot="content">
                        <div class="emotion ht-flex ht-wrap">
                            <div
                                class="list"
                                v-for="(item, key) in emotionArr"
                                :key="key"
                            >
                                <img
                                    :src="item.url"
                                    :title="item.title"
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                    <a-button icon="smile" @click="hide"></a-button>
                </a-popover>
            </div>
            <div class="item">
                <a-button type="primary" icon="form">评论</a-button>
            </div>
        </div>
    </div>
</template>

<script>
import { emotion } from "@/assets/js/emotion";
import { changeEmotion } from "@/assets/js/changeEmotion";

export default {
    name: "Comment",
    data() {
        return {
            visible: false,
            emotionArr: [],
            emotionLoadingFlag: false,
        };
    },
    methods: {
        loadEmotion() {
            this.emotionArr = [];
            emotion.map((item, index) => {
                this.emotionArr.push({
                    title: item,
                    name: `[${item}]`,
                    // url: `https://api.lpyhutu.cn/HtBlog/public/upload/img/emotion/${index}.gif`,
                    url: `http://blog.com/upload/img/emotion/${index}.png`,
                });
            });
        },
        handlechangeEmotion() {
            console.log(changeEmotion("[哭笑不得]333"));
        },
        hide() {
            this.visible = false;
        },
    },
    created() {
        this.loadEmotion();
        this.handlechangeEmotion();
    },
};
</script>

<style lang="scss" scoped>
.comment {
    .user {
        margin: 10px 0 15px;
        .item {
            margin-right: 10px;
            img {
                height: 30px;
            }
        }
    }
    .action {
        padding: 15px 0 10px;
    }
}
.emotion {
    max-width: 290px;
    .list {
        padding: 2px;
        cursor: pointer;
        img {
            width: 25px;
        }
    }
}
@media (max-width: 767px) {
    .comment {
        .user {
            flex-flow: column;

            .item {
                margin-bottom: 15px;
            }
        }
    }
}
</style>