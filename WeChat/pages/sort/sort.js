const app = getApp();
import {
  typeGet,
  currentTypeArticleGet
} from "../../js/api/api"
Page({

  /**
   * 页面的初始数据
   */
  data: {
    title: "",
    menuIndex: 0,
    typeList: [],
    articleList: [],
    isLoading: true
  },
  /**
   * 获取类别
   */
  typeGet() {
    this.setData({
      isLoading: true
    })
    typeGet().then(res => {
      const {
        code,
        data
      } = res.data
      if (code === 1) {
        this.setData({
          typeList: data,
          isLoading: false,
          menuIndex: data[0].id
        })
        this.currentTypeArticleGet(data[0].id)
      }
    })
  },
  /**
   * 当前类别文章
   */
  currentTypeArticleGet(type) {
    currentTypeArticleGet(type).then(res => {
      const {
        code,
        data
      } = res.data
      if (code === 1) {
        this.setData({
          articleList: data,
        })
      }
    })
  },
  handleCurrentIndex(e) {
    const {
      type
    } = e.currentTarget.dataset
    this.setData({
      menuIndex: type
    })
    this.currentTypeArticleGet(type)
  },
  /**
   * 搜索
   */
  jumpSearch() {
    wx.navigateTo({
      url: `/pagesSort/pages/search/search`
    })
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.typeGet()
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {},

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    console.log(11)
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})