<template>
    <div class="userpc-content">
        <div class="header ht-flex">
            <div class="refresh" title="刷新">
                <el-button
                    icon="el-icon-refresh"
                    size="small"
                    type="primary"
                    @click="get"
                ></el-button>
            </div>
            <div class="delete" title="删除所选">
                <el-button
                    icon="el-icon-delete"
                    type="danger"
                    size="small"
                    @click="delAll"
                ></el-button>
            </div>
            <div class="add" title="添加">
                <el-button
                    icon="el-icon-plus"
                    type="info"
                    size="small"
                    @click="handleAdd"
                ></el-button>
            </div>
        </div>
        <div class="content" ref="tableHeight">
            <el-table
                :data="data"
                v-loading="loading"
                border
                :height="tableHeight"
                v-show="isTableShow"
                @selection-change="handleSelectionChange"
                @row-dblclick="handleEdit"
                style="width: 100%"
            >
                <el-table-column type="selection" fixed align="center">
                </el-table-column>
                <el-table-column type="index" label="#" align="center">
                </el-table-column>
                <el-table-column
                    prop="title"
                    label="标题"
                    align="center"
                    width="400"
                >
                    <template slot-scope="props">
                        <div :title="`翻译：${props.row.english}`">
                            {{ props.row.title }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="邮箱"
                    width="200"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="copyright"
                    label="版权信息"
                    width="400"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="record"
                    label="备案号"
                    width="200"
                    align="center"
                >
                    <template slot-scope="props">
                        <div class="table-link" :title="props.row.record_link">
                            <a :href="props.row.record_link" target="_blank">
                                {{ props.row.record }}</a
                            >
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="sort"
                    label="权重"
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
                    label="发布"
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
                    width="130"
                    align="center"
                >
                    <template slot-scope="scope">
                        <div class="header ht-flex ht-col-center ht-row-center">
                            <div class="edit" title="编辑">
                                <el-button
                                    icon="el-icon-edit"
                                    type="warning"
                                    size="mini"
                                    @click="handleEdit(scope.row)"
                                ></el-button>
                            </div>
                            <div class="delete" title="删除">
                                <el-button
                                    icon="el-icon-delete"
                                    type="danger"
                                    size="mini"
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
                <div class="title-left">{{ editFlag ? "编辑" : "添加" }}</div>
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
                    <div class="left">标题：</div>
                    <div class="right">
                        <el-input
                            v-model="title"
                            maxlength="100"
                            show-word-limit
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">翻译：</div>
                    <div class="right">
                        <el-input
                            v-model="english"
                            maxlength="200"
                            show-word-limit
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>

                <div class="item">
                    <div class="left">邮箱：</div>
                    <div class="right">
                        <el-input
                            v-model="email"
                            maxlength="40"
                            show-word-limit
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
                            v-model="$store.state.editorVal"
                            @keyup.enter.native="confirm"
                        ></el-input>
                        <el-button
                            class="edit"
                            size="small"
                            icon="el-icon-edit"
                            @click="editorFlag = true"
                            >编辑
                        </el-button>
                    </div>
                </div>
                <div class="item">
                    <div class="left">版权信息：</div>
                    <div class="right">
                        <el-input
                            v-model="copyright"
                            maxlength="70"
                            show-word-limit
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">备案号：</div>
                    <div class="right">
                        <el-input
                            v-model="record"
                            maxlength="20"
                            show-word-limit
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">备案链接：</div>
                    <div class="right">
                        <el-input
                            v-model="record_link"
                            maxlength="30"
                            show-word-limit
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">权重：</div>
                    <div class="right">
                        <el-input
                            type="number"
                            v-model="sort"
                            min="0"
                            max="127"
                            placeholder="升序(0~127之间)"
                            @keyup.enter.native="confirm"
                        ></el-input>
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
        <el-dialog
            :visible.sync="editorFlag"
            :modal="true"
            :show-close="false"
            :close-on-click-modal="false"
            :modal-append-to-body="false"
            :fullscreen="fullscreen"
            top="0"
            :custom-class="fullscreen ? '' : 'el-dialog-fullscreen'"
        >
            <div slot="title" class="el-dialog-header">
                <div class="title-left">文章编辑</div>
                <div class="title-right">
                    <i
                        :title="fullscreen ? '最小化' : '最大化'"
                        class="iconfont icon-Batchfolding"
                        @click="fullscreen = !fullscreen"
                    ></i>
                    <i
                        title="关闭"
                        class="iconfont icon-close"
                        @click="editorFlag = false"
                    ></i>
                </div>
            </div>
            <div class="dialog-contnet">
                <Editor></Editor>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import {
    InfoGet,
    InfoAdd,
    InfoEdit,
    InfoDel,
    InfoRelease,
} from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";
import Editor from "@/components/Editor";
import { checkEmail, checkWebsite } from "@/assets/js/reg";
export default {
    name: "InfoList",
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
            title: "",
            english: "",
            copyright: "",
            email: "",
            record: "",
            record_link: "",
            sort: 100,
            created_at: Date.now(),
            editorFlag: false,
            tableHeight: 0,
            isTableShow: true,
        };
    },
    components: {
        Editor,
    },
    methods: {
        /**
         * 获取
         */
        get() {
            this.loading = true;
            InfoGet({
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
            if (id === "") {
                message(1003, "请选择删除内容！");
                return false;
            }
            this.$msgBox
                .confirm("删除所选, 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning",
                })
                .then(() => {
                    InfoDel({ id: id }).then((res) => {
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
                return false;
            }
            if (this.editFlag) {
                this.edit();
            } else {
                this.add();
            }
        },
        /**
         * 添加编辑
         */
        handleAdd() {
            this.dialogVisible = true;
            this.editFlag = false;
            this.clear();
        },
        /**
         * 添加
         */
        add() {
            InfoAdd({
                title: this.title,
                english: this.english,
                copyright: this.copyright,
                email: this.email,
                record: this.record,
                record_link: this.record_link,
                content: this.$store.state.editorVal,
                sort: this.sort,
                created_at: parseInt(this.created_at / 1000),
            }).then((res) => {
                if (res) {
                    this.dialogVisible = false;
                    this.get();
                    this.clear();
                }
            });
        },
        /**
         * 检查输入
         */
        checkInput() {
            if (this.title === "") {
                message(1003, "请输入标题！");
                return false;
            }
            if (this.english === "") {
                message(1003, "请输入翻译！");
                return false;
            }
            if (this.email === "") {
                message(1003, "请输入邮箱！");
                return false;
            }
            if (!checkEmail(this.email)) {
                message(1003, "邮箱格式错误！");
                return false;
            }
            if (this.copyright === "") {
                message(1003, "请输入版权信息！");
                return false;
            }
            if (this.record === "") {
                message(1003, "请输入备案号！");
                return false;
            }
            if (this.record_link === "") {
                message(1003, "请输入备案链接！");
                return false;
            }
            if (!checkWebsite(this.record_link)) {
                message(1003, "备案链接格式错误！");
                return false;
            }

            return true;
        },
        /**
         * 编辑赋值
         */
        handleEdit(row) {
            this.dialogVisible = true;
            this.editFlag = true;
            this.title = row.title;
            this.english = row.english;
            this.copyright = row.copyright;
            this.email = row.email;
            this.record = row.record;
            this.record_link = row.record_link;
            this.$store.commit("setEditorVal", row.content);
            this.sort = row.sort;
            this.editId = row.id;
            this.created_at = Date.parse(new Date(row.created_at));
        },
        /**
         * 编辑
         */
        edit() {
            if (this.editId === "") {
                message(1003, "参数为空或格式错误！");
                return;
            }
            InfoEdit({
                id: this.editId,
                title: this.title,
                english: this.english,
                copyright: this.copyright,
                email: this.email,
                record: this.record,
                record_link: this.record_link,
                content: this.$store.state.editorVal,
                sort: this.sort,
                created_at: parseInt(this.created_at / 1000),
            }).then((res) => {
                if (res) {
                    this.get();
                    this.dialogVisible = false;
                }
            });
        },
        /**
         * 发布
         */
        release(id) {
            InfoRelease({ id: id }).then((res) => {
                if (res) {
                    this.get();
                }
            });
        },
        /**
         * 清空
         */
        clear() {
            this.title = "";
            this.english = "";
            this.copyright = "";
            this.email = "";
            this.record = "";
            this.record_link = "";
            this.$store.commit("setEditorVal", "");
            this.sort = 100;
            this.created_at = Date.now();
        },
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
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
        handleTableShow() {
            const that = this;
            this.$nextTick(() => {
                let heightStyle = that.$refs.tableHeight.offsetHeight;
                that.tableHeight = heightStyle;
            });
            window.onresize = () => {
                return (() => {
                    that.isTableShow = false;
                    setTimeout(() => {
                        let heightStyle = that.$refs.tableHeight.offsetHeight;
                        that.tableHeight = heightStyle;
                        that.isTableShow = true;
                    }, 100);
                })();
            };
        },
    },
    created() {
        this.get();
    },
    mounted() {
        this.handleTableShow();
    },
};
</script>