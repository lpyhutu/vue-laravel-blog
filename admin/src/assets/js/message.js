import {
    Message
} from 'element-ui';
import router from "../../router/index"

export function message(code, text) {
    switch (code) {
        case 1:
            return true;
        case 1001:
            tip(text, "success")
            return true;
        case 1002:
            tip(text, "info");
            return true;
        case 1003:
            tip(text, "warning");
            return false;
        case 1004:
            tip(text, "error");
            return false;
        case 1005:
            tip(text, "warning");
            return false;
        case 1006:
            router.push({
                path: "/"
            })
            tip(text, "warning");
            return false;
        case 1007:
            router.push({
                path: "/"
            })
            tip(text, "warning");
            return false;
        case 1008:
            return true;
    }
}

function tip(text, type) {
    Message({
        showClose: true,
        message: text,
        type: type
    });
}