<template>
    <div class="ranking">
        <Card :title="'阅读排行'">
            <div slot="content">
                <div class="list">
                    <nuxt-link
                        prefetch
                        class="item"
                        v-for="(item, key) in $store.state.articleRanking"
                        :key="key"
                        :to="{ name: 'detail-id', params: { id: item.id } }"
                    >
                        <span>{{ key + 1 }}、</span>
                        <span>{{ item.title }}</span>
                        <span>({{ item.read_num }})</span>
                    </nuxt-link>
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
            this.$router.push(`/detail/${id}`);
            this.$emit("handleArticleDetail", id);
        },
    },
};
</script>

<style lang="scss" scoped>
.ranking {
    .list {
        .item {
            cursor: pointer;
            padding: 8px 0px;
            border-bottom: 1px dashed #eee;
            line-height: 180%;
            display: inline-block;
            color: #000000a6;
            &:hover {
                color: $bg-theme;
            }
        }
    }
}
</style>