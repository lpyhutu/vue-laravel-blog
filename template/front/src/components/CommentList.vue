<template>
    <div class="comment-list">
        <div class="list">
            <a-list>
                <a-list-item v-for="(item, key) in 3" :key="key">
                    <a-comment>
                        <span slot="actions" key="comment-nested-reply-to">
                            <span>
                                <a-icon type="like" theme="filled" />11
                            </span>
                            <span
                                style="margin-left: 10px"
                                :ref="`reply-${key}`"
                                @click="handleCommentShow(key, null)"
                            >
                                <a-icon type="message" theme="filled" />
                            </span>
                        </span>
                        <div slot="author">
                            <span>糊涂</span>
                            <span style="padding-left: 10px"
                                >2020-1-12 12:12:12</span
                            >
                        </div>
                        <a-avatar
                            slot="avatar"
                            src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
                            alt="糊涂"
                        />
                        <p slot="content">这是一条测试数据</p>
                        <Comment style="display: none"></Comment>
                        <a-comment v-for="(itemTwo, keyTwo) in 2" :key="keyTwo">
                            <span slot="actions" key="comment-nested-reply-to">
                                <span>
                                    <a-icon type="like" theme="filled" />11
                                </span>
                                <span
                                    style="margin-left: 10px"
                                    :ref="`reply-${key}-${keyTwo}`"
                                    @click="handleCommentShow(key, keyTwo)"
                                >
                                    <a-icon type="message" theme="filled" />
                                </span>
                            </span>
                            <div slot="author">
                                <span>糊涂@天真</span>
                                <span style="padding-left: 10px"
                                    >2020-1-12 12:12:12</span
                                >
                            </div>
                            <a-avatar
                                slot="avatar"
                                src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
                                alt="糊涂"
                            />
                            <p slot="content">这是一条测试数据</p>
                            <Comment style="display: none"></Comment>
                        </a-comment>
                    </a-comment>
                </a-list-item>
            </a-list>
        </div>
    </div>
</template>

<script>
import Comment from "@/components/Comment";

export default {
    name: "CommentList",
    components: {
        Comment,
    },
    methods: {
        handleCommentShow(key, keyTwo) {
            let keyVal = "";
            if (keyTwo === null) {
                keyVal = `reply-${key}`;
            } else {
                keyVal = `reply-${key}-${keyTwo}`;
            }
            const { display } = this.$refs[
                keyVal
            ][0].parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling.firstChild.style;
            if (display === "" || display === "none") {
                this.$refs[
                    keyVal
                ][0].parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling.firstChild.style.display =
                    "block";
            } else {
                this.$refs[
                    keyVal
                ][0].parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling.firstChild.style.display =
                    "none";
            }
        },
    },
};
</script>

<style>
</style>