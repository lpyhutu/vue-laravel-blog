<template>
    <div class="experiment">
        <div class="app-content">
            <div class="app-left">
                <div class="content">
                    <Title :title="'工具推荐'"></Title>
                    <div class="list ht-flex ht-wrap">
                        <div
                            class="item ht-flex ht-col-center"
                            v-for="(item, key) in list"
                            :key="key"
                            @click="jump(item.path)"
                        >
                            <img :src="item.img" alt="" />
                            <span>{{ item.title }}</span>
                        </div>
                    </div>
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
import Title from "@/components/Title";

export default {
    name: "Experiment",
    metaInfo: {
        title: "开发中心 - 网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "网页,游戏,工具,益智,休闲",
            },
            {
                name: "description",
                content:
                    "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
            },
        ],
    },
    components: { User, Ranking, HTLink, Title },
    data() {
        return {
            list: [
                {
                    img: require("@/assets/img/discoloration.png"),
                    title: "变色方块",
                    path: "/discoloration",
                },
            ],
        };
    },
    methods: {
        jump(path) {
            this.$router.push(path);
        },
    },
    created() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    },
};
</script>

<style lang="scss" scoped>
.experiment {
    .content {
        padding: 20px;
        background: $bg-white;
        min-height: 500px;
        .list {
            margin-top: 10px;
            .item {
                cursor: pointer;
                color: #000000a6;
                padding: 5px 10px;
                img {
                    width: 25px;
                    height: 25px;
                }
                span {
                    padding-left: 5px;
                }
                &:hover {
                    color: $bg-theme;
                }
            }
        }
    }
}
</style>

