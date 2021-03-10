<template>
    <div class="link">
        <Card :title="'友链推荐'">
            <div slot="content">
                <div class="list ht-flex ht-wrap">
                    <a
                        :href="item.site"
                        target="_blank"
                        class="item ht-flex ht-col-center"
                        v-for="(item, key) in $store.state.linkList"
                        :key="key"
                    >
                        <img :src="handleImg(item.img_url)" alt="" />
                        <span>{{ item.title }}</span>
                    </a>
                </div>
            </div>
        </Card>
    </div>
</template>

<script>
import Card from "@/components/Card";

export default {
    name: "Link",
    components: { Card },
    methods: {
        handleImg(url) {
            if (url === "0") {
                return require("../assets/img/null.png");
            } else {
                return this.$assets + url;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.link {
    .list {
        .item {
            cursor: pointer;
            color: #000000a6;
            padding: 5px 10px;
            img {
                width: 28px;
                height: 28px;
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
</style>