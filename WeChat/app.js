// app.js
import {
  UserVisitsTime,
  UserLogin
} from "./js/api/api"
import {
  SwitchDate,
  runningTime,
} from "./js/formatTime"
App({
  globalData: {
    userInfo: null,
    code: null,
    isRegister: false,
    articleTotal: 0,
    isLogin: false
  },
  /**
   * 登陆
   */
  login() {
    const _this = this;
    if (this.globalData.isRegister) {
      return true;
    }
    wx.login({
      success(res) {
        const {
          code
        } = res
        _this.globalData.code = code
        UserLogin(code).then(res => {
          const {
            code,
            data
          } = res.data
          if (code === 1) {
            data.visits_time = (data.visits_time / 60).toFixed(2)
            data.last_at = SwitchDate(data.last_at)
            _this.globalData.userInfo = data
            _this.globalData.isLogin = true
            _this.UserVisitsTime()
            if (data.avatar_url == "0") {
              _this.globalData.isRegister = false
            } else {
              _this.globalData.isRegister = true
            }
          }
        })
      }
    })
  },
  /**
   * 用户浏览时长
   */
  handleUserVisitsTime() {
    wx.setStorageSync("UserVisitsTime", 60)
  },
  UserVisitsTime() {
    const time = wx.getStorageSync("UserVisitsTime")
    if (time > 0) {
      setTimeout(() => {
        this.UserVisitsTime()
      }, 1000);
      wx.setStorageSync("UserVisitsTime", time - 1)
    } else {
      UserVisitsTime(this.globalData.userInfo.id).then(res => {
        const {
          code,
          data
        } = res.data
        if (code === 1) {
          data.visits_time = (data.visits_time / 60).toFixed(2)
          data.run_at = runningTime(Date.now())
          data.last_at = SwitchDate(data.last_at)
          this.globalData.userInfo = data
        }
        wx.setStorageSync("UserVisitsTime", 60)
        this.UserVisitsTime()
      })
    }
  },
  handleIsLogin() {
    if (!this.globalData.isLogin) {
      wx.switchTab({
        url: '/pages/home/home'
      })
    }

  },
  onLaunch: function () {
    this.handleIsLogin()
    this.handleUserVisitsTime()
  },
})