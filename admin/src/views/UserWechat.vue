<template>
    <div class="user-wechat app-main">
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
        <UserWechatList class="app-content"></UserWechatList>
    </div>
</template>

<script>
import UserWechatList from "@/components/UserWechatList.vue";

export default {
    name: "UserWechat",
    data() {
        return {
            navIndex: 0,
            nav: [{ title: "小程序用户" }],
        };
    },
    methods: {
        handleCurrentNav(index) {
            this.navIndex = index;
        },
    },
    components: {
        UserWechatList,
    },
};
</script>
