import Vue from "vue";
import Router from "vue-router"

Vue.use(Router)

const routerPush = Router.prototype.push
Router.prototype.push = function push(location) {
    return routerPush.call(this, location).catch(error => error)
}

const router = new Router({
    mode: "history",
    // base: "v1",
    routes: [{
        path: '/',
        name: 'login',
        component: () => import("@/views/Login.vue"),
        meta: {
            title: "欢迎回来"
        },
    }, {
        path: '/home',
        name: 'home',
        component: () => import("@/views/Home.vue"),
        meta: {
            title: "首页"
        },
        children: [{
            path: '/panel',
            name: 'panel',
            component: () => import("@/views/Panel.vue"),
            meta: {
                title: "控制面板"
            },
        }, {
            path: '/statistics',
            name: 'statistics',
            component: () => import("@/views/Statistics.vue"),
            meta: {
                title: "统计分析"
            },
        }, {
            path: '/adminuser',
            name: 'adminuser',
            component: () => import("@/views/AdminUser.vue"),
            meta: {
                title: "管理员"
            },
        }, {
            path: '/powerlevel',
            name: 'powerlevel',
            component: () => import("@/views/PowerLevel.vue"),
            meta: {
                title: "等级管理"
            },
        }, {
            path: '/power',
            name: 'power',
            component: () => import("@/views/Power.vue"),
            meta: {
                title: "权限管理"
            },
        }, {
            path: '/router',
            name: 'router',
            component: () => import("@/views/Router.vue"),
            meta: {
                title: "路由管理"
            },
        }, {
            path: '/pc',
            name: 'pc',
            component: () => import("@/views/UserPc.vue"),
            meta: {
                title: "电脑端用户"
            },
        }, {
            path: '/wechat',
            name: 'wechat',
            component: () => import("@/views/UserWechat.vue"),
            meta: {
                title: "小程序用户"
            },
        }, {
            path: '/article',
            name: 'article',
            component: () => import("@/views/Article.vue"),
            meta: {
                title: "文章列表"
            },
        }, {
            path: '/comment',
            name: 'comment',
            component: () => import("@/views/Comment.vue"),
            meta: {
                title: "评论管理"
            },
        }, {
            path: '/message',
            name: 'message',
            component: () => import("@/views/Message.vue"),
            meta: {
                title: "留言列表"
            },
        }, {
            path: '/type',
            name: 'Type',
            component: () => import("@/views/Type.vue"),
            meta: {
                title: "文章类别"
            },
        }, {
            path: '/link',
            name: 'link',
            component: () => import("@/views/Link.vue"),
            meta: {
                title: "链接列表"
            },
        }, {
            path: '/discoloration',
            name: 'discoloration',
            component: () => import("@/views/Discoloration.vue"),
            meta: {
                title: "变色方块"
            },
        }, {
            path: '/gallery',
            name: 'gallery',
            component: () => import("@/views/Gallery.vue"),
            meta: {
                title: "图库管理"
            },
        }, {
            path: '/info',
            name: 'info',
            component: () => import("@/views/Info.vue"),
            meta: {
                title: "关于我"
            },
        }, {
            path: '/log',
            name: 'log',
            component: () => import("@/views/Log.vue"),
            meta: {
                title: "更新日志"
            },
        }]
    }, ]
})

router.beforeEach((to, from, next) => {
    if (to.path === "/") {
        next();
    } else {
        const token = localStorage.getItem('authExpiresTime');
        if (token === null || token === '') {
            next('/');
        } else {
            next();
        }
    }
});

export default router;