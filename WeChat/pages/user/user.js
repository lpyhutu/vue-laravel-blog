// pages/user/user.jsn
const app = getApp();
import {
  UserRegister
} from "../../js/api/api"
import {
  SwitchDate,
  runningTime
} from "../../js/formatTime"
Page({

  /**
   * 页面的初始数据
   */
  data: {
    list: [{
      icon: "icon-github-fill ",
      title: "GitHub",
      path: ""
    }, {
      icon: "icon-detail icon-color-1",
      title: "更新日志",
      path: false
    }, {
      icon: "icon-edit-fill icon-color-2",
      title: "意见反馈",
      path: false
    }],
    isRegister: false,
    userInfo: {},
    articleTotal: 0,
    run_at: 0
  },
  /**
   * 用户信息注册
   */
  register() {
    const _this = this;
    const {
      id
    } = app.globalData.userInfo;
    const openid_code = app.globalData.code;
    wx.getUserInfo({
      success: function (e) {
        const {
          nickName,
          avatarUrl,
          gender
        } = e.userInfo
        UserRegister(id, openid_code, nickName, avatarUrl, gender).then(res => {
          const {
            code,
            data
          } = res.data
          if (code === 1) {
            getApp().globalData.userInfo = data
            data.visits_time = (data.visits_time / 60).toFixed(2)
            data.run_at = runningTime(Date.now())
            data.last_at = SwitchDate(data.last_at)
            _this.setData({
              isRegister: true,
              userInfo: data
            })
          }
        })
      }
    })
  },
  hanleItemList(e) {
    const {
      path,
      title
    } = e.currentTarget.dataset
    if (title === "GitHub") {
      wx.setClipboardData({
        data: 'https://github.com/lpyhutu',
        success(res) {
          wx.getClipboardData({
            success(res) {
              // console.log(res.data) // data
            }
          })
        }
      })
    } else if (title === "更新日志") {
      wx.navigateTo({
        url: `/pagesUser/pages/log/log`
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
    app.login()

    this.setData({
      isRegister: app.globalData.isRegister,
      userInfo: app.globalData.userInfo,
      articleTotal: app.globalData.articleTotal,
      run_at: runningTime(Date.now())
    })
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