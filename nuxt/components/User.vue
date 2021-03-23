<template>
    <div class="user">
        <Card :title="'网站信息'">
            <div slot="content">
                <div class="num">
                    <div class="item">
                        <a-icon type="user" /><span>博主：</span>
                        <span>糊涂</span>
                    </div>
                    <div class="item">
                        <a-icon type="github" /><span>Github：</span
                        ><span
                            ><a
                                href="https://github.com/lpyhutu"
                                target="_blank"
                                >Github</a
                            ></span
                        >
                    </div>
                    <div class="item">
                        <a-icon type="mail" /><span>联系邮箱：</span
                        ><span
                            ><a
                                href=" http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=1048672466@qq.com"
                                target="_blank"
                                >1048672466@qq.com</a
                            ></span
                        >
                    </div>

                    <div class="item">
                        <a-icon type="team" /><span>在线人数：</span
                        ><span>{{
                            $store.state.online
                        }}</span>
                    </div>
                    <div class="item">
                        <a-icon type="file-word" /><span>文章数量：</span
                        ><span>{{ $store.state.siteTotal.article_num }}</span>
                    </div>
                    <div class="item">
                        <a-icon type="area-chart" /><span>访问总量：</span
                        ><span>{{
                            $store.state.siteTotal.visitsInterval
                        }}</span>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

<script>
import Card from "@/components/Card";

export default {
    name: "User",
    components: { Card },
};
</script>

<style lang="scss" scoped>
.user {
    .num {
        .item {
            padding: 8px 0;
            span {
                padding-left: 5px;
            }
        }
    }
}
</style>