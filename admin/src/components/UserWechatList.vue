<template>
    <div class="userpc-content">
        <div class="header">
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
                    prop="openid"
                    label="openid"
                    align="center"
                    width="300"
                >
                </el-table-column>
                <el-table-column
                    prop="avatar_url"
                    label="头像"
                    width="70"
                    align="center"
                >
                    <template slot-scope="scope">
                        <img
                            style="height: 35px"
                            :src="scope.row.avatar_url"
                            alt=""
                        />
                    </template>
                </el-table-column>

                <el-table-column
                    prop="nick_name"
                    label="昵称"
                    width="100"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="visits_num"
                    label="访问次数"
                    width="100"
                    align="center"
                >
                </el-table-column>
                <el-table-column prop="gender" label="性别" align="center">
                    <template slot-scope="props">
                        <el-tag
                            size="small"
                            :type="
                                props.row.gender == '0'
                                    ? 'info'
                                    : props.row.gender == '1'
                                    ? 'success'
                                    : 'danger'
                            "
                        >
                            {{
                                props.row.gender == "0"
                                    ? "未知"
                                    : props.row.gender == "1"
                                    ? "男"
                                    : "女"
                            }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="visits_time"
                    label="浏览时长"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="created_at"
                    label="上次登陆时间"
                    width="180"
                    align="center"
                >
                    <template slot-scope="props">
                        {{ SwitchDate(props.row.last_at) }}
                    </template>
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
                    width="100"
                    align="center"
                >
                    <template slot-scope="scope">
                        <div class="header ht-flex ht-col-center ht-row-center">
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
    </div>
</template>

<script>
import { WeChatUserGet, WeChatUseDel } from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";

export default {
    name: "TypeList",
    data() {
        return {
            loading: true,
            editId: "",
            ids: "",
            data: [],
            start: 1,
            pageSize: 15,
            total: 0,
            tableHeight: 100,
            isTableShow: true,
        };
    },
    methods: {
        /**
         * 获取
         */
        get() {
            this.loading = true;
            WeChatUserGet({
                start: (this.start - 1) * this.pageSize,
                pageSize: this.pageSize,
            }).then((res) => {
                if (res) {
                    const { data, total } = res;
                    this.data = data;
                    this.total = total;
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
                        message(2, "请选择删除内容！");
                        return;
                    }
                    WeChatUseDel({ id: id }).then((res) => {
                        if (res) {
                            this.get();
                        }
                    });
                })
                .catch(() => {});
        },

        // /**
        //  * 黑名单
        //  */
        // release(id) {
        //     UseRelease({ id: id }).then((res) => {
        //         if (res) {
        //             this.get();
        //         }
        //     });
        // },
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
        },
        SwitchDate(time) {
            return SwitchDate(time);
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