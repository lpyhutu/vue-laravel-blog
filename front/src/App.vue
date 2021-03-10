<template>
    <div id="app">
        <template v-if="$route.meta.level === 2">
            <router-view />
        </template>
        <template v-else>
            <Loading v-show="isLoading" :tip="'loading'"></Loading>
            <Header></Header>
            <div style="height: 70px"></div>
            <Search v-if="$store.state.isSearch"></Search>
            <Menu></Menu>
            <main v-if="isLogin">
                <router-view />
            </main>
            <Footer></Footer>
            <a-back-top />
        </template>
    </div>
</template>
<script>
import Header from "@/components/Header";
import Menu from "@/components/Menu";
import Footer from "@/components/Footer";
import Loading from "@/components/Loading";
import Search from "@/components/Search";
import {
    linkGet,
    infoGet,
    totalVisitsTime,
    totalNum,
    userLogin,
    articleRanking,
} from "@/assets/api/api";
export default {
    name: "App",
    metaInfo: {
        title: "网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "vue,redis,php,小程序,博客",
            },
            {
                name: "description",
                content:
                    "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
            },
        ],
    },
    data() {
        return {
            scrollTop: 0,
            isLogin: false,
            isLoading: true,
        };
    },
    components: { Header, Menu, Footer, Loading, Search },
    methods: {
        /**
         * 访问
         */
        userLogin() {
            this.isLoading = true;
            if (!this.$cookies.isKey("userInfo")) {
                userLogin().then((res) => {
                    if (res) {
                        const { time, uid } = res.data;
                        this.$cookies.set("userInfo", uid, time);
                        this.isLogin = true;
                        this.linkGet();
                        this.infoGet();
                        this.addVisitsTime();
                        this.totalNum();
                        this.articleRanking();
                    } else {
                        this.isLogin = false;
                        this.isLoading = false;
                    }
                });
            } else {
                this.isLogin = true;
                this.isLoading = false;
                this.linkGet();
                this.infoGet();
                this.addVisitsTime();
                this.totalNum();
                this.articleRanking();
            }
        },
        /**
         * 链接列表
         */
        linkGet() {
            this.isLoading = true;
            linkGet().then((res) => {
                if (res) {
                    this.$store.commit("linkList", res.data);
                }
                this.isLoading = false;
            });
        },
        /**
         * 基本信息
         */
        infoGet() {
            infoGet().then((res) => {
                if (res) {
                    const { data } = res;
                    this.$store.commit("userInfo", data[0]);
                }
            });
        },
        /**
         * 阅读排行
         */
        articleRanking() {
            articleRanking().then((res) => {
                if (res) {
                    this.$store.commit("articleRanking", res.data);
                }
            });
        },
        /**
         * 统计
         */
        totalNum() {
            totalNum().then((res) => {
                if (res) {
                    this.$store.commit("siteTotal", res.data);
                }
            });
        },
        /**
         * 浏览时长
         */
        addVisitsTime() {
            totalVisitsTime(this.$cookies.get("userInfo"));
            this.$store.commit("visitsTime", 60);
            this.visitsTime();
        },

        visitsTime() {
            if (this.$store.state.visitsTime > 0) {
                setTimeout(() => {
                    this.$store.commit(
                        "visitsTime",
                        this.$store.state.visitsTime - 1
                    );
                    this.visitsTime();
                }, 1000);
                return;
            }
            this.addVisitsTime();
        },
        /**
         * 在线人数
         */
        initWebSocket() {
            // this.websock = new WebSocket("ws://127.0.0.1:2346");
            this.websock = new WebSocket("wss://wss.lpyhutu.cn/blog");
            this.websock.onmessage = this.websocketonmessage;
            this.websock.onopen = this.websocketonopen;
            this.websock.onerror = this.websocketonerror;
            this.websock.onclose = this.websocketclose;
        },
        websocketonopen() {
            this.websocketsend(
                JSON.stringify({
                    type: "front",
                    group: "front_login",
                    // uid: this.$cookies.get("token"),
                })
            );
        },
        websocketonerror() {
            this.initWebSocket();
        },
        websocketonmessage(e) {
            let data = JSON.parse(e.data);
            if (data.type == "online") {
                this.$store.commit("online", data.data.online);
            }
        },
        websocketsend(Data) {
            this.websock.send(Data);
        },
        /**
         *  监听滚动条
         */
        handlePercent(val) {
            if (val >= 0.999) {
                this.$bus.$emit("handleScroll", true);
            }
        },
        handleScrolltop() {
            const _this = this;
            window.addEventListener("scroll", function () {
                const scrollTop =
                    window.pageYOffset ||
                    document.documentElement.scrollTop ||
                    document.body.scrollTop;
                const scroll = scrollTop - _this.scrollTop;
                _this.scrollTop = scrollTop;
                if (scroll < 0) {
                    if (!_this.$store.state.isHeader) {
                        _this.$store.commit("isHeader", true);
                    }
                } else {
                    if (_this.$store.state.isHeader) {
                        _this.$store.commit("isHeader", false);
                    }
                }
                let { scrollHeight } =
                    document.documentElement || document.body;
                let { clientHeight } = document.documentElement;
                _this.handlePercent(scrollTop / (scrollHeight - clientHeight));
            });
        },
    },
    created() {
        // this.$router.go(-1)
        // console.log(this.$router);
        this.userLogin();
        this.initWebSocket();
    },
    mounted() {
        this.handleScrolltop();
    },
};
</script>
