import {
    message
} from 'ant-design-vue';
import store from '../../store/index';
export function Message(code, text, data) {
    store.commit("loadingText", `Loading`);
    switch (code) {
        case 1:
            return true;
        case 1000:
            message.success(text);
            return true;
        case 1001:
            return true;
        case 1002:
            message.info(text);
            return false;
        case 1003:
            message.warning(text);
            return false;
        case 1004:
            message.error(text);
            return false;
        case 1009:
            store.commit("loadingText", true);
            store.commit("loadingText", text);
            return false;
        case 1010:
            store.commit("loadingText", true);
            store.commit("loadingText", `异常频繁请求，请于${data}秒后重试！`);
            return false;
    }
}