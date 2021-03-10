<template>
    <div class="comment-list">
        <div class="list">
            <a-list>
                <a-list-item
                    description="aaa"
                    v-for="(item, key) in list"
                    :key="key"
                >
                    <a-comment>
                        <span slot="actions" key="comment-nested-reply-to">
                            <span @click="handleThumb(item.id, 0)">
                                <a-icon type="like" theme="filled" />
                                {{ item.thumb_num }}
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
                            <span>
                                <span style="color: #ee4e03">{{
                                    item.master === 1 ? "站长" : ""
                                }}</span>
                                {{ item.name }}</span
                            >
                            <span style="padding-left: 10px">{{
                                formatTime(item.created_at)
                            }}</span>
                        </div>
                        <a-avatar
                            slot="avatar"
                            :src="item.avatar"
                            :alt="item.name"
                        />
                        <p
                            slot="content"
                            class="img"
                            v-html="handlechangeEmotion(item.content)"
                        ></p>
                        <Comment
                            style="display: none"
                            :id="item.id"
                            @handleComment="handleSubComment"
                        ></Comment>
                        <a-comment
                            v-for="(itemTwo, keyTwo) in item.msg_sub"
                            :key="keyTwo"
                        >
                            <span slot="actions" key="comment-nested-reply-to">
                                <span @click="handleThumb(item.id, itemTwo.id)">
                                    <a-icon type="like" theme="filled" />
                                    {{ itemTwo.thumb_num }}
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
                                <span>
                                    <span>
                                        <span style="color: #ee4e03">{{
                                            itemTwo.master === 1 ? "站长" : ""
                                        }}</span>
                                        {{ itemTwo.name }}</span
                                    >
                                    <span>
                                        @
                                        <span style="color: #ee4e03">{{
                                            itemTwo.be_master === 1
                                                ? " 站长 "
                                                : ""
                                        }}</span
                                        >{{ itemTwo.be_name }}</span
                                    ></span
                                >
                                <span style="padding-left: 10px">{{
                                    formatTime(itemTwo.created_at)
                                }}</span>
                            </div>
                            <a-avatar
                                slot="avatar"
                                :src="itemTwo.avatar"
                                :alt="itemTwo.name"
                            />
                            <p
                                slot="content"
                                class="img"
                                v-html="handlechangeEmotion(itemTwo.content)"
                            ></p>
                            <Comment
                                style="display: none"
                                :id="itemTwo.id"
                                @handleComment="handleSubCommentSub"
                            ></Comment>
                        </a-comment>
                    </a-comment>
                </a-list-item>
            </a-list>
        </div>
    </div>
</template>

<script>
import Comment from "@/components/Comment";
import { SwitchDate } from "@/assets/js/time";
import { changeEmotion } from "@/assets/js/changeEmotion";

export default {
    name: "CommentList",
    props: {
        list: Array,
    },
    components: {
        Comment,
    },
    methods: {
        /**
         * 评论留言
         */
        handleSubComment(text, msg_id) {
            this.$emit("handleSubComment", msg_id, text);
        },
        /**
         * 评论子留言
         */
        handleSubCommentSub(text, sub_id) {
            this.$emit("handleSubCommentSub", sub_id, text);
        },
        /**
         * 点赞
         */
        handleThumb(id, sub_id) {
            const uid = this.$cookies.get("userInfo");
            this.$emit("handleThumb", id, sub_id, uid);
        },
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
        },
        /**
         * 解析表情
         */
        handlechangeEmotion(text) {
            return changeEmotion(text);
        },

        /**
         * 评论展示
         */
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

<style lang="scss">
.img {
    // line-height: 28px;
    img {
        width: 28px;
    }
}
</style>