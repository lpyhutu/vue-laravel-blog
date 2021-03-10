<template>
    <div class="statistics app-main">
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
        <TotalList class="app-content"></TotalList>
    </div>
</template>

<script>
import TotalList from "@/components/TotalList.vue";

export default {
    name: "statistics",
    components: {
        TotalList,
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
