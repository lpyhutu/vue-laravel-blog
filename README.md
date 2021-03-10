<h1>
    <center>个人博客</center>
</h1>
 
<div style="display: flex; justify-content: center; font-size: 12px">
        <div style="padding: 10px; display: flex; color: #fff">
            <div style="background: #000; padding: 0 5px">version</div>
            <div style="background: #1890ff; padding: 0 5px">1.0.8</div>
        </div>
        <div style="padding: 10px; display: flex; color: #fff">
            <div style="background: #000; padding: 0 5px">npm</div>
            <div style="background: #7dbe04; padding: 0 5px">6.12.0</div>
        </div>
        <div style="padding: 10px; display: flex; color: #fff">
            <div style="background: #000; padding: 0 5px">vue</div>
            <div style="background: #07adb3; padding: 0 5px">2.9.6</div>
        </div>
        <div style="padding: 10px; display: flex; color: #fff">
            <div style="background: #000; padding: 0 5px">laravel</div>
            <div style="background: #b37707; padding: 0 5px">7.18.0</div>
        </div>
        <div style="padding: 10px; display: flex; color: #fff">
            <div style="background: #000; padding: 0 5px">mysql</div>
            <div style="background: #1d7c2d; padding: 0 5px">5.7.0</div>
        </div>
    </div>

个人开发的博客网站，静态页面主要使用Vue+SCSS+ElementUI&AntDesignVueUI组件库，后端使用MySQL+Laravel+Redis+Socket实现，有需要的可以下载下来，根据下面提示修改配置文件，打包部署即可完成。

前台预览：https://www.lpyhutu.cn/

后台预览：https://adm.lpyhutu.cn/

小程序预览：在微信小程序平台搜索（RMRF）

### 一、目录结构

```css
├─admin	//后台管理系统
│  ├─public
│  └─src
│      ├─assets
│      │  ├─api	//API接口（运行时记得修改）
│      │  ├─bus
│      │  ├─font
│      │  ├─img
│      │  ├─js
│      │  ├─scss
│      │  └─style //ElementUI主题
│      ├─components
│      ├─router
│      ├─store
│      └─views
├─front //前台
│  ├─public
│  ├─src
│  │  ├─assets
│  │  │  ├─api //API接口（运行时记得修改）
│  │  │  ├─bus
│  │  │  ├─img
│  │  │  ├─js
│  │  │  └─scss
│  │  ├─components
│  │  ├─router
│  │  ├─store
│  │  └─views
│  └─tests
├─api //接口
│  ├─app
│  ├─bootstrap
│  ├─config
│  ├─database
│  ├─public
│  ├─resources
│  ├─routes
│  ├─storage
│  ├─tests
│  └─vendor
│  └─.env //根据所部署的数据库，注册的邮箱，修改里面相关配置
├─template //静态文件，只保留html
│  ├─admin
│  └─front
├─WeChat
│  ├─common
│  ├─components
│  ├─img
│  ├─js
│  ├─miniprogram_npm
│  ├─node_modules
│  ├─pages
│  ├─pagesHome
│  ├─pagesSort
│  ├─pagesUser
│  ├─utils
│  └─wemark
└─wss	//socket,实时统计在线人数
    ├─app
    ├─bootstrap
    ├─config
    ├─database
    ├─public
    ├─resources
    ├─routes
    ├─storage
    └─tests
```

### 二、配置修改

#### 1、前台（front）

**静态页面**：Vue+Vuex+ElementUI+SCSS+WebSocket

**相关配置**：修改main.js和api.js文件里面的接口地址

**效果预览**：https://www.lpyhutu.cn/

#### 2、后台（admin）

**静态页面**：Vue+Vuex+AntDesignVueUI+SCSS+WebSocket

**相关配置**：修改main.js和api.js文件里面的接口地址

**效果预览**：https://adm.lpyhutu.cn/

#### 3、小程序（WeChat）

**静态页面**：WXML+WXSS+JavaScript+WeUI

**相关配置**：修改api.js文件里面的接口地址

**效果预览**：请在微信小程序平台搜索（RMRF）

#### 4、API（api）

根据.env里面注释修改相关配置

#### 5、Socket服务（wss）

在该目录下使用`php artisan workman start --d`命令启动服务

### 更新日志

#### 1、博客

**2021年03月09日**  
&emsp;&emsp;1、1.0.8版本上线
&emsp;&emsp;2、后台新增开发中心管理功能
&emsp;&emsp;3、后台新增《变色方块》数据管理功能
&emsp;&emsp;4、前台新增开发模块功能
&emsp;&emsp;5、前台新增《变色方块》小游戏

**2021年03月05日**  
&emsp;&emsp;1、1.0.7版本上线
&emsp;&emsp;2、后台新增管理员管理功能
&emsp;&emsp;3、后台新增权限等级管理功能
&emsp;&emsp;4、后台新增后台API管理功能
&emsp;&emsp;5、后台新增权限管理功能
&emsp;&emsp;6、后台新增图库管理功能
&emsp;&emsp;7、后台新增微信端用户统计功能
&emsp;&emsp;8、后台文章新增封面上传功能
&emsp;&emsp;9、后台数据表格新增自适应
&emsp;&emsp;10、后台导航栏新增汉堡按钮功能
&emsp;&emsp;11、后台优化样式、修改界面主题

**2021年02月25日**  
&emsp;&emsp;1、1.0.6版本上线
&emsp;&emsp;2、前台UI组件改用AntDesignVue
&emsp;&emsp;3、前台新增搜索功能
&emsp;&emsp;4、前台新增分类功能
&emsp;&emsp;5、前台优化界面布局
&emsp;&emsp;6、前台文章代码显示新增行号功能
&emsp;&emsp;7、前台封装API接口，进行统一管理
&emsp;&emsp;8、前、后台链接申请新增头像上传功能
&emsp;&emsp;9、后台新增留言、评论、友链申请邮件通知功能

**2021年02月19日**  
&emsp;&emsp;1、1.0.5版本上线  
&emsp;&emsp;2、后台添加数据统计管理  
&emsp;&emsp;3、修复前台访客首次访问多次添加  
&emsp;&emsp;4、封装接口、优化前台代码  

**2021年02月05日**  
&emsp;&emsp;1、1.0.4版本上线  
&emsp;&emsp;2、优化网页字体样式、大小  
&emsp;&emsp;3、对网站进行SEO优化  
&emsp;&emsp;4、修复文章链接显示错误的问题  

**2021年01月13日**  
&emsp;&emsp;1、1.0.3版本上线  
&emsp;&emsp;2、后台添加用户分布  
&emsp;&emsp;3、后台添加用户访问时段  
&emsp;&emsp;4、后台添加用户黑名单功能  
&emsp;&emsp;5、优化前台与后台的界面  

**2020年10月09日**  
&emsp;&emsp;1、1.0.2版本上线(Vue2.9.6+Vuex+ElementUI+SCSS+ECharts+WebSocket+ThinkPHP5.0+MySQL5.7+Redis6.0+workerman)  
&emsp;&emsp;2、重构静态页面与后台，优化性能  

**2020年09月03日**  
&emsp;&emsp;1、1.0.1版本上线
&emsp;&emsp;2、修复网页首次登陆显示在线人数为零的问题

**2020年08月20日**  
&emsp;&emsp;1、1.0.0版本上线(Vue2.9.6+Vuex+IView+LESS+ECharts+WebSocket+Laravel7.18+MySQL5.7+Redis5.0+workerman)

#### 2、小程序

**2021年02月19日**  
&emsp;&emsp;1、1.0.3版本上线   
&emsp;&emsp;2、修复获取用户信息错误的问题  
&emsp;&emsp;3、优化界面、分类添加loading提示  

**2021年02月04日**  
&emsp;&emsp;1、1.0.2版本上线       
&emsp;&emsp;2、修复首次进入个人中心时文章数显示为0     
&emsp;&emsp;3、修复文章在不含有图片时显示的问题        

**2021年01月29日**  
&emsp;&emsp;1、1.0.1版本上线      
&emsp;&emsp;2、添加搜索功能          
&emsp;&emsp;3、添加浏览时长统计        
&emsp;&emsp;4、添加日志查看功能        
&emsp;&emsp;5、优化界面显示和精简代码        

**2020年09月03日**        
&emsp;&emsp;1.0.0版本上线(WXML+WXSS+JS+LinUI)
