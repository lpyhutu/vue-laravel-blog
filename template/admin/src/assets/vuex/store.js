import Vue from "vue"
import Vuex from "vuex"
import { refreshToken } from "@/assets/api/api"

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        EmailTime: 0,
        Authorization: localStorage.getItem('Authorization'),
        emotionShowFlag: false
    },
    mutations: {
        setEmailTime(state, val) {
            state.EmailTime = val;
        },
        setAuthorization(state, token) {
            state.Authorization = token;
            localStorage.setItem('Authorization', token);
        },
        setEmotionShowFlag(state, val) {
            state.emotionShowFlag = val
        }
    },
    actions: {
        refreshToken() {
            return refreshToken()
        }
    }
})