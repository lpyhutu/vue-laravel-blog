<template>
    <div class="info app-main">
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
        <InfoList class="app-content"></InfoList>
    </div>
</template>

<script>
import InfoList from "@/components/InfoList.vue";

export default {
    name: "Info",
    components: {
        InfoList,
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