import { Message } from 'element-ui';
// import store from "@/assets/vuex/store"
export function msg(params) {
    switch (params.code) {
        case 1:
            return true
        case 200:
            tip(params.msg, "success")
            return true;
        case 201:
            tip(params.msg, "warning")
            return false
        case 202:
            tip(params.msg, "error")
            return false
        case 204:
            tip(params.msg, "error")
            this.$router.push({
                path: "/"
            })
            return false

    }
}

function tip(text, type) {
    Message({
        showClose: true,
        message: text,
        type: type
    });
}