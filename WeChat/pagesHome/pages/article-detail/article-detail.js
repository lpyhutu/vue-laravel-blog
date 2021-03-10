const app = getApp();
import {
  articleDetail,
  articleThumb
} from "../../../js/api/api"
import {
  SwitchDate
} from "../../../js/formatTime"
Page({
  /**
   * 页面的初始数据
   */
  data: {
    detail: [],
    upArticle: {},
    downArticle: {},
    isLoading: true,
    id: 0,
    buttonText: [{
      text: '确定'
    }],
    isDialog: false
  },
  /**
   * 文章详情
   */
  articleDetail() {
    const {
      userInfo
    } = app.globalData;
    if (userInfo === null) {
      this.articleDetail()
      return;
    }
    this.setData({
      isLoading: true
    })
    articleDetail(this.data.id, userInfo.id).then(res => {
      const {
        code,
        data,
        upArticle,
        downArticle
      } = res.data
      if (code === 1) {
        data[0].created_at
        data.forEach(v => {
          v.created_at = SwitchDate(Date.parse(new Date(v.created_at)) / 1000);
        });
        this.setData({
          detail: data,
          isLoading: false,
          upArticle: upArticle,
          downArticle: downArticle
        })
      }
    })
  },
  /**
   * 文章点赞
   */
  articleThumb() {
    const uid = app.globalData.userInfo.id
    const {
      id
    } = this.data
    articleThumb(id, uid).then(res => {
      const {
        code
      } = res.data
      if (code === 1) {
        this.articleDetail(id)
      } else {
        wx.showToast({
          title: '一个就好！'
        })
      }
    })
  },
  /**
   * 上下篇
   */
  otherArticle(e) {
    const {
      id
    } = e.currentTarget.dataset
    this.setData({
      id: id
    })
    this.articleDetail()
  },
  /**
   * 提示
   */
  handleDialog() {
    this.setData({
      isDialog: false
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      id: options.id
    })
    this.articleDetail()
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

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

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})