import {
  articleSearch
} from "../../../js/api/api"
Page({

  /**
   * 页面的初始数据
   */
  data: {
    title: "",
    isLoading: false,
    start: 1,
    pageSize: 15,
    articleList: [],
    total: 0,
    isBackTop: false,
  },
  /**
   * 获取搜索内容
   */
  handleSearch(e) {
    const {
      value
    } = e.detail
    if (value !== "") {
      this.setData({
        title: value
      })
      setTimeout(() => {
        this.articleSearch()
      }, 500);
    }

  },
  /**
   * 文章搜索
   */
  articleSearch() {
    this.setData({
      isLoading: true
    })
    const {
      title,
      start,
      pageSize
    } = this.data
    articleSearch(title, 0, start * pageSize).then(res => {
      const {
        code,
        total,
        data
      } = res.data
      if (code === 1) {
        data.forEach((k, v) => {
          if (k.img_url === "0") {
            k.img_url = ["https://api.lpyhutu.cn/HtBlog/public/upload/img/article.png"]
          } else {
            k.img_url = JSON.parse(k.img_url)
          }
        })
        this.setData({
          articleList: data,
          total: total,
          isLoading: false
        })
      } else {
        this.setData({
          articleList: [],
          total: 0,
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
      this.articleSearch()
    }
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
    this.handleMore()
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})