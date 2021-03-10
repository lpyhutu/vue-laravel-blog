<template>
    <div class="ranking">
        <Card :title="'阅读排行'">
            <div slot="content">
                <div class="list">
                    <div class="item" v-for="(item, key) in 10" :key="key">
                        <span>{{ key + 1 }}、</span>
                        <span @click="articleDetail()"
                            >laravel结合Redis实现黑名单、倒计时、防刷功能laravel结合Redis实现黑名单、倒计时</span
                        >
                        <span>(31)</span>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

<script>
import Card from "@/components/Card";

export default {
    name: "Ranking",
    components: { Card },
    methods: {
        articleDetail(id) {
            this.$router.push({
                path: "/detail",
                query: {
                    id: id,
                },
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.ranking {
    .list {
        .item {
            cursor: pointer;
            padding: 12px 0px;
            border-bottom: 1px dashed #eee;
            line-height: 180%;
            &:hover {
                color: $bg-theme;
            }
        }
    }
}
</style>