<template>
    <div class="comment">
        <div class="user ht-flex">
            <div class="item">
                <img
                    :src="
                        $store.state.avatar == ''
                            ? require('../assets/img/avatar.png')
                            : $store.state.avatar
                    "
                    alt=""
                />
            </div>
            <div class="item">
                <a-input
                    placeholder="请输入QQ号"
                    v-model="qq"
                    @change="qqInfo"
                ></a-input>
            </div>
            <div class="item">
                <a-input
                    placeholder="昵称（自动获取）"
                    v-model="$store.state.name"
                    disabled
                ></a-input>
            </div>
            <div class="item">
                <a-input
                    placeholder="邮箱（自动获取）"
                    v-model="$store.state.email"
                    disabled
                ></a-input>
            </div>
        </div>
        <div class="text">
            <a-textarea
                placeholder="说点什么好呢？"
                v-model="content"
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
                                @click="addEmotion(item.name)"
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
                <a-button type="primary" icon="form" @click="confirm"
                    >评论</a-button
                >
            </div>
        </div>
    </div>
</template>

<script>
import { emotion } from "@/assets/js/emotion";
import { changeEmotion } from "@/assets/js/changeEmotion";
import { qqInfo } from "@/assets/api/api";
import { checkQQ } from "@/assets/js/reg";
import { Message } from "@/assets/js/message";

export default {
    name: "Comment",
    data() {
        return {
            visible: false,
            emotionArr: [],
            emotionLoadingFlag: false,
            content: "",
            qq: "",
        };
    },
    props: {
        id: Number,
    },
    methods: {
        confirm() {
            if (!checkQQ(this.$store.state.qq)) {
                Message(1003, "QQ参数格式错误.");
                return false;
            }
            if (this.content === "") {
                Message(1003, "说点什么好呢.");
                return false;
            }
            this.$emit("handleComment", this.content, this.id);
            this.content = "";
        },
        /**
         * qq信息
         */
        qqInfo() {
            this.$store.commit("setQQ", this.qq);
            if (isNaN(this.$store.state.qq)) {
                this.qq = "";
                this.$store.commit("setQQ", "");
                return false;
            }
            const length = this.$store.state.qq.length;
            if (length < 5 || length > 12) {
                return false;
            }
            if (!checkQQ(this.$store.state.qq)) {
                Message(1003, "QQ参数格式错误.");
                return false;
            }
            qqInfo(this.$store.state.qq).then((res) => {
                if (res) {
                    const { email, nickName, avatar } = res.data;
                    this.$store.commit("setEmail", email);
                    this.$store.commit(
                        "setName",
                        nickName == "" ? this.$store.state.qq : nickName
                    );
                    this.$store.commit("setAvatar", avatar);
                }
            });
        },
        /**
         * 添加表情
         */
        addEmotion(name) {
            this.content = this.content + name;
            this.hide();
        },
        /**
         * 表情加载
         */
        loadEmotion() {
            this.emotionArr = [];
            emotion.map((item, index) => {
                this.emotionArr.push({
                    title: item,
                    name: `[${item}]`,
                    url: `${this.$assets}/upload/img/emotion/${index}.png`,
                    // url: `http://blog.com/upload/img/emotion/${index}.png`,
                });
            });
        },

        handlechangeEmotion() {
            changeEmotion("[哭笑不得]333");
        },
        hide() {
            this.visible = false;
        },
    },
    created() {
        this.qq = this.$store.state.qq;
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