import axios from 'axios'
// import store from "@/assets/vuex/store"
// import { msg } from "@/assets/js/message"


const http = axios.create({
    baseURL: "http://localhost:88/chatroom/public/api/",
    timeout: 10000,
    headers: {
        "Content-Type": "application/json",
    }
});
http.interceptors.request.use(
    config => {
        if (localStorage.getItem('Authorization')) {
            config.headers.Authorization = localStorage.getItem('Authorization');
        }
        //刷新token

        return config;
    },
    error => {
        return Promise.reject(error);
    })

http.interceptors.response.use(
    response => {
        // let tokenExpireTime = localStorage.getItem("tokenExpireTime")
        // if (tokenExpireTime != null && Date.now() - tokenExpireTime > 1000 * 60 * 30) {
        //     localStorage.setItem("tokenExpireTime", Date.now());
        //     store.dispatch('refreshToken').then(res => {
        //         const { token_type, access_token } = res.data.data;
        //         if (msg(res.data)) {
        //             store.commit(
        //                 "setAuthorization",
        //                 token_type + access_token
        //             );
        //             localStorage.setItem("tokenExpireTime", Date.now());
        //         }
        //     })
        // }
        return response
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

