// components/ht-article-list/article-list.js
Component({

  options: {
    addGlobalClass: true
  },

  /**
   * 组件的属性列表
   */
  properties: {
    isSort: {
      type: Boolean,
      default: false
    },
    list: {
      type: Array,
      default: []
    }
  },

  /**
   * 组件的初始数据
   */
  data: {},

  /**
   * 组件的方法列表
   */

  methods: {
    jumpDetail(e) {
      wx.navigateTo({
        url: `/pagesHome/pages/article-detail/article-detail?id=${e.currentTarget.dataset.id}`
      })
    },
  },
  created() {}
})