<template>
    <div class="article">
        <div
            class="item ht-flex ht-flow-column"
            v-for="(item, key) in 10"
            :key="key"
        >
            <div
                class="top ht-font-size-18px ht-font-weight"
                @click="articleDetail()"
            >
                序webview内嵌H5功能微信小程序web-view内嵌H5使用PHP完成支付功能view内嵌H5使
            </div>
            <div class="center ht-flex">
                <img src="../assets/img/1.png" class="article-img" alt="" />
                <div class="text">
                    摘要：每天进步一点点...
                    新建的博客,我们如何限制别人恶意攻击、频繁请求接口,导致数据库崩溃？我们可以使用Redis对请求的IP做一个简单的限制。
                    #### 一、设计思路
                </div>
            </div>
            <div class="bottom">
                posted @2021-1-5 15:33:36 asdf 阅读（5）评论（0）点赞（2）
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Article",
    methods: {
        articleDetail(id) {
            this.$router.push({
                path: "/detail",
                query: {
                    id: id,
                },
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.article {
    .item {
        padding: 20px;
        background: $bg-white;
        margin-bottom: 15px;
        @include ht-transition(0.3s);

        &:hover {
            transform: scale(1.02);
        }
        .top {
            @include line-clamp(2);
            cursor: pointer;
            &:hover {
                color: $bg-theme;
            }
        }
        .center {
            padding: 15px 0;
            img {
                min-width: 160px;
                height: 100px;
            }
            .text {
                padding-left: 10px;
                line-height: 180%;
                overflow: hidden;
                white-space: normal;
                word-wrap: break-word;
                word-break: break-all;
                text-overflow: ellipsis;
                @include line-clamp(4);
            }
        }
        .bottom {
        }
    }
}

@media (max-width: 767px) {
    .article {
        .item {
            .center {
                img {
                    min-width: 130px;
                }
            }
        }
    }
}
</style>