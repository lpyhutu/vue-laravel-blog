<template>
    <div class="usernew app-card">
        <div class="title">最新用户</div>
        <div class="content">
            <div class="item" v-for="(item, key) in userList" :key="key">
                {{
                    `${formatTime(item.created_at)} IP:${
                        item.ip
                    }的${checkAddress(item.province, item.city)}用户首次访问`
                }}
            </div>
        </div>
    </div>
</template>

<script>
import { SwitchDate } from "@/assets/js/formatTime";

export default {
    name: "UserNew",
    props: {
        userList: Array,
    },
    methods: {
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
        },
        /**
         * 检查地址
         */
        checkAddress(province, city) {
            if (province == "0") {
                return "未知";
            }
            return province + city;
        },
    },
};
</script>

<style lang="scss" scoped>
.usernew {
    .content {
        height: 350px;
        overflow: auto;
        .item {
            padding: 10px 0;
            line-height: 150%;
            border-bottom: 1px solid #eee;
        }
    }
}
</style>