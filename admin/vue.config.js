// const webpack = require('webpack')
module.exports = {
    css: {
        loaderOptions: {
            sass: {
                additionalData: `@import "@/assets/scss/app";`,
            },
        },
    },
    devServer: {
        hot: true,
        disableHostCheck: true,
    },
    // configureWebpack: {
    //     plugins: [
    //         new webpack.ProvidePlugin({
    //             $: "jquery",
    //             jQuery: "jquery",
    //             "windows.jQuery": "jquery"
    //         })

    //     ]

    // }

}