<template>
    <div class="login b-flex b-col-center b-row-center">
        <div class="content b-border-all">
            <div class="head b-head-bg b-font-size-16px b-text-center">
                糊涂个人博客后台管理系统
            </div>
            <div class="input">
                <div class="item">
                    <el-input
                        placeholder="Username"
                        v-model="username"
                    ></el-input>
                </div>
                <div class="item">
                    <el-input
                        placeholder="Password"
                        v-model="password"
                    ></el-input>
                </div>
                <div class="item b-flex b-col-center">
                    <el-input
                        placeholder="Captche"
                        v-model="captche"
                    ></el-input>
                    <div class="captche">111</div>
                </div>
            </div>
            <div class="btn b-flex b-row-center">
                <el-button @click="login">login</el-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            username: "admin",
            password: "123456",
            captche: "",
        };
    },
    methods: {
        login() {
            this.$router.push({
                path: "/home",
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.login {
    position: relative;
    height: 100%;
    width: 100%;
    .content {
        border-radius: 5px;
        width: 300px;
        .head {
            padding: 10px;
            color:$b-theme;
        }
        .input {
            padding: 10px;
            .item {
                padding: 10px;
                .captche {
                    min-width: 100px;
                }
            }
        }
        .btn {
            padding: 0 20px 10px 20px;
            button {
                width: 100%;
            }
        }
    }
}
</style>