// pages/home/home.js
const app = getApp();
import {
  articleGet,
} from "../../js/api/api"

Page({

  /**
   * 页面的初始数据
   */
  data: {
    start: 1,
    pageSize: 15,
    articleList: [],
    total: 0,
    articleSwiper: [],
    isLoading: true,
    isBackTop: false,
  },

  /**
   * 获取文章
   */
  articleGet() {
    this.setData({
      isLoading: true
    })
    const {
      start,
      pageSize
    } = this.data;
    articleGet(0, pageSize * start).then(res => {
      const {
        code,
        data,
        total,
        readingRanking
      } = res.data;
      if (code === 1) {
        data.forEach((k, v) => {
          if (k.img_url === "0") {
            k.img_url = ["https://api.lpyhutu.cn/HtBlog/public/upload/img/article.png"]
          } else {
            k.img_url = JSON.parse(k.img_url)
          }
        })
        readingRanking.forEach((k, v) => {
          if (k.img_url === "0") {
            k.img_url = ["https://api.lpyhutu.cn/HtBlog/public/upload/img/article.png"]
          } else {
            k.img_url = JSON.parse(k.img_url)
          }
        })
        getApp().globalData.articleTotal = total
        this.setData({
          articleList: data,
          total: total,
          articleSwiper: readingRanking,
          isLoading: false
        })
      } else {
        getApp().globalData.articleTotal = 0
        this.setData({
          articleList: [],
          total: 0,
          articleSwiper: [],
          isLoading: false
        })
      }
    })
  },
  /**
   * 加载更多
   */
  handleMore() {
    const {
      start,
      total,
      articleList
    } = this.data;
    if (total > articleList.length) {
      this.setData({
        start: start + 1
      })
      this.articleGet()
    }
  },
  jumpDetail(e) {
    wx.navigateTo({
      url: `/pagesHome/pages/article-detail/article-detail?id=${e.currentTarget.dataset.id}`
    })
  },
  /**
   * 搜索
   */
  jumpSearch() {
    wx.navigateTo({
      url: `/pagesSort/pages/search/search`
    })
  },
  onPageScroll(e) {
    if (e.scrollTop > 1000) {
      this.setData({
        isBackTop: true
      })
    } else {
      this.setData({
        isBackTop: false
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    this.articleGet()
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
    app.login()
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
    this.handleMore()
  },
  onPullDownRefresh: function () {
    this.articleGet()
    wx.stopPullDownRefresh()
  },
  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    // console.log(111)
  }
})