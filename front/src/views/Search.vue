<template>
    <div class="search">
        <Loading v-show="isLoading" :tip="'loading'"></Loading>
        <div class="app-content">
            <div class="app-left">
                <Article :list="articleList"></Article>
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
import Article from "@/components/Article";
import User from "@/components/User";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import { articleSearch } from "@/assets/api/api";
import Loading from "@/components/Loading";

export default {
    name: "Search",
    metaInfo: {
        title: "搜索结果 - 网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "vue,laravel,redis,nginx,JavaScript",
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
            start: 1,
            pageSize: 10,
            total: 0,
            isLoading: true,
            title: "",
        };
    },
    components: { Article, User, Ranking, HTLink, Loading },
    methods: {
        /**
         * 文章列表
         */
        articleSearch() {
            this.isLoading = true;
            articleSearch(
                this.$route.params.title,
                0,
                this.pageSize * this.start
            ).then((res) => {
                if (res) {
                    this.articleList = res.data;
                    this.total = res.total;
                }
                this.isLoading = false;
            });
        },
    },
    created() {
        this.articleSearch();
        this.$bus.$on("handleScroll", () => {
            if (this.articleList.length < this.total) {
                this.start = this.start + 1;
                this.articleSearch();
            }
        });

        this.$bus.$on("search", () => {
            this.articleSearch();
        });
    },
    beforeDestroy() {
        this.$bus.$off("search");
    },
};
</script>
<style scoped>
</style>
