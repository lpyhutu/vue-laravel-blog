<template>
    <div class="menu-item">
        <el-menu
            :default-active="$route.path"
            class="el-menu-vertical-demo"
            background-color="#404040"
            text-color="#999999"
            active-text-color="#ffffff"
            :collapse="menuFlag"
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
    name: "MenuItem",
    data() {
        return {
            menuFlag: false,
            navList: [
                {
                    title: "统计分析",
                    icon: "icon-areachart",
                    children: [{ title: "数据统计", path: "/statistics" }],
                },
                {
                    title: "用户管理",
                    icon: "icon-user",
                    children: [
                        { title: "博客用户", path: "" },
                        { title: "小程序用户", path: "" },
                        { title: "用户反馈", path: "" },
                        { title: "系统消息", path: "" },
                    ],
                },
                {
                    title: "文章管理",
                    icon: "icon-file-text",
                    children: [
                        { title: "文章列表", path: "" },
                        { title: "评论管理", path: "" },
                        { title: "回收站", path: "" },
                    ],
                },
                {
                    title: "留言管理",
                    icon: "icon-comment",
                    children: [{ title: "留言列表", path: "" }],
                },
                {
                    title: "类别管理",
                    icon: "icon-appstore",
                    children: [{ title: "类别列表", path: "" }],
                },
                {
                    title: "链接管理",
                    icon: "icon-link",
                    children: [{ title: "链接列表", path: "" }],
                },
                {
                    title: "网站配置",
                    icon: "icon-setting",
                    children: [{ title: "关于", path: "" }],
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

<style>
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
}
.el-menu {
    border-right: none;
}
.el-submenu .el-menu-item {
    background: #242424 !important;
}
.active {
    background: red !important;
}
</style>