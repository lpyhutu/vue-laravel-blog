<template>
    <div class="userpc-content">
        <div class="header ht-flex">
            <div v-if="releaseType === 0">
                <el-input
                    placeholder="标题"
                    size="small"
                    v-model="searchTitle"
                    @keyup.enter.native="search"
                ></el-input>
            </div>
            <div v-if="releaseType === 0" class="search" title="搜索">
                <el-button
                    icon="el-icon-search"
                    size="small"
                    type="success"
                    @click="search"
                ></el-button>
            </div>

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
            <div class="add" title="添加">
                <el-button
                    icon="el-icon-plus"
                    size="small"
                    type="info"
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
                    width="360"
                >
                    <template slot-scope="props">
                        <div class="table-title" :title="props.row.title">
                            {{ props.row.title }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="title"
                    label="封面"
                    align="center"
                    width="100"
                >
                    <template slot-scope="props">
                        <img
                            style="width: 60px; height: 60px"
                            :src="$api + props.row.cover_url"
                            alt=""
                        />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="title"
                    label="类别"
                    align="center"
                    width="150"
                >
                    <template slot-scope="props">
                        <el-tag size="small">
                            {{
                                props.row.front_type === null
                                    ? ""
                                    : props.row.front_type.title
                            }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="author" label="作者" align="center">
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="邮箱"
                    align="center"
                    width="200"
                >
                </el-table-column>
                <el-table-column prop="read_num" label="点击量" align="center">
                </el-table-column>
                <el-table-column prop="thumb_num" label="点赞" align="center">
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
                    width="170"
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
                    <div class="left">作者：</div>
                    <div class="right">
                        <el-input
                            v-model="author"
                            maxlength="30"
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
                    <div class="left">类别：</div>
                    <div class="right">
                        <el-select v-model="type" placeholder="请选择">
                            <el-option
                                v-for="item in typeList"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
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
                    <div class="left">封面：</div>
                    <div class="right ht-flex ht-col-center">
                        <el-upload
                            class="avatar-uploader"
                            :action="`${$api}api/common/uploadLogo`"
                            :show-file-list="false"
                            :on-success="handleAvatarSuccess"
                            :before-upload="beforeAvatarUpload"
                        >
                            <img
                                v-if="cover_url"
                                :src="$api + cover_url"
                                class="avatar"
                            />
                            <i
                                v-else
                                class="el-icon-plus avatar-uploader-icon"
                            ></i>
                        </el-upload>
                        <div style="padding-left: 10px">
                            <el-button
                                class="edit"
                                size="small"
                                icon="el-icon-picture-outline"
                                @click="handleCoverUrl"
                                >图库
                            </el-button>
                        </div>
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
                    <div class="left">阅读：</div>
                    <div class="right">
                        <el-input
                            type="number"
                            v-model="read_num"
                            min="0"
                            @keyup.enter.native="confirm"
                        ></el-input>
                    </div>
                </div>
                <div class="item">
                    <div class="left">点赞：</div>
                    <div class="right">
                        <el-input
                            type="number"
                            v-model="thumb_num"
                            min="0"
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
        <el-dialog
            :visible.sync="commentFlag"
            :modal="true"
            :show-close="false"
            :close-on-click-modal="false"
            :modal-append-to-body="false"
            :fullscreen="fullscreen"
            top="0"
            :custom-class="fullscreen ? '' : 'el-dialog-fullscreen'"
        >
            <div slot="title" class="el-dialog-header">
                <div class="title-left">评论</div>
                <div class="title-right">
                    <i
                        :title="fullscreen ? '最小化' : '最大化'"
                        class="iconfont icon-Batchfolding"
                        @click="fullscreen = !fullscreen"
                    ></i>
                    <i
                        title="关闭"
                        class="iconfont icon-close"
                        @click="commentFlag = false"
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
                <el-button size="small" @click="commentClear">重置</el-button>
                <el-button size="small" @click="comment" type="primary"
                    >确定</el-button
                >
            </div>
        </el-dialog>
        <el-dialog
            :visible.sync="isCover"
            :modal="true"
            :show-close="false"
            :close-on-click-modal="false"
            :modal-append-to-body="false"
            :fullscreen="fullscreen"
            top="0"
            :custom-class="fullscreen ? '' : 'el-dialog-fullscreen'"
        >
            <div slot="title" class="el-dialog-header">
                <div class="title-left">选择封面</div>
                <div class="title-right">
                    <i
                        :title="fullscreen ? '最小化' : '最大化'"
                        class="iconfont icon-Batchfolding"
                        @click="fullscreen = !fullscreen"
                    ></i>
                    <i
                        title="关闭"
                        class="iconfont icon-close"
                        @click="isCover = false"
                    ></i>
                </div>
            </div>
            <div class="dialog-contnet">
                <GalleryItem
                    @handleCover="handleCover"
                    ref="gallery"
                ></GalleryItem>
            </div>
            <div slot="footer">
                <el-button size="small" @click="isCover = false"
                    >取消</el-button
                >
                <el-button size="small" @click="isCover = false" type="primary"
                    >确定</el-button
                >
            </div>
        </el-dialog>
    </div>
</template>

<script>
import {
    ArticleGet,
    TypeGetRelease,
    ArticleAdd,
    ArticleEdit,
    ArticleDel,
    ArticleRelease,
    ArticleSearch,
    CommentAdd,
    qqInfo,
} from "@/assets/api/api";
import { SwitchDate } from "@/assets/js/formatTime";
import { message } from "@/assets/js/message";
import { checkQQ } from "@/assets/js/reg";
import { checkEmail } from "@/assets/js/reg";
import Editor from "@/components/Editor";
import GalleryItem from "@/components/GalleryItem";
export default {
    name: "ArticleList",
    data() {
        return {
            dialogVisible: false,
            fullscreen: false,
            loading: true,
            editFlag: false,
            commentFlag: false,
            editId: "",
            ids: "",
            data: [],
            start: 1,
            pageSize: 15,
            typeList: [],
            type: "",
            total: 0,
            title: "",
            author: "",
            email: "",
            content: "",
            read_num: 0,
            thumb_num: 0,
            searchTitle: "",
            sort: 100,
            created_at: Date.now(),
            editorFlag: false,
            qq: "",
            name: "",
            avatar: "",
            master: 2,
            article_id: 0,
            releaseType: 0,
            tableHeight: 0,
            isTableShow: true,
            cover_url: "",
            isCover: false,
        };
    },
    components: {
        Editor,
        GalleryItem,
    },
    methods: {
        handleGetType(releaseType) {
            this.releaseType = releaseType;
            this.handleGet();
        },
        handleGet() {
            if (this.searchTitle === "") {
                this.get();
            } else {
                this.search();
            }
        },
        /**
         * 搜索
         */
        search() {
            this.loading = true;
            ArticleSearch({
                title: this.searchTitle,
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
         * 获取
         */
        get() {
            this.searchTitle = "";
            this.loading = true;
            ArticleGet({
                release: this.releaseType,
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
         * 获取类别
         */
        TypeGetRelease() {
            TypeGetRelease().then((res) => {
                if (res) {
                    const { data } = res;
                    this.typeList = data;
                }
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
                return;
            }
            this.$msgBox
                .confirm("删除所选, 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning",
                })
                .then(() => {
                    ArticleDel({ id: id }).then((res) => {
                        if (res) {
                            this.handleGet();
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
            this.TypeGetRelease();
            this.dialogVisible = true;
            this.editFlag = false;
            this.clear();
        },
        /**
         * 添加
         */
        add() {
            ArticleAdd({
                title: this.title,
                author: this.author,
                email: this.email,
                type: this.type,
                content: this.$store.state.editorVal,
                cover_url: this.cover_url,
                read_num: this.read_num,
                thumb_num: this.thumb_num,
                sort: this.sort,
                created_at: parseInt(this.created_at / 1000),
            }).then((res) => {
                if (res) {
                    this.dialogVisible = false;
                    this.handleGet();
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
            if (this.author === "") {
                message(1003, "请输入作者名称！");
                return false;
            }
            if (this.email === "") {
                message(1003, "请输入邮箱账号！");
                return false;
            }
            if (!checkEmail(this.email)) {
                message(1003, "邮箱格式错误！");
                return false;
            }
            if (this.type === "") {
                message(1003, "请选择类别！");
                return false;
            }
            if (this.$store.state.editorVal === "") {
                message(1003, "请添加内容！");
                return false;
            }
            if (this.cover_url === "") {
                message(1003, "请上传封面！");
                return false;
            }

            this.read_num = this.read_num === "" ? 0 : this.read_num;
            this.thumb_num = this.thumb_num === "" ? 0 : this.thumb_num;
            this.created_at =
                this.created_at === "" ? Date.now() : this.created_at;
            if (this.sort < 0) {
                this.sort = 0;
            }
            if (this.sort > 100) {
                this.sort = 100;
            }
            return true;
        },
        /**
         * 编辑赋值
         */
        handleEdit(row) {
            this.TypeGetRelease();
            this.dialogVisible = true;
            this.editFlag = true;
            this.editId = row.id;
            this.title = row.title;
            this.author = row.author;
            this.email = row.email;
            this.cover_url = row.cover_url;
            this.type = row.front_type == null ? "" : row.front_type.id;
            this.$store.commit("setEditorVal", row.content);
            this.read_num = row.read_num;
            this.thumb_num = row.thumb_num;
            this.sort = row.sort;
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
            ArticleEdit({
                id: this.editId,
                title: this.title,
                author: this.author,
                email: this.email,
                type: this.type,
                cover_url: this.cover_url,
                content: this.$store.state.editorVal,
                read_num: this.read_num,
                thumb_num: this.thumb_num,
                sort: this.sort,
                created_at: parseInt(this.created_at / 1000),
            }).then((res) => {
                if (res) {
                    this.handleGet();
                    this.dialogVisible = false;
                }
            });
        },
        /**
         * 发布
         */
        release(id) {
            ArticleRelease({ id: id }).then((res) => {
                if (res) {
                    this.handleGet();
                }
            });
        },
        /**
         * 清空
         */
        clear() {
            this.title = "";
            this.author = "";
            this.email = "";
            this.type = "";
            this.$store.commit("setEditorVal", "");
            this.read_num = 0;
            this.thumb_num = 0;
            this.cover_url = "";
            this.sort = 100;
            this.created_at = Date.now();
        },
        /**
         * 评论
         */
        handleComment(id) {
            this.commentFlag = true;
            this.article_id = id;
        },
        comment() {
            CommentAdd({
                article_id: this.article_id,
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
                    this.commentFlag = false;
                    this.commentClear();
                }
            });
        },
        commentClear() {
            this.qq = "";
            this.name = "";
            this.email = "";
            this.avatar = "";
            this.content = "";
            this.thumb_num = 0;

            this.master = 1;
            this.created_at = Date.now();
        },
        handleMaster() {
            this.master = this.master === 1 ? 2 : 1;
        },
        /**
         * qq详情
         */
        qqInfo() {
            if (!checkQQ(this.qq)) {
                this.qq = "";
                message(1003, "QQ格式错误！");
                return false;
            }
            qqInfo({ qq: this.qq }).then((res) => {
                if (res) {
                    const { email, nickName, avatar } = res.data;
                    this.email = email;
                    this.name = nickName === "" ? this.qq : nickName;
                    this.avatar = avatar;
                }
            });
        },
        /**
         * 图片上传
         */
        beforeAvatarUpload(file) {
            const isJpgOrPng =
                file.type === "image/jpeg" ||
                file.type === "image/png" ||
                file.type === "image/jpg";
            if (!isJpgOrPng) {
                message(1003, "请上传jpeg/png/jpg类型图片.");
                return false;
            }
            const isLt2M = file.size / 1024 / 1024 < 1;
            if (!isLt2M) {
                message(1003, "图片大小必须小于1M.");
                return false;
            }
            return true;
        },
        handleAvatarSuccess(res) {
            if (res) {
                this.cover_url = res.data;
            }
        },
        /**
         * 选择封面
         */
        handleCover(img_url) {
            this.cover_url = img_url;
        },
        handleCoverUrl() {
            this.isCover = true;
            this.$nextTick(() => {
                this.$refs.gallery.get();
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
            this.handleGet();
        },
        handlePageSize(pageSize) {
            this.pageSize = pageSize;
            this.handleGet();
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
        // this.TypeGetRelease();
    },
    mounted() {
        this.handleTableShow();
    },
};
</script>
<style>
.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.avatar-uploader .el-upload:hover {
    border-color: #409eff;
}
.avatar-uploader-icon {
    font-size: 20px;
    color: #8c939d;
    width: 80px;
    height: 80px;
    line-height: 80px;
    text-align: center;
}
.avatar {
    width: 80px;
    height: 80px;
    display: block;
}
</style>