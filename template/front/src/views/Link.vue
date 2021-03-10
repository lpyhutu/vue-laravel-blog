<template>
    <div class="link">
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
                                <a-input v-model="form.name"  />
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
                                    action="https://www.mocky.io/v2/5cc8019d300000980a055e76"
                                    :before-upload="beforeUpload"
                                    @change="handleChange"
                                >
                                    <img
                                        v-if="imageUrl"
                                        :src="imageUrl"
                                        alt="avatar"
                                    />
                                    <div v-else>
                                        <a-icon
                                            :type="false ? 'loading' : 'plus'"
                                        />
                                        <div class="ant-upload-text">
                                            Upload
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
                        <div class="item" v-for="(item, key) in 20" :key="key">
                            <img src="../assets/img/logo.png" alt="" />
                            <span>糊涂个人博客</span>
                        </div>
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

export default {
    name: "Link",
    metaInfo: {
        title: "友情链接 - 分享技术，分享生活 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "网页，后台，技术，分享",
            },
            {
                name: "description",
                content:
                    "博客个人博客网站,一位编程爱好者的成长地。记录工作、生活中的点点滴滴,不定期更新分享，也希望能够认识更多的朋友。",
            },
        ],
    },
    components: { User, Ranking, HTLink, Title },
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
        };
    },
    methods: {
        beforeUpload(file) {
            console.log(file);
            this.$message.error("You can only upload JPG file!");
            return true;
        },
        handleChange() {
            console.log(1);
        },
        onSubmit() {
            this.$refs.ruleForm.validate((valid) => {
                if (valid) {
                    console.log(1);
                } else {
                    return false;
                }
            });
        },
    },
};
</script>


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

                padding: 5px 10px;
                img {
                    width: 30px;
                    height: 30px;
                }
                &:hover {
                    color: $bg-theme;
                }
            }
        }
    }
}
</style>
