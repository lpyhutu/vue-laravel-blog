<template>
    <div class="type">
        <Card :title="'文章分类'">
            <div slot="content">
                <div class="list">
                    <div class="item" v-for="(item, key) in 10" :key="key">
                        Nginx(12)
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

<script>
import Card from "@/components/Card";

export default {
    name: "Type",
    components: { Card },
};
</script>

<style lang="scss" scoped>
.type {
    .list {
        .item {
            cursor: pointer;
            padding: 12px 0px;
            border-bottom: 1px dashed #eee;
            &:hover {
                color: $bg-theme;
            }
        }
    }
}
</style>