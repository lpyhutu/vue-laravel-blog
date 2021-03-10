import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import "@/assets/scss/common.scss";
import "@/assets/scss/theme.scss";


import MetaInfo from 'vue-meta-info'
Vue.use(MetaInfo)

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
  List
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

Vue.prototype.$message = message

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')