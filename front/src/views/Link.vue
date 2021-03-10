<template>
    <div class="link">
        <Loading v-show="isLoading" :tip="'loading'"></Loading>

        <div class="app-content">
            <div class="app-left">
                <div class="content">
                    <Title :title="'温馨提示'"></Title>
                    <div class="tip">
                        <p>
                            1、本站欢迎交换友链，如果想和本站交换友情链接的，欢迎在此申请；
                        </p>
                        <p>2、网站内容健康积极向上，对网站收录量无要求；</p>
                        <p>3、审核结果均以邮件形式通知，请输入常用有效邮箱；</p>
                        <p>
                            4、若无意外，在申请友链后24小时内完成审核并录入站点，如超时还未审核完成，请留言或者私信给我。
                        </p>
                    </div>
                    <div class="apply">
                        <a-form-model
                            ref="ruleForm"
                            :model="form"
                            :rules="rules"
                            :label-col="labelCol"
                            :wrapper-col="wrapperCol"
                        >
                            <a-form-model-item
                                ref="name"
                                label="站点名称"
                                prop="name"
                            >
                                <a-input v-model="form.name" />
                            </a-form-model-item>
                            <a-form-model-item label="站点地址" prop="address">
                                <a-input v-model="form.address" />
                            </a-form-model-item>
                            <a-form-model-item label="联系邮箱" prop="email">
                                <a-input v-model="form.email" />
                            </a-form-model-item>
                            <a-form-model-item label="网站头像">
                                <a-upload
                                    name="avatar"
                                    list-type="picture-card"
                                    class="avatar-uploader"
                                    :show-upload-list="false"
                                    action="http://blog.com/api/common/uploadLogo"
                                    :before-upload="beforeUpload"
                                >
                                    <img
                                        v-if="imageUrl"
                                        :src="imageUrl"
                                        alt="avatar"
                                    />
                                    <div v-else>
                                        <a-icon
                                            :type="
                                                isUpload ? 'loading' : 'plus'
                                            "
                                        />
                                        <div class="ant-upload-text">
                                            1M以内
                                        </div>
                                    </div>
                                </a-upload>
                            </a-form-model-item>
                            <div class="ht-flex ht-row-right">
                                <a-button
                                    type="primary"
                                    icon="form"
                                    @click="onSubmit"
                                    >申请
                                </a-button>
                            </div>
                        </a-form-model>
                    </div>
                    <Title
                        :title="'链接列表'"
                        style="margin: 30px 0 10px"
                    ></Title>
                    <div class="list ht-flex ht-wrap">
                        <a
                            :href="item.site"
                            target="_blank"
                            class="item ht-flex ht-col-center"
                            v-for="(item, key) in $store.state.linkList"
                            :key="key"
                        >
                            <img :src="handleImg(item.img_url)" alt="" />
                            <span>{{ item.title }}</span>
                        </a>
                    </div>
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
import Loading from "@/components/Loading";

import { Message } from "@/assets/js/message";
import { upload, linkApply, linkGet } from "@/assets/api/api";

export default {
    name: "Link",
    metaInfo: {
        title: "友情链接 - 网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "友链,前端,后端,小程序,博客",
            },
            {
                name: "description",
                content:
                    "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
            },
        ],
    },
    components: { User, Ranking, HTLink, Title, Loading },
    data() {
        return {
            labelCol: { span: 3 },
            wrapperCol: { span: 8 },
            form: {
                name: undefined,
                address: undefined,
                email: undefined,
            },
            rules: {
                name: [
                    {
                        required: true,
                        message: "请输入站点名称",
                        trigger: "blur",
                    },
                    {
                        min: 1,
                        max: 30,
                        message: "长度请保持在1-30之间",
                        trigger: "blur",
                    },
                    // {
                    //     validator(rule, value) {
                    //         // console.log(rule, value);
                    //         // return true;
                    //         return value === "test";
                    //     },
                    //     message: 'Value is not equal to "test".',
                    // },
                ],
                address: [
                    {
                        required: true,
                        message: "请输入站点地址",
                        trigger: "blur",
                    },
                    {
                        min: 1,
                        max: 70,
                        message: "长度请保持在1-70之间",
                        trigger: "blur",
                    },
                    {
                        validator(rule, value) {
                            let reg = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w.-]+)+[\w\-._~:/?#[\]@!$&'*+,;=.]+$/;
                            if (reg.test(value)) {
                                return true;
                            }
                            return false;
                        },
                        message: "地址格式错误",
                    },
                ],
                email: [
                    {
                        required: true,
                        message: "请输入联系邮箱",
                        trigger: "blur",
                    },
                    {
                        type: "email",
                        message: "邮箱格式错误",
                        trigger: "blur",
                    },
                    {
                        min: 1,
                        max: 40,
                        message: "长度请保持在1-40之间",
                        trigger: "blur",
                    },
                ],
            },
            imageUrl: "",
            img_url: "",
            isUpload: false,
        };
    },
    methods: {
        /**
         * 上传图片
         */
        beforeUpload(file) {
            const isJpgOrPng =
                file.type === "image/jpeg" ||
                file.type === "image/png" ||
                file.type === "image/jpg";
            if (!isJpgOrPng) {
                Message(1003, "请上传jpeg/png/jpg类型图片.");
                return false;
            }
            const isLt2M = file.size / 1024 / 1024 < 1;
            if (!isLt2M) {
                Message(1003, "图片大小必须小于1M.");
                return false;
            }
            this.isUpload = true;
            let formdata = new FormData();
            formdata.append("file", file);
            upload(formdata).then((res) => {
                if (res) {
                    this.img_url = res.data;
                    this.imageUrl = this.$assets + res.data;
                    this.isUpload = false;
                    Message(1000, "上传成功.");
                }
            });
            return false;
        },

        /**
         * 提交
         */
        onSubmit() {
            if (this.img_url === "") {
                Message(1003, "请上传头像.");
                return false;
            }
            this.$refs.ruleForm.validate((valid) => {
                if (valid) {
                    this.linkApply();
                } else {
                    return false;
                }
            });
        },
        /**
         * 申请
         */
        linkApply() {
            const { name, address, email } = this.form;
            linkApply(this.img_url, name, address, email).then((res) => {
                if (res) {
                    this.form.name = "";
                    this.form.address = "";
                    this.form.email = "";
                    this.imageUrl = "";
                    this.img_url = "";
                    Message(1000, "申请成功，等待审核.");
                }
            });
        },
        handleImg(url) {
            if (url === "0") {
                return require("../assets/img/null.png");
            } else {
                return this.$assets + url;
            }
        },
        /**
         * 链接列表
         */
        linkGet() {
            this.isLoading = true;
            linkGet().then((res) => {
                if (res) {
                    this.$store.commit("linkList", res.data);
                }
                this.isLoading = false;
            });
        },
    },
    created() {
        this.linkGet();
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    },
};
</script>

<style lang="scss">
.avatar-uploader > .ant-upload {
    width: 80px;
    height: 80px;
}
.ant-upload-select-picture-card i {
    font-size: 20px;
    color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
    margin-top: 8px;
    color: #666;
}
.ant-upload {
    font-size: 12px;
    img {
        height: 80px;
        width: 80px;
    }
}
</style>
<style lang="scss" scoped>
.link {
    .content {
        padding: 20px;
        background: $bg-white;
        .tip {
            padding: 10px 0;
        }
        .list {
            .item {
                cursor: pointer;
                color: #000000a6;
                padding: 5px 10px;
                img {
                    width: 25px;
                    height: 25px;
                }
                span {
                    padding-left: 5px;
                }
                &:hover {
                    color: $bg-theme;
                }
            }
        }
    }
}
</style>
