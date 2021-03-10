<template>
    <div class="editor">
        <mavon-editor
            :boxShadow="false"
            v-model="$store.state.editorVal"
            @imgAdd="imgAdd"
            codeStyle="androidstudio"
            ref="md"
            class="editor"
        />
    </div>
</template>

<script>
import { mavonEditor } from "mavon-editor";
import "mavon-editor/dist/css/index.css";

import { upload } from "@/assets/api/api";
export default {
    name: "Editor",
    data() {
        return {
            content: "",
        };
    },
    components: {
        mavonEditor,
    },
    methods: {
        imgAdd(pos, $file) {
            let formdata = new FormData();
            formdata.append("file", $file);
            upload(formdata).then((res) => {
                if (res) {
                    this.$refs.md.$img2Url(pos, res.data);
                }
            });
        },
        // imgDel(pos) {
        //     console.log(pos);
        //     // delFile({ filename: this.splitUrl(pos[0]) });
        // },
        splitUrl(str) {
            let arr = str.split(this.$api);
            return arr[1];
        },
    },
};
</script>

<style lang="scss" scoped>
.markdown-body {
    height: 100vh !important;
}
.editor {
    a {
        text-decoration: none !important;
    }
    pre {
        color: #d1d2d2;
    }
    .hljs {
        background: rgb(40, 48, 40) !important;
    }
}
</style>