<template>
    <div class="header ht-flex ht-row-between">
        <div class="left">
            <div class="item ht-flex ht-col-center" @click="handleMenu">
                <i class="iconfont icon-hanbaocaidanzhedie"></i>
            </div>
        </div>
        <div class="right ht-flex">
            <a
                title="主页"
                href="https://www.lpyhutu.cn"
                target="_bank"
                class="item ht-flex ht-col-center"
            >
                <div class=" ">
                    <i class="iconfont icon-home"></i>
                </div>
            </a>

            <div
                class="item ht-flex ht-col-center"
                title="退出登陆"
                @click="logout"
            >
                <i class="iconfont icon-poweroff"></i>
            </div>

            <div class="item ht-flex ht-col-center">
                <img src="../assets/img/WeChat.jpg" alt="" />
                <span>{{ username }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import { logout } from "@/assets/api/api";
export default {
    name: "Header",
    data() {
        return {
            username: "",
        };
    },
    methods: {
        handleMenu() {
            this.$store.commit("isMenu", !this.$store.state.isMenu);
        },
        logout() {
            this.$msgBox
                .confirm("退出当前用户, 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning",
                })
                .then(() => {
                    logout().then((res) => {
                        if (res) {
                            localStorage.removeItem("authExpiresTime");
                            localStorage.removeItem("authToken");
                            this.$router.push({
                                path: "/",
                            });
                        }
                    });
                })
                .catch(() => {});
        },
    },
    created() {
        this.username = localStorage.getItem("username");
    },
};
</script>

<style lang="scss" scoped>
.header {
    padding-right: 20px;
    height: 100%;
    .item {
        position: relative;
        height: 100%;
        padding: 0 15px;
        cursor: pointer;

        &:hover {
            background: $ht-basebg;
        }
        img {
            width: 25px;
            height: 25px;
            margin-right: 5px;
            border-radius: 100%;
        }
    }

    a {
        text-decoration: none;
    }
}
</style>