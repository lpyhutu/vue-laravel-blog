<template>
    <div class="type app-main">
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
        <LogList class="app-content" ref="log"></LogList>
    </div>
</template>

<script>
import LogList from "@/components/LogList.vue";
export default {
    name: "TypeLog",
    components: {
        LogList,
    },
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }, { title: "WeChat" }, { title: "PC" }],
        };
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
            this.$refs.log.handleGetType(index);
        },
    },
    mounted() {
        this.$refs.log.handleGetType(0);
    },
};
</script>

<style>
</style>