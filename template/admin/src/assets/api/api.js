import { request } from "./request"
export const index = params => { return request(`index`, params) }//测试
export const login = params => { return request(`login`, params) }//登陆
export const logout = params => { return request(`logout`, params) }//退出登陆
export const refreshToken = params => { return request(`refreshToken`, params) }//刷新token
export const getUserInfo = params => { return request(`userInfo`, params) }//用户信息
export const register = params => { return request(`register`, params) }//注册
export const sendEmailCode = params => { return request(`sendEmailCode`, params) }//发送邮箱验证码
export const captcha = params => { return request(`captcha`, params, "get") }//验证码
export const uploadAvatar = params => { return request(`uploadAvatar`, params) }//上传头像
export const getFriends = params => { return request(`friends`, params) }//获取好友
export const searchEmail = params => { return request(`searchEmail`, params) }//搜索账号
export const applyFriend = params => { return request(`applyFriend`, params) }//申请好友
export const getApplyFriend = params => { return request(`getApplyFriend`, params) }//申请列表
export const agreeApplyFriend = params => { return request(`agreeApplyFriend`, params) }//申请通过










