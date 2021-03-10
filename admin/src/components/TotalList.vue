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
        </div>
        <div class="content" ref="tableHeight">
            <el-table
                :data="data"
                v-loading="loading"
                border
                :height="tableHeight"
                v-show="isTableShow"
                @selection-change="handleSelectionChange"
                style="width: 100%"
            >
                <el-table-column type="selection" fixed align="center">
                </el-table-column>
                <el-table-column type="index" label="#" align="center">
                </el-table-column>
                <el-table-column
                    prop="visitors_num"
                    label="访客量"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="visits_num"
                    label="访问量"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="visits_time"
                    label="浏览时长"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="article_num"
                    label="文章数量"
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
                    fixed="right"
                    label="操作"
                    width="130"
                    align="center"
                >
                    <template slot-scope="scope">
                        <div class="header ht-flex ht-col-center ht-row-center">
                            <!-- <div class="edit" title="编辑">
                                <el-button
                                    icon="el-icon-edit"
                                    size="mini"
                                    @click="handleEdit(scope.row)"
                                ></el-button>
                            </div> -->
                            <div class="delete" title="删除">
                                <el-button
                                    icon="el-icon-delete"
                                    type="danger"
                                    size="mini"
                                    @click="del(scope.row.id)"
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
    </div>
</template>

<script>
import { TotalGet, TotalDel } from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";

export default {
    name: "TypeList",
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
            sort: 100,
            created_at: Date.now(),
            tableHeight: 0,
            isTableShow: true,
        };
    },
    methods: {
        /**
         * 获取
         */
        get() {
            this.loading = true;
            TotalGet({
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
                    TotalDel({ id: id }).then((res) => {
                        if (res) {
                            this.get();
                        }
                    });
                })
                .catch(() => {});
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