<template>
    <div class="link app-main">
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
        <LinkList class="app-content" ref="link"></LinkList>
    </div>
</template>

<script>
import LinkList from "@/components/LinkList.vue";

export default {
    name: "Link",
    components: {
        LinkList,
    },
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }],
        };
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
        },
    },
};
</script>

<style>
</style>