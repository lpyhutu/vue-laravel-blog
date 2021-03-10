const PrerenderSPAPlugin = require('prerender-spa-plugin')
const Renderer = PrerenderSPAPlugin.PuppeteerRenderer
// eslint-disable-next-line no-unused-vars
const webpack = require('webpack')
const path = require('path')
module.exports = {
    css: {
        loaderOptions: {
            sass: {
                prependData: `@import "@/assets/scss/app";`,
            },
        },
    },
    devServer: {
        hot: true,
        disableHostCheck: true,
    },
    configureWebpack: () => {
        if (process.env.NODE_ENV !== 'production') return
        return {
            plugins: [
                new PrerenderSPAPlugin({
                    // 生成文件的路径，也可以与webpakc打包的一致。
                    // 这个目录只能有一级，如果目录层次大于一级，在生成的时候不会有任何错误提示，在预渲染的时候只会卡着不动。
                    staticDir: path.join(__dirname, 'dist'),
                    // outputDir: path.join(__dirname, './'),
                    // 对应自己的路由文件，比如a有参数，就需要写成 /a/param1。
                    routes: ['/', '/message', '/link', '/about', '/detail/id', "/search"],
                    // 这个很重要，如果没有配置这段，也不会进行预编译
                    renderer: new Renderer({
                        inject: { //默认挂在window.__PRERENDER_INJECTED对象上，可以通过window.__PRERENDER_INJECTED.foo在预渲染页面取值
                            foo: 'bar'
                        },
                        headless: false,
                        // 在 main.js 中 document.dispatchEvent(new Event('render-event'))，两者的事件名称要对应上。
                        renderAfterDocumentEvent: 'render-event' //等到事件触发去渲染，此处我理解为是Puppeteer获取页面的时机
                    })
                })
            ]
        }
    },
}