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
        <TypeList class="app-content"></TypeList>
    </div>
</template>

<script>
import TypeList from "@/components/TypeList.vue";

export default {
    name: "Type",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }],
        };
    },
    components: {
        TypeList,
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