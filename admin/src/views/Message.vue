<template>
    <div class="message app-main">
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
        <MessageList class="app-content" ref="message"></MessageList>
    </div>
</template>

<script>
import MessageList from "@/components/MessageList.vue";

export default {
    name: "Message",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }, { title: "已发布" }, { title: "未发布" }],
        };
    },
    components: {
        MessageList,
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
            this.$refs.message.handleGetType(index);
        },
    },
    mounted() {
        this.$refs.message.handleGetType(0);
    },
};
</script>

<style>
</style>