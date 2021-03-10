<template>
    <div class="message">
        <div class="app-content">
            <div class="app-left">
                <div class="content">
                    <Title :title="'温馨提示'"></Title>
                    <div class="tip">
                        <p>1、欢迎大家在这留言或提意见建议；</p>
                        <p>
                            2、留言内容要健康积极向上，不得刷评论、发表不良信息；
                        </p>
                        <p>3、回复均以邮件形式通知，请输入常用有效邮箱；</p>
                        <p>
                            4、如果发现某些功能不能使用，请联系邮箱
                            1048672466@qq.com。
                        </p>
                    </div>
                    <Comment></Comment>
                    <Title :title="'留言列表'" style="margin-top: 20px"></Title>
                    <CommentList></CommentList>
                </div>
            </div>
            <div class="app-right">
                <User style="margin: 0px 0px 15px"></User>
                <Ranking class="app-none" style="margin: 15px 0"></Ranking>
                <HTLink class="app-none"></HTLink>
            </div>
        </div>
    </div>
</template>

<script>
import User from "@/components/User";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import Title from "@/components/Title";
import Comment from "@/components/Comment";
import CommentList from "@/components/CommentList";
export default {
    name: "Message",
    metaInfo: {
        title: "留言板 - 分享技术，分享生活 - 糊涂博客",
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
    data() {
        return {};
    },
    components: { User, Ranking, HTLink, Title, Comment, CommentList },
};
</script>


<style lang="scss" scoped>
.message {
    .content {
        padding: 20px;
        background: $bg-white;
        .tip {
            padding: 10px 0;
        }
    }
}
</style>
