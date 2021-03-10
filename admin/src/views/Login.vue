<template>
    <div class="login ht-flex ht-col-center ht-row-center">
        <div class="main ht-white">
            <div
                class="title ht-flex ht-col-center ht-row-center ht-flow-column"
            >
                <div class="site ht-font-size-20px ht-weight">
                    糊涂个人博客后台管理系统
                </div>
                <div class="text">HUTU MANAGEMENT STSTEM</div>
            </div>
            <div
                class="content ht-flex ht-col-center ht-row-center ht-flow-column"
            >
                <div class="item">
                    <div class="left">用户名：</div>
                    <div class="right">
                        <el-input
                            placeholder="username"
                            v-model="username"
                            @keyup.enter.native="login"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">密&nbsp;&nbsp;码：</div>
                    <div class="right">
                        <el-input
                            placeholder="password"
                            v-model="password"
                            show-password
                            type="password"
                            @keyup.enter.native="login"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">验证码：</div>
                    <div class="right ht-flex">
                        <el-input
                            v-model="captchaCode"
                            placeholder="captcha"
                            @keyup.enter.native="login"
                        ></el-input>
                        <img :src="captchaImg" alt="验证码" @click="captcha" />
                    </div>
                </div>
                <div class="item">
                    <el-button @click="login" type="primary">登陆</el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { captcha, login } from "@/assets/api/api";
import { message } from "@/assets/js/message";
export default {
    name: "Login",
    data() {
        return {
            captchaImg: "",
            captchaKey: "",
            captchaCode: "",
            username: "admin",
            password: "123456",
        };
    },
    methods: {
        login() {
            if (this.username.trim() === "") {
                message(1003, "请输入用户名！");
                return;
            }
            if (this.password.trim() === "") {
                message(1003, "请输入密码！");
                return;
            }
            if (this.captchaCode.trim() === "") {
                message(1003, "请输入验证码！");
                return;
            }
            login({
                captchaCode: this.captchaCode.trim(),
                captchaKey: this.captchaKey,
                username: this.username.trim(),
                password: this.password.trim(),
            }).then((res) => {
                if (res) {
                    let { token } = res.data;
                    localStorage.setItem("authToken", token);
                    localStorage.setItem("username", this.username.trim());

                    localStorage.setItem("authExpiresTime", Date.now());
                    this.$router.push({
                        path: "/panel",
                    });
                    return;
                }
                this.captcha();
            });
        },
        /**
         * 验证码
         */
        captcha() {
            captcha().then((res) => {
                const { key, img } = res.data;
                this.captchaImg = img;
                this.captchaKey = key;
            });
        },
    },
    created() {
        this.captcha();
    },
};
</script>
<style lang="scss" scoped>
.login {
    background: #edf2f6;
    flex: 1;
    > .main {
        width: 500px;
        border-radius: 5px;
        // padding: 10px;
        > .title {
            height: 120px;
            background-image: url("../assets/img/login.jpg");
            border-radius: 5px 5px 0 0;
            color: rgb(216, 216, 216);
        }
        > .content {
            padding: 10px 0;
            > .item {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 400px;
                padding: 15px 0;
                .left {
                    width: 60px;
                    text-align: right;
                }
                .right {
                    flex: 1;
                }
                button {
                    width: 90%;
                }
            }
        }
    }
}
</style>