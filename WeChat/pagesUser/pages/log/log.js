// pagesUser/pages/log/log.js
import {
  logGet,
} from "../../../js/api/api"
import {
  SwitchYMD
} from "../../../js/formatTime"
Page({

  /**
   * 页面的初始数据
   */
  data: {
    isLoading: false,
    logList: [],
    total: 0,
    start: 1,
    pageSize: 15,
  },
  /**
   * 获取日志
   */
  logGet() {
    const {
      start,
      pageSize
    } = this.data;
    this.setData({
      isLoading: true
    })
    logGet(0, pageSize * start).then(res => {
      const {
        data,
        total
      } = res.data
      data.forEach(v => {
        v.created_at = SwitchYMD(Date.parse(new Date(v.created_at)) / 1000);
      });
      this.setData({
        isLoading: false,
        logList: data,
        total: total
      })
    })
  },
  /**
   * 加载更多
   */
  handleMore() {
    const {
      start,
      total,
      logList
    } = this.data;
    if (total > logList.length) {
      this.setData({
        start: start + 1
      })
      this.logGet()
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.logGet()
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