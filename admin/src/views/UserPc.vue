<template>
    <div class="user-pc app-main">
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
        <UserPcList class="app-content"></UserPcList>
    </div>
</template>

<script>
import UserPcList from "@/components/UserPcList.vue";

export default {
    name: "UserPC",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "电脑端用户" }],
        };
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
        },
    },
    components: {
        UserPcList,
    },
};
</script>
