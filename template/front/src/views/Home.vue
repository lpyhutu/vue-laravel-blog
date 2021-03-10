<template>
    <div class="home">
        <div class="app-content">
            <div class="app-left"><Article></Article></div>
            <div class="app-right">
                <User></User>
                <Type style="margin: 15px 0"></Type>
                <Ranking class="app-none"></Ranking>
                <HTLink class="app-none" style="margin: 15px 0">></HTLink>
            </div>
        </div>
    </div>
</template>

<script>
import Article from "@/components/Article";
import User from "@/components/User";
import Type from "@/components/Type";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";

export default {
    name: "Home",
    components: { Article, User, Type, Ranking, HTLink },
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
};
</script>
<style scoped>
</style>
