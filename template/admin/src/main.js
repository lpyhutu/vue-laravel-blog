import Vue from 'vue'
import App from './App.vue'
import router from "./router"

// Vue.config.productionTip = false

import {
  MessageBox,
  Input,
  Container,
  Button,
  Menu,
  MenuItem,
  Submenu,
  MenuItemGroup,
  Table,
  // Aside,
  // Header,
  // Main,

  // Dropdown,
  // DropdownItem,
  // DropdownMenu,
  // TableColumn,
  // Drawer,
  // Tag,
  // Backtop,
  // Icon,
  // Divider,
  // Pagination,
  Dialog

} from 'element-ui';
Vue.use(Input);
Vue.use(Container);
Vue.use(Button);
Vue.use(Menu);
Vue.use(MenuItem)
Vue.use(Submenu);
Vue.use(MenuItemGroup);
Vue.use(Table);
// Vue.use(Aside);
// Vue.use(Header);
// Vue.use(Main);

// Vue.use(Dropdown);
// Vue.use(DropdownItem);
// Vue.use(DropdownMenu);
// Vue.use(TableColumn)
// Vue.use(Drawer);
// Vue.use(Tag);
// Vue.use(Backtop);
// Vue.use(Icon);
// Vue.use(Divider);
// Vue.use(Pagination);
Vue.use(Dialog);


Vue.prototype.$msgBox = MessageBox;
import {
  msg
} from "@/assets/js/message"
Vue.prototype.$msg = msg


router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    document.title = "糊涂个人博客|后台管理系统|" + to.meta.title;
  }
  next();
});


import "@/assets/scss/iconfont.scss";

Vue.prototype.$api = "http://localhost:88/chatroom/public/"

import store from "@/assets/vuex/store"
new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')