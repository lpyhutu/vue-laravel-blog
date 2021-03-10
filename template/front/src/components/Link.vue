<template>
    <div class="link">
        <Card :title="'友链推荐'">
            <div slot="content">
                <div class="list ht-flex ht-wrap">
                    <div class="item">
                        <img src="../assets/img/logo.png" alt="" />
                        <span>糊涂个人博客</span>
                    </div>
                    <div class="item">
                        <img src="../assets/img/logo.png" alt="" />
                        <span>糊涂个人博客糊涂个人博客</span>
                    </div>
                    <div class="item">
                        <img src="../assets/img/logo.png" alt="" />
                        <span>糊涂个人博客</span>
                    </div>
                    <div class="item">
                        <img src="../assets/img/logo.png" alt="" />
                        <span>糊涂个人博客</span>
                    </div>
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
};
</script>

<style lang="scss" scoped>
.link {
    .list {
        .item {
            cursor: pointer;

            padding: 5px 10px;
            img {
                width: 30px;
                height: 30px;
            }
            &:hover {
                color: $bg-theme;
            }
        }
    }
}
</style>