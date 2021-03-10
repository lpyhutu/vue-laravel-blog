<template>
    <div class="home">
        <Loading v-show="isLoading" :tip="'loading'"></Loading>
        <div class="app-content">
            <div class="app-left"><Article :list="articleList"></Article></div>
            <div class="app-right">
                <User></User>
                <Type
                    style="margin: 15px 0"
                    :list="typeList"
                    @handleCurrentType="handleCurrentType"
                ></Type>
                <Ranking class="app-none"></Ranking>
                <HTLink class="app-none" style="margin: 15px 0"></HTLink>
            </div>
        </div>
        <!-- <a-button @click="aa">1111</a-button> -->
    </div>
</template>

<script>
import Article from "@/components/Article";
import User from "@/components/User";
import Type from "@/components/Type";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import { articleGet, typeGet, articleType } from "@/assets/api/api";
import Loading from "@/components/Loading";

export default {
    name: "Home",
    metaInfo: {
        title: "网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "vue,redis,php,小程序,博客",
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
            articleList: [],
            typeList: [],
            type: 0,
            start: 1,
            pageSize: 10,
            total: 0,
            isLoading: true,
        };
    },
    components: { Article, User, Type, Ranking, HTLink, Loading },
    methods: {
        // aa() {
        //     window.scrollTo({ top: 0, behavior: "smooth" });
        // },
        handleGet() {
            if (this.type === 0) {
                this.articleGet();
            } else {
                this.articleType();
            }
        },
        /**
         * 文章列表
         */
        articleGet() {
            this.isLoading = true;
            articleGet(0, this.pageSize * this.start).then((res) => {
                if (res) {
                    this.articleList = res.data;
                    this.total = res.total;
                }
                this.isLoading = false;
            });
        },
        /**
         * 类别文章
         */
        typeGet() {
            typeGet().then((res) => {
                if (res) {
                    this.typeList = res.data;
                }
            });
        },
        /**
         * 当前类别文章
         */
        handleCurrentType(type) {
            this.type = type;
            this.handleGet();
        },
        articleType() {
            this.isLoading = true;
            articleType(this.type, 0, this.pageSize * this.start).then(
                (res) => {
                    if (res) {
                        this.articleList = res.data;
                        this.total = res.total;
                    }
                    this.isLoading = false;
                }
            );
        },
    },
    created() {
        this.articleGet();
        this.typeGet();
        this.$bus.$on("handleScroll", () => {
            if (this.articleList.length < this.total) {
                this.start = this.start + 1;
                this.handleGet();
            }
        });
    },
};
</script>
<style scoped>
</style>
