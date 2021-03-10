import {
    request
} from "./request"
const path = `http://接口地址/api/wechat`;
//用户登陆
export const UserLogin = (code) => {
    return request({
        url: `${path}/user/login?code=${code}`,
        method: "post"
    })
}
//用户信息注册
export const UserRegister = (id, code, nick_name, avatar_url, gender) => {
    return request({
        url: `${path}/user/register?id=${id}&code=${code}&nick_name=${nick_name}&avatar_url=${avatar_url}&gender=${gender}`,
        method: "post"
    })
}
//用户浏览时长
export const UserVisitsTime = (uid) => {
    return request({
        url: `${path}/user/visitsTime?uid=${uid}`,
        method: "post"
    })
}
//获取文章
export const articleGet = (start, pageSize) => {
    return request({
        url: `${path}/article/get?start=${start}&pageSize=${pageSize}`,
        method: "post"
    })
}
//获取文章详情
export const articleDetail = (id, uid) => {
    return request({
        url: `${path}/article/detail?id=${id}&uid=${uid}`,
        method: "post"
    })
}
//获取文章
export const articleSearch = (title, start, pageSize) => {
    return request({
        url: `${path}/article/search?title=${title}&start=${start}&pageSize=${pageSize}`,
        method: "post"
    })
}
//文章点赞
export const articleThumb = (id, uid) => {
    return request({
        url: `${path}/article/thumb?id=${id}&uid=${uid}`,
        method: "post"
    })
}
//当前类别文章
export const currentTypeArticleGet = (type) => {
    return request({
        url: `${path}/article/currentTypeArticle?type=${type}`,
        method: "post"
    })
}

//文章类别
export const typeGet = () => {
    return request({
        url: `${path}/type/get`,
        method: "post"
    })
}


//文章类别
export const logGet = (start, pageSize) => {
    return request({
        url: `${path}/log/get?start=${start}&pageSize=${pageSize}`,
        method: "post"
    })
}