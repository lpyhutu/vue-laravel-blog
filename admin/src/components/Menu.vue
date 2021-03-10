<template>
    <div class="menu" style="::-webkit-scrollbar: ">
        <!-- background-color="#404040"
            text-color="#999999"
            active-text-color="#ffffff" -->
        <el-menu
            :default-active="$route.path"
            class="el-menu-vertical-demo"
            background-color="#404040"
            text-color="#999999"
            active-text-color="#ffffff"
            :collapse="$store.state.isMenu"
        >
            <el-submenu
                :index="key + 'a'"
                v-for="(item, key) in navList"
                :key="key"
            >
                <template slot="title">
                    <i class="iconfont" :class="item.icon"></i>
                    <span slot="title">{{ item.title }}</span>
                </template>
                <el-menu-item
                    :index="itemTwo.path"
                    v-for="(itemTwo, keyTwo) in item.children"
                    :key="keyTwo"
                    @click="jump(itemTwo.path)"
                    >{{ itemTwo.title }}</el-menu-item
                >
            </el-submenu>
        </el-menu>
    </div>
</template>

<script>
export default {
    name: "Menu",
    data() {
        return {
            menuFlag: false,
            navList: [
                {
                    title: "统计分析",
                    icon: "icon-areachart",
                    children: [
                        { title: "控制面板", path: "/panel" },
                        { title: "数据统计", path: "/statistics" },
                    ],
                },

                {
                    title: "用户管理",
                    icon: "icon-user",
                    children: [
                        { title: "管理员", path: "/adminuser" },
                        { title: "电脑端用户", path: "/pc" },
                        { title: "小程序用户", path: "/wechat" },
                    ],
                },

                {
                    title: "文章管理",
                    icon: "icon-file-text",
                    children: [
                        { title: "文章列表", path: "/article" },
                        { title: "评论管理", path: "/comment" },
                    ],
                },

                {
                    title: "留言管理",
                    icon: "icon-comment",
                    children: [{ title: "留言列表", path: "/message" }],
                },
                {
                    title: "类别管理",
                    icon: "icon-appstore",
                    children: [{ title: "文章类别", path: "/type" }],
                },
                {
                    title: "链接管理",
                    icon: "icon-link",
                    children: [{ title: "链接列表", path: "/link" }],
                },
                {
                    title: "开发中心",
                    icon: "icon-wrench",
                    children: [{ title: "变色方块", path: "/discoloration" }],
                },

                {
                    title: "权限管理",
                    icon: "icon-Batchfolding",
                    children: [
                        { title: "等级管理", path: "/powerlevel" },
                        { title: "路由管理", path: "/router" },
                        { title: "权限管理", path: "/power" },
                    ],
                },
                {
                    title: "文件管理",
                    icon: "icon-folder-open",
                    children: [{ title: "图库管理", path: "/gallery" }],
                },
                {
                    title: "网站配置",
                    icon: "icon-setting",
                    children: [
                        { title: "更新日志", path: "/log" },
                        { title: "基本信息", path: "/info" },
                    ],
                },
            ],
        };
    },
    methods: {
        changeMenuFlag() {
            this.menuFlag = !this.menuFlag;
        },
        jump(path) {
            this.$router.push({ path: `${path}` });
        },
    },
};
</script>

<style lang="scss">
.el-aside::-webkit-scrollbar {
    display: none !important;
}
.menu {
    .el-menu-vertical-demo:not(.el-menu--collapse) {
        width: 200px;
        min-height: 400px;
    }
    .el-menu {
        border-right: none;
    }
    .el-menu-item {
        background: #242424 !important;
    }
    .is-active {
        background: $ht-theme !important;
    }
}
</style>