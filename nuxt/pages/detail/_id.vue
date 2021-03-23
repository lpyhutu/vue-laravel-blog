<template>
    <div class="detail">
        <!-- <Loading v-show="isLoading" :tip="'loading'"></Loading> -->
        <div class="app-content">
            <div class="app-left">
                <div class="content" v-for="(item, key) in article" :key="key">
                    <div class="title">
                        <h1 class="ht-font-size-22px">
                            {{ item.title }}
                        </h1>
                    </div>
                    <div class="info ht-flex ht-row-center">
                        <div class="item ht-flex ht-font-size-12px">
                            <div>分类</div>
                            <div class="item-1">
                                {{ article[0].front_type.title }}
                            </div>
                        </div>
                        <div
                            class="item ht-flex ht-font-size-12px"
                            style="margin: 0 10px"
                        >
                            <div>时间</div>
                            <div class="item-2">
                                {{ article[0].created_at }}
                            </div>
                        </div>
                        <div class="item ht-flex ht-font-size-12px">
                            <div>访问</div>
                            <div class="item-3">{{ article[0].read_num }}</div>
                        </div>
                    </div>
                    <Content :text="article[0].content"></Content>
                    <div class="action ht-flex ht-row-center">
                        <a-button
                            type="primary"
                            icon="like"
                            @click="articleThumb(article[0].id)"
                            >{{ article[0].thumb_num }}</a-button
                        >
                    </div>
                    <div class="up-down">
                        <nuxt-link
                            class="item"
                            v-if="upArticle != null"
                            :to="{
                                name: 'detail-id',
                                params: { id: upArticle.id },
                            }"
                        >
                            上一篇：
                            {{ upArticle.title }}
                        </nuxt-link>
                        <nuxt-link
                            class="item"
                            v-if="downArticle != null"
                            :to="{
                                name: 'detail-id',
                                params: { id: downArticle.id },
                            }"
                        >
                            下一篇：{{ downArticle.title }}
                        </nuxt-link>
                    </div>
                    <div class="other ht-flex">
                        <div class="left">
                            <img src="@/assets/img/qqgroup.jpg" alt="" />
                        </div>
                        <div class="right">
                            <div class="">
                                <span>作者：</span>
                                <span>{{ article[0].author }}</span>
                            </div>
                            <div class="">
                                <span>邮箱：</span>
                                <span>{{ article[0].email }}</span>
                            </div>
                            <div class="">
                                <span>链接：</span>
                                <span>
                                    <a
                                        :href="`${$host}${$route.path}`"
                                        target="_blank"
                                        >{{ `${$host}${$route.path}` }}</a
                                    >
                                </span>
                            </div>
                            <div class="">
                                <span
                                    >原创文章，转载请标明出处，扫码加入学习交流群</span
                                >
                            </div>
                        </div>
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
                <Ranking
                    class="app-none"
                    style="margin: 15px 0"
                    @handleArticleDetail="articleDetail"
                ></Ranking>
                <HTLink class="app-none" style="margin: 15px 0"></HTLink>
            </div>
        </div>
    </div>
</template>

<script>
import User from "@/components/User";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import Comment from "@/components/Comment";
import CommentList from "@/components/CommentList";
import Loading from "@/components/Loading";
import Content from "@/components/Content";
import { Message } from "@/assets/js/message";
import {
    articleDetail,
    commentGet,
    articleThumb,
    commentAdd,
    commentThumb,
    commentSubComment,
    commentSubCommentSub,
} from "@/assets/api/api";

export default {
    name: "Detail",
    head() {
        return {
            title: this.title,
            meta: this.meta,
        };
    },
    components: {
        User,
        Ranking,
        HTLink,
        Comment,
        CommentList,
        Loading,
        Content,
    },
    data() {
        return {
            isLoading: true,
            isLoadingFlag: true,
            detail: "",
            list: [],
            start: 1,
            pageSize: 15,
            total: 0,
            downArticle: [],
            upArticle: [],
            article: [],
            title: "",
            meta: [],
        };
    },

    asyncData({ app, params }, callback) {
        return articleDetail(params.id, app.store.state.uid).then((res) => {
            const { code, data, upArticle, downArticle } = res;
            if (code === 1 && data.length !== 0) {
                app.head.title = data[0].title + " - 糊涂博客";
                const meta = [
                    {
                        charset: "utf-8",
                    },
                    {
                        name: "viewport",
                        content: "width=device-width, initial-scale=1",
                    },
                    {
                        hid: "keywords",
                        name: "keywords",
                        content: data[0].keywords,
                    },
                    {
                        hid: "description",
                        name: "description",
                        content: data[0].content
                            .replace(/\s+/g, "")
                            .slice(0, 200)
                            .replace(/#|`/g, ""),
                    },
                ];
                app.head.meta = meta;
                callback(null, {
                    article: data,
                    upArticle: upArticle,
                    downArticle: downArticle,
                });
            } else {
                app.router.push({ path: "/" });
            }
        });
    },
    methods: {
        jump(id) {
            this.$router.push(`/detail/${id}`);
        },
        /**
         * 文章详情
         */
        articleDetail(id) {
            this.isLoading = this.isLoadingFlag ? true : false;
            if (this.isLoadingFlag) {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
            this.isLoadingFlag = true;
            articleDetail(id, this.$cookies.get("userInfo")).then((res) => {
                if (!res) {
                    return false;
                }
                if (res.data.length === 0) {
                    this.$router.push({
                        path: "/",
                    });
                    return;
                }
                document.title = res.data[0].title + " - 糊涂博客";

                this.article = res.data;
                this.upArticle = res.upArticle;
                this.downArticle = res.downArticle;
                this.isLoading = false;
            });
        },
        /**
         * 文章点赞
         */
        articleThumb(id) {
            articleThumb(id, this.$cookies.get("userInfo")).then((res) => {
                if (res) {
                    Message(1000, "感谢您的支持.");
                    this.isLoadingFlag = false;
                    this.articleDetail(id);
                }
            });
        },

        /**
         * 留言列表
         */
        commentGet() {
            commentGet(
                0,
                this.pageSize * this.start,
                this.$route.params.id
            ).then((res) => {
                if (res) {
                    this.list = res.data;
                    this.total = res.total;
                }
            });
        },
        /**
         * 留言
         */
        handleComment(text) {
            const { qq, name, email, avatar } = this.$store.state;
            commentAdd(
                this.$route.params.id,
                qq,
                name,
                email,
                encodeURIComponent(avatar),
                text
            ).then((res) => {
                if (res) {
                    Message(1000, "评论成功.");
                    this.commentGet();
                }
            });
        },
        /**
         * 留言评论
         */
        handleSubComment(msg_id, text) {
            const { qq, name, email, avatar } = this.$store.state;
            commentSubComment(
                msg_id,
                qq,
                name,
                email,
                encodeURIComponent(avatar),
                text
            ).then((res) => {
                if (res) {
                    Message(1000, "评论成功.");
                    this.commentGet();
                }
            });
        },
        /**
         * 子留言评论
         */
        handleSubCommentSub(sub_id, text) {
            const { qq, name, email, avatar } = this.$store.state;
            commentSubCommentSub(
                sub_id,
                qq,
                name,
                email,
                encodeURIComponent(avatar),
                text
            ).then((res) => {
                if (res) {
                    Message(1000, "评论成功.");
                    this.commentGet();
                }
            });
        },
        /**
         * 点赞
         */
        handleThumb(id, sub_id, uid) {
            commentThumb(id, sub_id, uid).then((res) => {
                if (res) {
                    Message(1000, "感谢您的支持,", false);
                    this.commentGet();
                }
            });
        },
        handleMeta() {
            if (this.article.length !== 0) {
                this.title = this.article[0].title;
                this.meta = [
                    {
                        hid: "keywords",
                        name: "keywords",
                        content: this.article[0].keywords,
                    },
                    {
                        hid: "description",
                        name: "description",
                        content: this.article[0].content
                            .replace(/\s+/g, "")
                            .slice(0, 500)
                            .replace(/#|`/g, ""),
                    },
                ];
            }
        },
    },
    created() {
        this.handleMeta();
        this.commentGet();
        this.$bus.$on("handleScroll", () => {
            if (this.list.length < this.total) {
                this.start = this.start + 1;
                this.commentGet();
            }
        });
    },
};
</script>

<style lang="scss" scoped>
.detail {
    .content {
        padding: 20px;
        background: $bg-white;
        .title {
            text-align: center;
            padding-top: 10px;
        }
        .info {
            margin: 20px 0;
            .item {
                div {
                    padding: 2px 3px;
                    color: $bg-white;
                }
                div:first-child {
                    background: $bg-black;
                }
                .item-1 {
                    background: rgb(1, 150, 155);
                }
                .item-2 {
                    background: $bg-theme;
                }
                .item-3 {
                    background: rgb(207, 187, 5);
                }
            }
        }
        .action {
            padding: 20px 0;
        }
        .up-down {
            padding: 10px 0;
            width: 100%;
            display: flex;
            flex-flow: column;
            .item {
                display: inline-block;
                padding: 5px 0;
                color: #000000a6;
                cursor: pointer;
                &:hover {
                    color: $bg-theme;
                }
            }
        }
        .other {
            margin: 10px 0 30px;
            padding: 10px;
            border-left: 3px solid $bg-theme;
            background: $bg-default;
            .left {
                margin-right: 10px;
                img {
                    background: $bg-white;
                    padding: 5px;
                    height: 80px;
                    width: 80px;
                }
                @media (max-width: 400px) {
                    img {
                        display: none;
                    }
                }
            }
            .right {
                line-height: 160%;
                a {
                    text-decoration: none;
                }
            }
        }
    }
}
</style>

