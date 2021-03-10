<template>
    <div class="article">
        <div
            class="item ht-flex ht-flow-column"
            v-for="(item, key) in list"
            :key="key"
        >
            <div
                class="top ht-font-size-18px ht-font-weight"
                @click="articleDetail(item.id)"
            >
                {{ item.title }}
            </div>
            <div class="center ht-flex">
                <img :src="$assets + item.cover_url" class="article-img" alt="" />
                <div class="text">
                    摘要：{{ item.content.replace(/#|`/g, "") }}
                </div>
            </div>
            <div class="bottom">
                <span>posted @</span>
                <span>{{ formatTime(item.created_at) }}</span>
                <span>{{ item.author }}</span>
                <span>阅读({{ item.read_num }})</span>
                <span
                    >评论({{
                        item.front_comment.length +
                        item.front_comment_sub.length
                    }})</span
                >
                <span>点赞({{ item.thumb_num }})</span>
            </div>
        </div>
    </div>
</template>

<script>
import { SwitchDate } from "@/assets/js/time";

export default {
    name: "Article",
    props: {
        list: Array,
    },
    methods: {
        articleDetail(id) {
            this.$router.push(`/detail/${id}`);
        },
        handleImg(url) {
            if (url === "0") {
                return require("../assets/img/null.png");
            } else {
                return JSON.parse(url)[0];
            }
        },
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
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
            color: $bg-tip;
            span {
                padding-right: 5px;
            }
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