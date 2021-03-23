<template>
    <div id="app">
        <Loading v-show="isLoading" :tip="'loading'"></Loading>
        <Header></Header>
        <div style="height: 70px"></div>
        <Search v-if="$store.state.isSearch"></Search>
        <Menu></Menu>
        <main>
            <Nuxt />
        </main>
        <Footer></Footer>
        <a-back-top />
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
    data() {
        return {
            scrollTop: 0,
            isLogin: false,
            isLoading: true,
            websoket: null,
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
                        this.$store.commit("setUid", uid);
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
                this.$store.commit("setUid", this.$cookies.get("userInfo"));
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
            this.websock = new WebSocket("wss://wss.lpya.cn/blog");
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
        // websocketclose(e) {
        //     console.log(e);
        // },
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
    mounted() {
        // (function () {
        //     var src =
        //         "https://jspassport.ssl.qhimg.com/11.0.1.js?d182b3f28525f2db83acfaaf6e696dba";
        //     document.write(`<script src="${src}" id="sozz"><\/script>`);
        // })();
        this.userLogin();
        this.handleScrolltop();
        this.initWebSocket();
    },
};
</script>
