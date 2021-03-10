import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isHeader: true,
    isMenu: false,
    // isLamp: localStorage.getItem("isLamp") === null ? true : localStorage.getItem("isLamp") == "true" ? true : false,
    isSearch: false,
    navList: [{
        title: "首页",
        path: "/",
        icon: "home"
      },

      {
        title: "留言",
        path: "/message",
        icon: "message"
      },
      {
        title: "友链",
        path: "/link",
        icon: "link"
      },
      {
        title: "关于",
        path: "/about",
        icon: "user"
      },
    ],
  },
  mutations: {
    isHeader(state, val) {
      state.isHeader = val;
    },
    isMenu(state, val) {
      state.isMenu = val;
    },
    isSearch(state, val) {
      state.isSearch = val;
    },
  },
  actions: {},
  modules: {}
})