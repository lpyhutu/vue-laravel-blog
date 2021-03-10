<template>
    <div class="userpc-content">
        <div class="header ht-flex">
            <div title="刷新">
                <el-button
                    icon="el-icon-refresh"
                    size="small"
                    type="primary"
                    @click="get"
                ></el-button>
            </div>
            <div title="删除所选">
                <el-button
                    icon="el-icon-delete"
                    size="small"
                    type="danger"
                    @click="delAll"
                ></el-button>
            </div>
        </div>
        <div class="content">
            <el-table
                :data="data"
                v-loading="loading"
                border
                @selection-change="handleSelectionChange"
                @row-dblclick="handleEdit"
                style="width: 100%"
            >
                <el-table-column type="selection" fixed align="center">
                </el-table-column>
                <el-table-column type="index" label="#" align="center">
                </el-table-column>
                <el-table-column
                    prop="avatar"
                    label="头像"
                    width="70"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-avatar
                            shape="square"
                            size="medium"
                            :src="scope.row.avatar"
                        ></el-avatar>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="master"
                    label="角色"
                    width="100"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-tag
                            size="small"
                            :type="scope.row.master === 1 ? 'danger' : ''"
                        >
                            {{ scope.row.master === 1 ? "站长" : "用户" }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="qq"
                    label="QQ"
                    align="center"
                    width="180"
                >
                </el-table-column>
                <el-table-column
                    prop="master"
                    label="回复"
                    width="300"
                    align="center"
                >
                    <template slot-scope="scope">
                        <span style="color: red">{{ scope.row.be_name }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="content"
                    label="内容"
                    align="center"
                    width="360"
                >
                    <template slot-scope="props">
                        <div class="table-title" :title="props.row.content">
                            {{ props.row.content }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="昵称"
                    align="center"
                    width="180"
                >
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="邮箱"
                    width="200"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="thumb_num"
                    label="点赞"
                    width="100"
                    align="center"
                >
                </el-table-column>

                <el-table-column
                    prop="created_at"
                    label="创建时间"
                    width="180"
                    align="center"
                >
                    <template slot-scope="props">
                        {{ formatTime(props.row.created_at) }}
                    </template>
                </el-table-column>
                <el-table-column
                    prop="release"
                    label="审核"
                    width="100"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-switch
                            @change="release(scope.row.id)"
                            :value="scope.row.release === 1 ? true : false"
                            active-color="#55cbc4"
                        ></el-switch>
                    </template>
                </el-table-column>

                <el-table-column
                    fixed="right"
                    label="操作"
                    width="180"
                    align="center"
                >
                    <template slot-scope="scope">
                        <div class="header ht-flex ht-col-center ht-row-center">
                            <div class="refresh" title="评论">
                                <el-button
                                    icon="el-icon-chat-dot-round"
                                    size="mini"
                                    type="primary"
                                    @click="handleComment(scope.row.id)"
                                ></el-button>
                            </div>
                            <div class="edit" title="编辑">
                                <el-button
                                    icon="el-icon-edit"
                                    size="mini"
                                    type="warning"
                                    @click="handleEdit(scope.row)"
                                ></el-button>
                            </div>
                            <div class="delete" title="删除">
                                <el-button
                                    icon="el-icon-delete"
                                    size="mini"
                                    type="danger"
                                    @click="delCurrent(scope.row.id)"
                                ></el-button>
                            </div>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="paging">
            <el-pagination
                background
                layout="total,sizes,prev,pager, next"
                :total="total"
                :page-sizes="[15, 35, 50, 100]"
                @current-change="handleCurrentPage"
                @size-change="handlePageSize"
            >
            </el-pagination>
        </div>
        <el-dialog
            :visible.sync="dialogVisible"
            :modal="true"
            :show-close="false"
            :close-on-click-modal="false"
            :modal-append-to-body="false"
            :fullscreen="fullscreen"
            top="0"
            :custom-class="fullscreen ? '' : 'el-dialog-fullscreen'"
        >
            <div slot="title" class="el-dialog-header">
                <div class="title-left">{{ editFlag ? "编辑" : "评论" }}</div>
                <div class="title-right">
                    <i
                        :title="fullscreen ? '最小化' : '最大化'"
                        class="iconfont icon-Batchfolding"
                        @click="fullscreen = !fullscreen"
                    ></i>
                    <i
                        title="关闭"
                        class="iconfont icon-close"
                        @click="dialogVisible = false"
                    ></i>
                </div>
            </div>
            <div class="dialog-contnet">
                <div class="item">
                    <div class="left">QQ：</div>
                    <div class="right">
                        <el-input
                            v-model="qq"
                            minlength="5"
                            maxlength="11"
                            show-word-limit
                            @change="qqInfo"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">昵称：</div>
                    <div class="right">
                        <el-input
                            v-model="name"
                            maxlength="20"
                            show-word-limit
                            disabled
                            placeholder="昵称（自动获取）"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">邮箱：</div>
                    <div class="right">
                        <el-input
                            v-model="email"
                            maxlength="20"
                            show-word-limit
                            disabled
                            placeholder="邮箱（自动获取）"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">头像：</div>
                    <div class="right">
                        <el-input
                            v-model="avatar"
                            maxlength="100"
                            show-word-limit
                            disabled
                            placeholder="头像（自动获取）"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">内容：</div>
                    <div class="right">
                        <el-input
                            type="textarea"
                            :rows="6"
                            maxlength="150"
                            show-word-limit
                            v-model="content"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">点赞：</div>
                    <div class="right">
                        <el-input
                            v-model="thumb_num"
                            type="number"
                            minlength="0"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">角色：</div>
                    <div class="right">
                        <el-switch
                            @change="handleMaster"
                            :value="master === 1 ? true : false"
                            active-color="#55cbc4"
                        ></el-switch>
                    </div>
                </div>
                <div class="item">
                    <div class="left">创建时间：</div>
                    <div class="right">
                        <el-date-picker
                            v-model="created_at"
                            type="date"
                            placeholder="选择日期"
                            format="yyyy 年 MM 月 dd 日"
                            value-format="timestamp"
                        >
                        </el-date-picker>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <el-button size="small" @click="clear">重置</el-button>
                <el-button size="small" @click="confirm" type="primary"
                    >确定</el-button
                >
            </div>
        </el-dialog>
    </div>
</template>

<script>
import {
    CommentSubGet,
    CommentSubEdit,
    CommentSubDel,
    CommentSubRelease,
    qqInfo,
    CommentSubCommentSub,
} from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";
import { checkQQ } from "@/assets/js/reg";

export default {
    name: "MessageSubList",
    props: {
        msg_id: Number,
        article_id: Number,
    },
    data() {
        return {
            dialogVisible: false,
            fullscreen: false,
            loading: true,
            editFlag: false,
            editId: "",
            ids: "",
            data: [],
            start: 1,
            pageSize: 15,
            total: 0,
            qq: "",
            name: "",
            email: "",
            avatar: "",
            content: "",
            thumb_num: 0,
            master: 2,
            created_at: Date.now(),
            subFlag: false,
            msgId: 0,
            subId: 0,
            articleId: 0,
        };
    },
    methods: {
        handleMsgId(id, article_id) {
            this.msgId = id;
            this.articleId = article_id;
            this.get();
        },
        /**
         * 获取
         */
        get() {
            this.loading = true;
            CommentSubGet({
                msg_id: this.msgId === 0 ? this.msg_id : this.msgId,
                article_id:
                    this.articleId === 0 ? this.article_id : this.articleId,
                start: (this.start - 1) * this.pageSize,
                pageSize: this.pageSize,
            }).then((res) => {
                if (res) {
                    const { data, total } = res;
                    this.data = data;
                    this.total = total;
                } else {
                    this.data = [];
                    this.total = 0;
                }
                this.loading = false;
            });
        },
        /**
         * 删除所有
         */
        delAll() {
            this.del(this.ids);
        },
        /**
         * 删除当前
         */
        delCurrent(id) {
            this.del(id);
        },
        /**
         * 删除||删除所选
         */
        del(id) {
            this.$msgBox
                .confirm("删除所选, 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning",
                })
                .then(() => {
                    if (id === "") {
                        message(1003, "请选择删除内容！");
                        return;
                    }
                    CommentSubDel({ id: id }).then((res) => {
                        if (res) {
                            this.get();
                        }
                    });
                })
                .catch(() => {});
        },
        /**
         * 添加||编辑
         */
        confirm() {
            if (!this.checkInput()) {
                return;
            }
            if (this.editFlag) {
                this.edit();
            } else {
                this.comment();
            }
        },

        /**
         * 编辑
         */
        handleEdit(row) {
            this.dialogVisible = true;
            this.editFlag = true;
            this.editId = row.id;
            this.qq = row.qq;
            this.name = row.name;
            this.email = row.email;
            this.avatar = row.avatar;
            this.content = row.content;
            this.thumb_num = row.thumb_num;
            this.created_at = Date.parse(new Date(row.created_at));
        },
        edit() {
            if (this.editId === "" || this.qq === "" || this.content === "") {
                message(1003, "参数为空或格式错误！");
                return;
            }
            CommentSubEdit({
                id: this.editId,
                qq: this.qq,
                name: this.name,
                email: this.email,
                avatar: this.avatar,
                content: this.content,
                thumb_num: this.thumb_num,
                master: this.master,
                created_at: parseInt(this.created_at / 1000),
            }).then((res) => {
                if (res) {
                    this.get();
                    this.dialogVisible = false;
                }
            });
        },
        /**
         * 评论
         */
        handleComment(id) {
            this.dialogVisible = true;
            this.editFlag = false;
            this.subId = id;
        },
        comment() {
            CommentSubCommentSub({
                subId: this.subId,
                qq: this.qq,
                name: this.name,
                email: this.email,
                avatar: this.avatar,
                content: this.content,
                thumb_num: this.thumb_num,
                master: this.master,
                created_at: parseInt(this.created_at / 1000),
            }).then((res) => {
                if (res) {
                    message(1003, "评论成功！", true);
                    this.dialogVisible = false;
                    this.get();
                    this.clear();
                }
            });
        },
        /**
         * 发布
         */
        release(id) {
            CommentSubRelease({ id: id }).then((res) => {
                if (res) {
                    this.get();
                }
            });
        },
        /**
         * 清空
         */
        clear() {
            this.qq = "";
            this.name = "";
            this.email = "";
            this.avatar = "";
            this.content = "";
            this.thumb_num = 0;
            this.master = 2;
            this.created_at = Date.now();
        },
        /**
         * 检查输入
         */
        checkInput() {
            if (this.created_at === "") {
                message(1003, "参数为空或格式错误！");
                return false;
            }
            return true;
        },
        /**
         * qq详情
         */
        qqInfo() {
            if (!checkQQ(this.qq)) {
                this.qq = "";
                message(1003, "QQ参数格式错误！");
                return false;
            }
            qqInfo({ qq: this.qq }).then((res) => {
                if (res) {
                    const { email, nickName, avatar } = res.data;
                    this.email = email;
                    this.name = nickName == "" ? this.qq : nickName;
                    this.avatar = avatar;
                }
            });
        },
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
        },
        handleMaster() {
            this.master = this.master === 1 ? 2 : 1;
        },
        handleSelectionChange(data) {
            let ids = "";
            for (let i = 0; i < data.length; i++) {
                ids += `${data[i].id},`;
            }
            this.ids = ids.substring(0, ids.length - 1);
        },
        handleCurrentPage(start) {
            this.start = start;
            this.get();
        },
        handlePageSize(pageSize) {
            this.pageSize = pageSize;
            this.get();
        },
    },
    created() {
        this.get();
    },
};
</script>