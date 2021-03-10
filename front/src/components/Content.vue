<template>
    <div class="editor">
        <!-- <div class="markdown-body" v-html="handleText(text)" v-highlight></div> -->
        <mavon-editor
            :boxShadow="false"
            :toolbarsFlag="false"
            :navigation="false"
            defaultOpen="preview"
            :scrollStyle="true"
            :transition="false"
            :subfield="false"
            codeStyle="androidstudio"
            v-model="text"
            :ishljs="true"
            :imageClick="imageClick"
            ref="md"
            class="editor"
        />
        <a-modal
            title="图片预览"
            :footer="null"
            :visible="isShowImg"
            :confirm-loading="false"
            @ok="handleOk"
            @cancel="handleCancel"
        >
            <img class="modal-img" :src="img_url" alt="" />
        </a-modal>
        <!-- railscasts -->
    </div>
</template>

<script>
// import marked from "marked";
import { mavonEditor } from "mavon-editor";
export default {
    name: "Content",
    props: {
        text: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            isShowImg: false,
            img_url: "",
        };
    },
    components: {
        mavonEditor,
    },
    methods: {
        handleOk() {
            this.isShowImg = false;
        },
        handleCancel() {
            this.isShowImg = false;
        },
        imageClick(e) {
            this.img_url = e.src;
            this.isShowImg = true;
        },
        // handleText(val) {
        //     return marked(val);
        // },
        test() {
            var e = document.querySelectorAll("code");
            var e_len = e.length;
            var i;
            for (i = 0; i < e_len; i++) {
                e[i].innerHTML =
                    "<ul><li>" +
                    e[i].innerHTML.replace(/\n/g, "\n</li><li>") +
                    "\n</li></ul>";
            }
        },
    },
    mounted() {
        setTimeout(() => {
            this.test();
        }, 1500);
    },
    // created() {
    //     this.$nextTick(() => {
    //         this.test();
    //     });
    // },
};
</script>

<style>
.hljs ul {
    list-style: decimal !important;
    margin: 0 0 0 30px !important;
    padding: 0;
}
.hljs li {
    list-style: decimal-leading-zero !important;
    border-left: 1px solid #111 !important;
    padding: 2px 5px !important;
    margin: 0 !important;
    line-height: 14px;
    width: 100%;
    box-sizing: border-box !important;
}
.hljs li:nth-of-type(even) {
    background-color: rgba(255, 255, 255, 0.015);
    color: inherit;
}
pre {
    padding: 5px !important;
}
.v-note-show .single-show {
    z-index: 1 !important;
}
.v-note-wrapper .v-note-panel .v-note-show .v-show-content,
.v-note-wrapper .v-note-panel .v-note-show .v-show-content-html {
    padding: 5px !important;
    background: #fff !important;
    z-index: 1 !important;
}
.v-note-wrapper {
    border: none !important;
    z-index: 1 !important;
}
.markdown-body ol,
.markdown-body ul {
    padding-left: 0px !important;
    
}
</style>
<style lang="scss">
.modal-img {
    width: 100%;
    height: 50%;
    // height: 100px;
}
.editor {
    overflow: auto !important;
    font-size: 14px !important;
    line-height: 160% !important;
    code {
        white-space: pre-wrap;
        word-wrap: break-word;
        word-break: break-all;
        text-overflow: ellipsis;
        ul {
            li {
                white-space: pre-wrap;
                word-wrap: break-word;
                word-break: break-all;
                text-overflow: ellipsis;
            }
        }
    }
    img {
        max-width: 100%;
    }
}
</style>