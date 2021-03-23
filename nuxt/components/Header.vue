<template>
    <div
        class="header"
        :style="{ top: `${$store.state.isHeader ? 0 : -70}px` }"
    >
        <div class="content ht-flex ht-row-between">
            <div class="left ht-flex ht-col-center">
                <div class="logo">
                    <img
                        style="filter: invert(0%) hue-rotate(180deg)"
                        src="../assets/img/logo.png"
                        alt=""
                    />
                </div>
                <div class="nav ht-flex">
                    <nuxt-link
                        prefetch
                        class="item"
                        :class="
                            $route.path === item.path
                                ? 'ht-active-router'
                                : 'ht-none-router'
                        "
                        v-for="(item, key) in $store.state.navList"
                        :key="key"
                        :to="item.path"
                    >
                        <a-icon :type="item.icon" /><span>{{
                            item.title
                        }}</span>
                    </nuxt-link>
                </div>
            </div>
            <div class="right ht-flex ht-col-center">
                <div class="search ht-flex">
                    <a-button icon="search" @click="showSearch" />
                </div>

                <div class="setting">
                    <a-button
                        :icon="
                            $store.state.isMenu ? 'menu-unfold' : 'menu-fold'
                        "
                        @click="handleMenu"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Header",
    data() {
        return {};
    },
    methods: {
        showSearch() {
            const flag = this.$store.state.isSearch;
            this.$store.commit("isSearch", !flag);
            if (!flag) {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        },
        // 导航栏
        handleMenu() {
            this.$store.commit("isMenu", true);
        },
    },
};
</script>

<style lang="scss" scoped>
.header {
    position: fixed;
    top: 0px;
    width: 100%;
    background-color: $bg-white;
    z-index: 100;
    box-shadow: 0 0 10px #dadada;
    @include ht-transition(0.4s);
    > .content {
        max-width: 1200px;
        margin: auto;
        height: 70px;
        .left {
            .logo {
                width: 100px;
                img {
                    height: 60px;
                    width: 60px;
                }
            }
            .nav {
                .item {
                    cursor: pointer;
                    font-size: 15px;
                    margin-right: 30px;
                    // color: #000000a6;
                    span {
                        margin-left: 5px;
                    }
                }
            }
        }
        .right {
            .search {
                cursor: pointer;
                margin-right: 10px;
                @include ht-transition(0.4s);
            }
            .setting {
                display: none;
            }
            div {
                margin-right: 10px;
            }
        }
    }
}

@media (max-width: 767px) {
    .header {
        > .content {
            > .left {
                .nav {
                    display: none;
                }
            }
            .right {
                .setting {
                    display: block;
                }
            }
        }
    }
}
</style>