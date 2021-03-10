<template>
    <div class="userpc-content">
        <div class="header ht-flex">
            <div class="refresh" title="刷新">
                <el-button
                    icon="el-icon-refresh"
                    type="primary"
                    size="small"
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
                    label="级别"
                    align="center"
                    width="150"
                >
                    <template slot-scope="props">
                        {{
                            props.row.power_title === null
                                ? ""
                                : props.row.power_title.title
                        }}
                    </template>
                </el-table-column>
                <el-table-column prop="rules" label="开放路由组" align="center">
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
                    <div class="left">级别：</div>
                    <div class="right">
                        <el-select v-model="power" placeholder="请选择">
                            <el-option
                                v-for="item in powerLevelList"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <div class="item">
                    <div class="left">API权限：</div>
                    <div class="right"></div>
                </div>
                <div class="item">
                    <div class="left"></div>
                    <div class="right">
                        <el-tree
                            :data="routerList"
                            :props="defaultProps"
                            show-checkbox
                            ref="tree"
                            node-key="id"
                        >
                            <span
                                class="custom-tree-node"
                                slot-scope="{ node, data }"
                            >
                                <span>{{ node.label }}</span>
                                <span style="padding-left:15px">{{
                                    data.remarks === "0" ? "" : data.remarks
                                }}</span>
                            </span>
                        </el-tree>
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
    PowerGet,
    PowerAdd,
    PowerEdit,
    PowerDel,
    PowerRelease,
    PowerLevelGetRelease,
    RouterGet,
} from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";

export default {
    name: "TypeArticleList",
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
            power: "",
            powerLevelList: [],
            created_at: Date.now(),
            tableHeight: 0,
            isTableShow: true,
            routerList: [],
            rules: [],
            defaultProps: {
                label: "api",
            },
        };
    },
    methods: {
        /**
         * 获取
         */
        get() {
            this.loading = true;
            PowerGet({
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
                    PowerDel({ id: id }).then((res) => {
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
            PowerAdd({
                power: this.power,
                rules: this.rules,
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
         * 获取级别
         */
        PowerLevelGetRelease() {
            PowerLevelGetRelease().then((res) => {
                if (res) {
                    const { data } = res;
                    this.powerLevelList = data;
                }
            });
        },
        /**
         * 检查输入
         */
        checkInput() {
            if (this.power === "") {
                message(1003, "请选择级别！");
                return false;
            }
            this.rules = this.$refs.tree.getCheckedNodes();
            if (this.rules.length === 0) {
                message(1003, "请选择开放的API！");
                return false;
            }
            let ids = [];
            this.rules.forEach((v) => {
                ids.push(v.id);
            });
            this.rules = ids.toString();
            return true;
        },
        /**
         * 编辑赋值
         */
        handleEdit(row) {
            this.dialogVisible = true;
            this.editFlag = true;
            this.power = row.power;
            this.rules = row.rules.split(",");
            this.editId = row.id;
            this.$nextTick(() => {
                this.$refs.tree.setCheckedKeys(this.rules);
            });
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
            PowerEdit({
                id: this.editId,
                power: this.power,
                rules: this.rules,
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
            PowerRelease({ id: id }).then((res) => {
                if (res) {
                    this.get();
                }
            });
        },
        /**
         * 获取
         */
        RouterGet() {
            RouterGet({
                start: 0,
                pageSize: 0,
            }).then((res) => {
                if (res) {
                    const { data } = res;
                    this.routerList = data;
                }
            });
        },
        /**
         * 清空
         */
        clear() {
            this.power = "";
            this.rules = "";
            this.created_at = Date.now();
            this.$nextTick(() => {
                this.$refs.tree.setCheckedKeys([]);
            });
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
        this.PowerLevelGetRelease();
        this.RouterGet();
    },
    mounted() {
        this.handleTableShow();
    },
};
</script>