<template>
    <div class="message">
        <Loading v-show="isLoading" :tip="'loading'"></Loading>

        <div class="app-content">
            <div class="app-left">
                <div class="content">
                    <Title :title="'温馨提示'"></Title>
                    <div class="tip">
                        <p>1、欢迎大家在这留言或提意见建议；</p>
                        <p>
                            2、留言内容要健康积极向上，不得刷评论、发表不良信息；
                        </p>
                        <p>3、回复均以邮件形式通知，请输入常用有效邮箱；</p>
                        <p>
                            4、如果发现某些功能不能使用，请联系邮箱
                            1048672466@qq.com。
                        </p>
                    </div>
                    <Comment @handleComment="handleComment"></Comment>
                    <Title :title="'留言列表'" style="margin-top: 20px"></Title>
                    <CommentList
                        :list="list"
                        @handleThumb="handleThumb"
                        @handleSubComment="handleSubComment"
                        @handleSubCommentSub="handleSubCommentSub"
                    ></CommentList>
                </div>
            </div>
            <div class="app-right">
                <User style="margin: 0px 0px 15px"></User>
                <Ranking class="app-none" style="margin: 15px 0"></Ranking>
                <HTLink class="app-none"></HTLink>
            </div>
        </div>
    </div>
</template>

<script>
import User from "@/components/User";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import Title from "@/components/Title";
import Comment from "@/components/Comment";
import CommentList from "@/components/CommentList";
import Loading from "@/components/Loading";

import {
    msgGet,
    msgThumb,
    msgSubComment,
    msgSubCommentSub,
} from "@/assets/api/api";
import { Message } from "@/assets/js/message";

export default {
    name: "Message",
    metaInfo: {
        title: "留言板 - 网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "留言,前端,后端,小程序,博客",
            },
            {
                name: "description",
                content:
                    "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
            },
        ],
    },
    data() {
        return {
            isLoading: true,
            isLoadingFlag: true,
            list: [],
            start: 1,
            pageSize: 15,
            total: 0,
        };
    },
    components: {
        User,
        Ranking,
        HTLink,
        Title,
        Comment,
        CommentList,
        Loading,
    },
    methods: {
        /**
         * 留言列表
         */
        msgGet() {
            this.isLoading = this.isLoadingFlag ? true : false;
            this.isLoadingFlag = true;
            msgGet(0, this.pageSize * this.start).then((res) => {
                if (res) {
                    this.list = res.data;
                    this.total = res.total;
                }
                this.isLoading = false;
            });
        },
        /**
         * 留言点赞
         */
        handleThumb(id, sub_id, uid) {
            msgThumb(id, sub_id, uid).then((res) => {
                if (res) {
                    Message(1000, "感谢您的支持.", false);
                    this.isLoadingFlag = false;
                    this.msgGet();
                }
            });
        },
        /**
         * 留言
         */
        handleComment(text) {
            const { qq, name, email, avatar } = this.$store.state;
            msgGet(qq, name, email, encodeURIComponent(avatar), text).then(
                (res) => {
                    if (res) {
                        Message(1000, "评论成功.");
                        this.isLoadingFlag = false;
                        this.msgGet();
                    }
                }
            );
        },
        /**
         * 留言评论
         */
        handleSubComment(msg_id, text) {
            const { qq, name, email, avatar } = this.$store.state;
            msgSubComment(
                msg_id,
                qq,
                name,
                email,
                encodeURIComponent(avatar),
                text
            ).then((res) => {
                if (res) {
                    Message(1000, "评论成功.");
                    this.isLoadingFlag = false;

                    this.msgGet();
                }
            });
        },
        /**
         * 子留言评论
         */
        handleSubCommentSub(sub_id, text) {
            const { qq, name, email, avatar } = this.$store.state;
            msgSubCommentSub(
                sub_id,
                qq,
                name,
                email,
                encodeURIComponent(avatar),
                text
            ).then((res) => {
                if (res) {
                    Message(1000, "评论成功.");
                    this.isLoadingFlag = false;
                    this.msgGet();
                }
            });
        },
    },
    created() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        this.msgGet();
        this.$bus.$on("handleScroll", () => {
            if (this.list.length < this.total) {
                this.start = this.start + 1;
                this.isLoadingFlag = false;
                this.msgGet();
            }
        });
    },
};
</script>


<style lang="scss" scoped>
.message {
    .content {
        padding: 20px;
        background: $bg-white;
        .tip {
            padding: 10px 0;
        }
    }
}
</style>
