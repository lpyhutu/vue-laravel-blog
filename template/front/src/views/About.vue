<template>
    <div class="about">
        <div class="app-content">
            <div class="app-left">
                <div class="content">介绍</div>
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
export default {
    name: "About",
    metaInfo: {
        title: "关于我 - 分享技术，分享生活 - 糊涂博客",
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
    components: { User, Ranking, HTLink },
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

