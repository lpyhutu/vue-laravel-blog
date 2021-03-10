import {
    request
} from "./request"
export const index = params => {
    return request(`article/get?&currentPage=1&pageSize=10`, params, "get")
}
//访问
export const userLogin = () => {
    return request(`user/login`)
}
//图片上传
export const upload = params => {
    return request(`common/uploadLogo`, params)
}
//浏览时长
export const totalVisitsTime = (uid) => {
    return request(`total/visitsTime?uid=${uid}`)
}
//统计
export const totalNum = () => {
    return request(`total/num`)
}
//qq详情
export const qqInfo = (qq) => {
    return request(`common/qqInfo?qq=${qq}`)
}
//文章列表
export const articleGet = (start, pageSize) => {
    return request(`article/article?start=${start}&pageSize=${pageSize}`)
}
//文章搜索
export const articleSearch = (title, start, pageSize) => {
    return request(`article/search?title=${title}&start=${start}&pageSize=${pageSize}`)
}
//当前类别文章
export const articleType = (type, start, pageSize) => {
    return request(`article/type?type=${type}&start=${start}&pageSize=${pageSize}`)
}
//文章类别
export const typeGet = () => {
    return request(`type/get`)
}
//文章详情
export const articleDetail = (id, uid) => {
    return request(`article/detail?id=${id}&uid=${uid}`)
}
//文章点赞
export const articleThumb = (id, uid) => {
    return request(`article/thumb?id=${id}&uid=${uid}`)
}
//阅读排行
export const articleRanking = () => {
    return request(`article/ranking`)
}
//链接列表
export const linkGet = () => {
    return request(`link/link`)
}
//申请链接
export const linkApply = (img_url, title, site, email) => {
    return request(`link/apply?img_url=${img_url}&title=${title}&site=${site}&email=${email}`)
}

//基本信息
export const infoGet = () => {
    return request(`info/info`)
}
//留言板
export const msgGet = (start, pageSize) => {
    return request(`msg/msg?start=${start}&pageSize=${pageSize}`)
}
//留言
export const msgAdd = (qq, name, email, avatar, content) => {
    return request(`msg/add?qq=${qq}&name=${name}&email=${email}&avatar=${avatar}&content=${content}`)
}
//留言点赞
export const msgThumb = (id, sub_id, uid) => {
    return request(`msg/thumb?id=${id}&sub_id=${sub_id}&uid=${uid}`)
}
//留言评论
export const msgSubComment = (msg_id, qq, name, email, avatar, content) => {
    return request(`msgSub/comment?msg_id=${msg_id}&qq=${qq}&name=${name}&email=${email}&avatar=${avatar}&content=${content}`)
}
//子留言评论
export const msgSubCommentSub = (sub_id, qq, name, email, avatar, content) => {
    return request(`msgSub/commentSub?sub_id=${sub_id}&qq=${qq}&name=${name}&email=${email}&avatar=${avatar}&content=${content}`)
}

//文章留言列表
export const commentGet = (start, pageSize, article_id) => {
    return request(`comment/comment?start=${start}&pageSize=${pageSize}&article_id=${article_id}`)
}

//文章留言
export const commentAdd = (article_id, qq, name, email, avatar, content) => {
    return request(`comment/add?article_id=${article_id}&qq=${qq}&name=${name}&email=${email}&avatar=${avatar}&content=${content}`)
}
//文章留言评论
export const commentSubComment = (msg_id, qq, name, email, avatar, content) => {
    return request(`commentSub/comment?msg_id=${msg_id}&qq=${qq}&name=${name}&email=${email}&avatar=${avatar}&content=${content}`)
}
//文章子留言评论
export const commentSubCommentSub = (sub_id, qq, name, email, avatar, content) => {
    return request(`commentSub/commentSub?sub_id=${sub_id}&qq=${qq}&name=${name}&email=${email}&avatar=${avatar}&content=${content}`)
}
//文章留言点赞
export const commentThumb = (id, sub_id, uid) => {
    return request(`comment/thumb?id=${id}&sub_id=${sub_id}&uid=${uid}`)
}

//变色方块
export const discolorationCurrent = (uid, type = 0) => {
    return request(`discoloration/current?uid=${uid}&type=${type}`)
}
//添加游戏信息
export const discolorationAdd = (uid, nick_name) => {
    return request(`discoloration/add?uid=${uid}&nick_name=${nick_name}`)
}
//更新游戏信息
export const discolorationEdit = (uid, nick_name, type, level, steps) => {
    return request(`discoloration/edit?uid=${uid}&nick_name=${nick_name}&type=${type}&level=${level}&steps=${steps}`)
}
//游戏排行
export const discolorationRanking = () => {
    return request(`discoloration/ranking`)
}