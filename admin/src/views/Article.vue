<template>
    <div class="article app-main">
        <div class="app-nav">
            <div
                class="item"
                :class="key === navIndex ? 'item-active' : ''"
                v-for="(item, key) in nav"
                :key="key"
                @click="handleCurrentNav(key)"
            >
                {{ item.title }}
            </div>
        </div>
        <ArticleList class="app-content" ref="article"></ArticleList>
    </div>
</template>

<script>
import ArticleList from "@/components/ArticleList.vue";
export default {
    name: "Article",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }, { title: "已发布" }, { title: "未发布" }],
        };
    },
    components: {
        ArticleList,
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
            this.$refs.article.handleGetType(index);
        },
    },
    mounted() {
        this.$refs.article.handleGetType(0);
    },
};
</script>
