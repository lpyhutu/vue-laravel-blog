<template>
    <div class="gallery app-main">
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
        <RouterList class="app-content"></RouterList>
    </div>
</template>

<script>
import RouterList from "@/components/RouterList.vue";

export default {
    name: "Gallery",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }],
        };
    },
    components: {
        RouterList,
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