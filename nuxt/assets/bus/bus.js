import Vue from 'vue';
const bus = new Vue();
export default bus;
Vue.prototype.$bus = bus;

Vue.prototype.$host = "https://www.lpya.cn"
// Vue.prototype.$assets = "http://blog.com/"
Vue.prototype.$assets = "https://api.lpya.cn/HtBlog/public/"
