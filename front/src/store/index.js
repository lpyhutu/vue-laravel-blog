import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    navList: [{
        title: "首页",
        path: "/",
        icon: "home"
      },
      {
        title: "开发",
        path: "/experiment",
        icon: "appstore"
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
    isHeader: true,
    isMenu: false,
    isSearch: false,
    loadingText: "Loading",
    userInfo: {},
    linkList: [],
    visitsTime: window.localStorage.getItem("visitsTime"),
    siteTotal: {},
    online: 0,
    articleRanking: [],
    qq: "",
    email: "",
    avatar: "",
    name: "",
    discolorationName: window.localStorage.getItem("discolorationName"),

  },
  mutations: {
    //头部显示
    isHeader(state, val) {
      state.isHeader = val;
    },
    //导航栏
    isMenu(state, val) {
      state.isMenu = val;
    },
    // 搜索框
    isSearch(state, val) {
      state.isSearch = val;
    },
    // 加载提示
    loadingText(state, val) {
      state.loadingText = val;
    },
    // 用户信息
    userInfo(state, val) {
      state.userInfo = val;
    },
    // 链接列表
    linkList(state, val) {
      state.linkList = val;
    },
    // 访问时间
    visitsTime(state, val) {
      state.visitsTime = val;
      window.localStorage.setItem("visitsTime", val);
    },
    // 网站统计
    siteTotal(state, val) {
      state.siteTotal = val;
    },
    // 在线人数
    online(state, val) {
      state.online = val;
    },
    // 阅读排行
    articleRanking(state, val) {
      state.articleRanking = val;
    },
    // qq
    setQQ(state, val) {
      state.qq = val
    },
    // 邮箱
    setEmail(state, val) {
      state.email = val
    },
    // 头像
    setAvatar(state, val) {
      state.avatar = val
    },
    // 昵称
    setName(state, val) {
      state.name = val
    },
    // 变色方块用户名
    setDiscolorationName(state, val) {
      state.discolorationName = val
      window.localStorage.setItem("discolorationName", val);
    },
  },
  actions: {},
  modules: {}
})