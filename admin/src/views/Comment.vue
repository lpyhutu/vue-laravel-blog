<template>
    <div class="comment app-main">
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
        <CommentList class="app-content" ref="comment"></CommentList>
    </div>
</template>

<script>
import CommentList from "@/components/CommentList.vue";

export default {
    name: "comment",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }, { title: "已发布" }, { title: "未发布" }],
        };
    },
    components: {
        CommentList,
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
            this.$refs.comment.handleGetType(index);
        },
    },
    mounted() {
        this.$refs.comment.handleGetType(0);
    },
};
</script>

<style>
</style>