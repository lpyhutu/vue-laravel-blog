<template>
    <div class="adminuser app-main">
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
        <AdminUserList class="app-content"></AdminUserList>
    </div>
</template>

<script>
import AdminUserList from "@/components/AdminUserList.vue";

export default {
    name: "AdminUser",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "全部" }],
        };
    },
    components: {
        AdminUserList,
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