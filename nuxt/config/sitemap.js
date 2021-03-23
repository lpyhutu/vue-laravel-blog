import axios from 'axios'
const sitemap = {
  path: '/sitemap.xml',
  hostname: 'https://www.lpya.cn/',
  cacheTime: 1000 * 60 * 60 * 12,
  gzip: true,
  generate: false,
  exclude: [
    '/404'
  ],
  defaults: {
    changefreq: 'daily',
    lastmod: new Date()
  },
  routes: async () => {
    const start = 0;
    const pageSize = 100;
    const getUrl = `https://api.lpya.cn/HtBlog/public/index.php/api/article/article?start=${start}&pageSize=${pageSize}`
    let res = await axios.post(getUrl)
    let {
      data
    } = res.data

    let routes = [{
      url: "/",
      changefreq: "daily",
      lastmod: new Date()
    }]

    if (data.length !== 0) {
      let arr = data.map(item => ({
        url: "/detail/" + item.id,
        lastmod: item.created_at,
        changefreq: "daily"
      }))
      routes.push(...arr)
    }
    return routes
  }
}
export default sitemap
