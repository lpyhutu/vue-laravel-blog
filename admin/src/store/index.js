import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    editorVal: "",
    isMenu: false,

  },
  mutations: {
    setEditorVal(state, val) {
      state.editorVal = val
    },
    isMenu(state, val) {
      state.isMenu = val
    }
  },
  actions: {},
  modules: {}
})