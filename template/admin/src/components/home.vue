<template>
    <div class="home b-flex">
        <div class="menu">
            <MenuItem ref="menu"></MenuItem>
        </div>
        <div class="right b-flex b-flow-column">
            <div class="header b-flex b-col-center b-row-between">
                <i
                    :class="hamburger ? ' icon-outdent' : 'icon-indent'"
                    class="iconfont"
                    @click="handleMenuFlag"
                >
                </i>
                <img
                    @click="textFlag = true"
                    src="../assets/img/WeChat.jpg"
                    alt=""
                />
                <el-dialog
                    title="用户信息"
                    :visible.sync="textFlag"
                    :modal-append-to-body="false"
                    width="30%"
                >
                    <div class="dialog-user-info b-flex">
                        <div class="left">
                            <img
                                @click="textFlag = true"
                                src="../assets/img/WeChat.jpg"
                                alt=""
                            />
                        </div>
                        <div class="right">
                            <div class="item">用户名：糊涂</div>
                            <div class="item">权限：超级管理员</div>
                            <div class="item">
                                上级登陆时间：2020-09-29 12：00：00
                            </div>
                            <div class="item">
                                <el-button size="mini">
                                    <i class="iconfont icon-poweroff"></i>
                                </el-button>
                            </div>
                        </div>
                    </div>
                </el-dialog>
            </div>
            <div class="main">
                <router-view></router-view>
            </div>
            <div class="footer b-flex b-col-center b-row-center">
                Copyright © 2020 UGO [www.lpyhutu.cn] All Rights Reserved
            </div>
        </div>
    </div>
</template>

<script>
import MenuItem from "@/components/template/menu-item.vue";
export default {
    name: "Home",
    components: {
        MenuItem,
    },
    data() {
        return {
            hamburger: true,
            textFlag: false,
        };
    },
    methods: {
        handleMenuFlag() {
            this.hamburger = !this.hamburger;
            this.$refs.menu.changeMenuFlag();
        },
    },
};
</script>

<style lang="scss" scoped>
.home {
    position: relative;
    width: 100%;
    height: 100%;
    > .menu {
        overflow: auto;
        background: #404040;
    }
    > .right {
        height: 100%;
        flex: 1;
        > .header {
            height: 60px;
            background: #fff;
            padding: 0 10px;
            i {
                font-size: 24px;
                cursor: pointer;
                padding: 5px;
                border-radius: 2px;
            }
            > img {
                width: 40px;
                height: 40px;
                cursor: pointer;
            }
            .dialog-user-info {
                .left {
                    padding: 10px;
                    img {
                        width: 40px;
                        height: 40px;
                    }
                }
                .right {
                    div {
                        padding: 10px;
                        i {
                            font-size: 16px;
                        }
                        button {
                            background: rgb(255, 136, 0);
                            color: #fff;
                        }
                    }
                }
            }
        }
        .main {
            flex: 1;
            overflow: auto;
            background: $b-main-bg;
            padding: 10px;
        }
        .footer {
            height: 30px;
        }
    }
}
</style>