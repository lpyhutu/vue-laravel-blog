<template>
    <div id="app">
        <Loading v-show="false" :tip="'loading'"></Loading>
        <Header></Header>
        <div style="height: 70px"></div>
        <Search v-if="$store.state.isSearch"></Search>
        <Menu></Menu>
        <main>
            <router-view />
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
export default {
    name: "App",
    metaInfo: {
        title: "分享技术，分享生活 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "网页，后台，技术，分享",
            },
            {
                name: "description",
                content:
                    "博客个人博客网站,一位编程爱好者的成长地。记录工作、生活中的点点滴滴,不定期更新分享，也希望能够认识更多的朋友。",
            },
        ],
    },
    data() {
        return {
            scrollTop: 0,
        };
    },
    components: { Header, Menu, Footer, Loading, Search },
    methods: {
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

                // let { scrollHeight } =
                //     document.documentElement || document.body;
                // let { clientHeight } = document.documentElement;
                // _this.handlePercent(scrollTop / (scrollHeight - clientHeight));
            });
        },
    },
    created() {},
    mounted() {
        this.handleScrolltop();
    },
};
</script>
