<template>
    <div class="home">
        <Loading v-show="$store.state.isLoading" :tip="'loading'"></Loading>
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
                <Link class="app-none" style="margin: 15px 0"></Link>
            </div>
        </div>
    </div>
</template>

<script>
import { articleGet, typeGet, articleType } from "@/assets/api/api";

export default {
    name: "Home",
    head() {
        return {
            title: "网页设计，模板分享，源码下载 - 糊涂博客",
            meta: [
                {
                    hid: "keywords",
                    name: "keywords",
                    content: "个人博客,网页,源码,模板分享",
                },
                {
                    hid: "description",
                    name: "description",
                    content:
                        "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
                },
            ],
        };
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
    asyncData({ app, params }, callback) {
        app.store.commit("isLoading", true);
        return articleGet(0, 10).then((res) => {
            const { code, data, total } = res;
            if (code === 1 && data.length !== 0) {
                callback(null, { articleList: data, total: total });
            } else {
                callback(null, { articleList: [], total: 0 });
            }
            app.store.commit("isLoading", false);
        });
    },
    methods: {
        handleGet() {
            if (this.type === 0) {
                this.articleGet();
            } else {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
                this.articleType();
            }
        },
        /**
         * 文章列表
         */
        articleGet() {
            this.$store.commit("isLoading", true);
            articleGet(0, this.pageSize * this.start).then((res) => {
                if (res) {
                    this.articleList = res.data;
                    this.total = res.total;
                }
                this.$store.commit("isLoading", false);
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
        // this.articleGet();
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
