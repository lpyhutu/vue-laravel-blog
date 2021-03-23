import Vue from 'vue'

import bus from "@/assets/bus/bus"
Vue.prototype.$bus = bus;

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

import mavonEditor from "mavon-editor";
Vue.use(mavonEditor)

Vue.prototype.$host = "https://www.lpya.cn"


Vue.prototype.$assets = "http://blog.com/"
