<template>
    <div class="gallery-list">
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
            <el-upload
                class="avatar-uploader"
                ref="upload"
                :action="`${$api}api/common/uploadLogo`"
                :show-file-list="false"
                :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload"
            >
                <el-button
                    size="small"
                    icon="el-icon-plus"
                    type="info"
                    @click="submitUpload"
                ></el-button>
            </el-upload>
        </div>
        <div class="content" ref="tableHeight">
            <el-table
                :data="data"
                border
                v-loading="loading"
                :height="tableHeight"
                v-show="isTableShow"
                @selection-change="handleSelectionChange"
                style="width: 100%"
            >
                <el-table-column type="selection" fixed align="center">
                </el-table-column>
                <el-table-column type="index" label="#" align="center">
                </el-table-column>
                <el-table-column prop="title" label="图片" align="center">
                    <template slot-scope="props">
                        <img
                            style="width: 60px; height: 60px"
                            :src="$api + props.row.img_url"
                            alt=""
                        />
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
                            <!-- <div class="edit" title="编辑">
                                <el-button
                                    icon="el-icon-edit"
                                    type="warning"
                                    size="mini"
                                    @click="handleEdit(scope.row)"
                                ></el-button>
                            </div> -->
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
import { GalleryGet, GalleryDel } from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";

export default {
    name: "GalleryList",
    data() {
        return {
            loading: true,
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
            GalleryGet({
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
                    GalleryDel({ id: id }).then((res) => {
                        if (res) {
                            this.get();
                        }
                    });
                })
                .catch(() => {});
        },
        /**
         * 图片上传
         */
        submitUpload() {
            this.$refs.upload.submit();
        },
        beforeAvatarUpload(file) {
            const isJpgOrPng =
                file.type === "image/jpeg" ||
                file.type === "image/png" ||
                file.type === "image/jpg";
            if (!isJpgOrPng) {
                message(1003, "请上传jpeg/png/jpg类型图片.");
                return false;
            }
            const isLt2M = file.size / 1024 / 1024 < 3;
            if (!isLt2M) {
                message(1003, "图片大小必须小于3M.");
                return false;
            }
            return true;
        },
        handleAvatarSuccess(res) {
            if (res) {
                this.get();
            }
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