<template>
    <div class="discoloration app-main">
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
        <DiscolorationList class="app-content"></DiscolorationList>
    </div>
</template>

<script>
import DiscolorationList from "@/components/DiscolorationList.vue";

export default {
    name: "Discoloration",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }],
        };
    },
    components: {
        DiscolorationList,
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