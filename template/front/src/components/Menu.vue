<template>
    <div class="menu">
        <a-drawer
            placement="left"
            :closable="false"
            :visible="$store.state.isMenu"
            @close="onClose"
        >
            <div class="user ht-flex ht-flow-column ht-col-center">
                <div class="logo">
                    <img
                        src="https://q.qlogo.cn/headimg_dl?dst_uin=1048672466&spec=100"
                        alt=""
                    />
                </div>
                <div class="name ht-font-weight">糊涂</div>
                <div class="title ht-font-tip">每天进步一点点...</div>
                <div class="num ht-flex ht-row-between">
                    <div
                        class="item ht-flex ht-row-center ht-col-center ht-flow-column"
                    >
                        <div class="ht-font-weight">11</div>
                        <div>在线</div>
                    </div>
                    <div
                        class="item ht-flex ht-row-center ht-col-center ht-flow-column"
                    >
                        <div class="ht-font-weight">111</div>
                        <div>文章</div>
                    </div>
                    <div
                        class="item ht-flex ht-row-center ht-col-center ht-flow-column"
                    >
                        <div class="ht-font-weight">1131</div>
                        <div>访问</div>
                    </div>
                </div>
            </div>
            <div class="nav">
                <div
                    class="item"
                    :class="$route.path === item.path ? 'ht-active-router' : ''"
                    v-for="(item, key) in $store.state.navList"
                    :key="key"
                    @click="jump(item.path)"
                >
                    <a-icon :type="item.icon" /><span>{{ item.title }}</span>
                </div>
            </div>
        </a-drawer>
    </div>
</template>

<script>
export default {
    name: "Menu",
    data() {
        return {
            visible: false,
            placement: "left",
        };
    },
    methods: {
        showDrawer() {
            this.visible = true;
        },
        onClose() {
            this.$store.commit("isMenu", false);
            this.visible = false;
        },
        onChange(e) {
            this.placement = e.target.value;
        },
        // 跳转
        jump(path) {
            this.$router.push({
                path: path,
            });
            this.$store.commit("isMenu", false);
        },
    },
};
</script>
<style lang="scss">
.ant-drawer-body {
    padding: 0px !important;
}
</style>

<style lang="scss" scoped>
.user {
    line-height: 170%;
    // border-bottom: 1px solid #eee;
    .logo {
        img {
            width: 60px;
            height: 60px;
            margin: 20px 0px 10px;
            border: 1px solid #eee;
            border-radius: 100%;
        }
    }
    .title {
        padding: 0 0 10px;
    }
    .num {
        width: 100%;

        .item {
            flex: 1;
            // padding: 10px;
            div:first-child {
                color: $bg-theme;
            }
            &:nth-child(2) {
                border-left: 1px solid #eee;
                border-right: 1px solid #eee;
            }
        }
    }
}
.nav {
    margin-top: 10px;
    .item {
        padding: 10px 20px;
        cursor: pointer;
        span {
            margin-left: 5px;
        }
        &:hover {
            color: $bg-theme;
        }
    }
}
</style>