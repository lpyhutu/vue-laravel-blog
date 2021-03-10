import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import "@/assets/scss/common.scss";
import "@/assets/scss/theme.scss";

import bus from "@/assets/bus/bus"
Vue.prototype.$bus = bus;

import MetaInfo from 'vue-meta-info'
Vue.use(MetaInfo)
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)


Vue.prototype.$host = "https://www.lpyhutu.cn"

Vue.prototype.$assets = "http://blog.com/"

import 'ant-design-vue/dist/antd.css';
import {
  Button,
  Input,
  Icon,
  BackTop,
  Drawer,
  Switch,
  FormModel,
  Upload,
  message,
  Popover,
  Comment,
  Avatar,
  List,
  Modal,
  Popconfirm
} from 'ant-design-vue';
Vue.use(Button)
Vue.use(Input)
Vue.use(Icon)
Vue.use(BackTop)
Vue.use(Switch)
Vue.use(Drawer)
Vue.use(FormModel)
Vue.use(Upload)
Vue.use(Popover)
Vue.use(Comment)
Vue.use(Avatar)
Vue.use(List)
Vue.use(Modal)
Vue.use(Popconfirm)

Vue.prototype.$message = message

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App),
  mounted() {
    document.dispatchEvent(new Event('render-event'))
  }
}).$mount('#app')