<template>
    <div class="about">
        <div class="app-content">
            <div class="app-left">
                <div class="content">
                    <Content :text="$store.state.userInfo.content"></Content>
                </div>
            </div>
            <div class="app-right">
                <User style="margin: 0px 0px 15px"></User>
                <Ranking class="app-none" style="margin: 15px 0"></Ranking>
                <HTLink class="app-none" style="margin: 15px 0"></HTLink>
            </div>
        </div>
    </div>
</template>

<script>
import User from "@/components/User";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import Content from "@/components/Content";

export default {
    name: "About",
    metaInfo: {
        title: "关于我 - 网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "网页,简介,个人,小程序,博客",
            },
            {
                name: "description",
                content:
                    "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
            },
        ],
    },
    components: { User, Ranking, HTLink, Content },
    created() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    },
};
</script>

<style lang="scss" scoped>
.about {
    .content {
        padding: 20px;
        background: $bg-white;
    }
}
</style>

