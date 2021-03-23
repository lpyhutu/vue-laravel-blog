import sitemap from "./config/sitemap"
const CompressionPlugin = require('compression-webpack-plugin');
export default {
  head: {
    title: '网页设计，模板分享，源码下载 - 糊涂博客',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [{
        charset: 'utf-8'
      },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1'
      },
      {
        hid: 'description',
        name: 'description',
        content: "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
      }
    ],
    link: [{
      rel: 'icon',
      type: 'image/x-icon',
      href: '/favicon.ico'
    }]
  },

  css: [
    'ant-design-vue/dist/antd.css',
    '@/assets/scss/common.scss',
    '@/assets/scss/theme.scss',
  ],
  styleResources: {
    scss: '~assets/scss/app.scss',
  },
  plugins: [
    '@/plugins/antd-ui',
    "@/store/index",
    "@/main",
  ],
  components: true,
  buildModules: [],
  modules: [
    '@nuxtjs/style-resources',
    '@nuxtjs/sitemap',
    '@nuxtjs/robots',
  ],
  robots: {
    UserAgent: '*',
    Disallow: "",
    Sitemap: 'https://www.lpya.cn/sitemap.xml',
  },
  sitemap: sitemap,
  build: {
    plugins: [
      new CompressionPlugin({
        test: /\.js$|\.html$|\.css/, // 匹配文件名
        threshold: 10240, // 对超过10kb的数据进行压缩
        deleteOriginalAssets: false // 是否删除原文件
      })
    ],
    optimization: {
      splitChunks: {
        minSize: 10000,
        maxSize: 250000
      }
    },
  }

}
