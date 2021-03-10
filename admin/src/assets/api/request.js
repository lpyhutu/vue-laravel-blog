import axios from 'axios'
import {
    message
} from "@/assets/js/message"
import {
    refreshToken
} from "@/assets/api/api"
import router from "../../router/index"

// import store from "@/assets/vuex/store"

const http = axios.create({
    baseURL: "http://blog.com/api/",
    headers: {
        "Content-Type": "application/json",
    }
});
http.interceptors.request.use(
    config => {
        const authToken = localStorage.getItem("authToken");
        config.headers.Authorization = `bearer${authToken}`;
        return config;
    },
    error => {
        return Promise.reject(error);
    })

http.interceptors.response.use(
    res => {
        const authExpiresTime = localStorage.getItem("authExpiresTime");
        if (authExpiresTime !== null && Date.now() - authExpiresTime > 1000 * 60 * 60 * 5) {
            localStorage.setItem("authExpiresTime", Date.now())
            setTimeout(() => {
                refreshToken().then((res) => {
                    if (res) {
                        let {
                            token
                        } = res.data;
                        localStorage.setItem("authToken", token);
                    } else {
                        router.push({
                            path: "/"
                        })
                        localStorage.removeItem("authExpiresTime")
                        return false;
                    }

                })
            }, 1000)
        }
        const {
            code,
            msg
        } = res.data;
        if (!message(parseInt(code), msg)) {
            return false
        }
        return res.data
    },
    error => {
        return Promise.reject(error)
    }
)
export function request(url, params = {}, method = "post") {
    return new Promise((resolve, reject) => {
        http({
            url: url,
            method: method,
            data: params,
        }).then(res => {
            resolve(res);
        }).catch(err => {
            reject(err);
        });
    });
}

export default {
    request,
}