<template>
    <div class="detail">
        <div class="app-content">
            <div class="app-left">
                <div class="content">
                    <div class="title ht-font-size-16px">
                        <h3>
                            序webview内嵌H5功能微信小程序web-view内嵌H5使用PHP完成支付功能view内嵌H5使
                        </h3>
                    </div>
                    <div class="info ht-flex ht-row-center">
                        <div class="item ht-flex ht-font-size-12px">
                            <div>分类</div>
                            <div class="item-1">JavaScript</div>
                        </div>
                        <div
                            class="item ht-flex ht-font-size-12px"
                            style="margin: 0 10px"
                        >
                            <div>时间</div>
                            <div class="item-2">2021-1-5 15:33:44</div>
                        </div>
                        <div class="item ht-flex ht-font-size-12px">
                            <div>访问</div>
                            <div class="item-3">11</div>
                        </div>
                    </div>
                    <article>
                        每天进步一点点… 1、首先安装好redis
                        2、进行redis安装目录下，执行mkdir
                        cluster创建存放集群配置文件的目录
                        3、进入cluster目录执行mkdir
                        redis6380创建redis6380-6388目录
                        83c401dc746e8fd61aab1010fac2b23b.png 4、复制配置文件 cp
                        redis.conf ./cluster/redis6380/redis.conf
                        5、进入redis6380目录修改redis.conf配置文件，有注释就去掉
                        port 6380 pidfile
                        "/www/server/redis/cluster/redis6380/redis.pid" dir
                        "/www/server/redis/cluster/redis6380" cluster-enabled
                        yes cluster-config-file "nodes-6380.conf"
                        cluster-node-timeout 15000
                        cluster-replica-validity-factor 10
                        cluster-migration-barrier 1
                        cluster-require-full-coverage yes
                        cluster-replica-no-failover no
                        6、在cluster目录下执行命令touch
                        setport.sh创建批量修改脚本，添加下面内容 sed
                        "s/6380/6381/g" redis6380/redis.conf >
                        ./redis6381/redis.conf sed "s/6380/6382/g"
                        redis6380/redis.conf > ./redis6382/redis.conf sed
                        "s/6380/6383/g" redis6380/redis.conf >
                        ./redis6383/redis.conf sed "s/6380/6384/g"
                        redis6380/redis.conf > ./redis6384/redis.conf sed
                        "s/6380/6385/g" redis6380/redis.conf >
                        ./redis6385/redis.conf sed "s/6380/6386/g"
                        redis6380/redis.conf > ./redis6386/redis.conf sed
                        "s/6380/6387/g" redis6380/redis.conf >
                        ./redis6387/redis.conf sed "s/6380/6388/g"
                        redis6380/redis.conf > ./redis6388/redis.conf
                        在该目录下先执行chmod +x
                        setport.sh，然后执行./setport.sh，进入redis6381-redis6388目录里面，查看redis.conf是否添加并修改成功
                        7、找到redis-server启动命令的目录（一般在src或bin），在该目录下执行命令touch
                        start.sh创建批量启动脚本，添加下面内容 ./redis-server
                        /www/server/redis/cluster/redis6380/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6381/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6382/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6383/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6384/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6385/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6386/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6387/redis.conf
                        ./redis-server
                        /www/server/redis/cluster/redis6388/redis.conf
                        在该目录下执行chmod +x
                        start.sh命令，然后执行./start.sh命令，使用ps -ef |grep
                        redis查看是否启动成功 2.png 8、分配槽位 ./redis-cli
                        --cluster create 127.0.0.1:6380 127.0.0.1:6381
                        127.0.0.1:6382 127.0.0.1:6383 127.0.0.1:6384
                        127.0.0.1:6385 127.0.0.1:6386 127.0.0.1:6387
                        127.0.0.1:6388 --cluster-replicas 2 3.png
                        9、使用客户端启动验证 ./redis-cli -h 127.0.0.1 -p 6380
                        -c 先执行cluster nodes命令，看到下面内容 4.png
                        然后添加key，获取Key，可以看到从6380端口变成6381，就说明已经部署成功
                        6.png
                        10、批量关闭脚本，借鉴6、7创建shutdown.sh文件，添加下面内容
                        ./redis-cli -h 127.0.0.1 -p 6380 shutdown ./redis-cli -h
                        127.0.0.1 -p 6381 shutdown ./redis-cli -h 127.0.0.1 -p
                        6382 shutdown ./redis-cli -h 127.0.0.1 -p 6383 shutdown
                        ./redis-cli -h 127.0.0.1 -p 6384 shutdown ./redis-cli -h
                        127.0.0.1 -p 6385 shutdown ./redis-cli -h 127.0.0.1 -p
                        6386 shutdown ./redis-cli -h 127.0.0.1 -p 6387 shutdown
                        ./redis-cli -h 127.0.0.1 -p 6388 shutdown
                    </article>
                    <div class="action ht-flex ht-row-center">
                        <a-button type="primary" icon="like">111</a-button>
                    </div>
                    <div class="up-down">
                        <div class="item">
                            上一篇：
                            序webview内嵌H5功能微信小程序web-view内嵌H5使用PHP完成支付功
                        </div>
                        <div class="item">下一篇：H5功能微信小程序web-v</div>
                    </div>
                    <div class="other ht-flex">
                        <div class="left">
                            <img src="../assets/img/qqgroup.jpg" alt="" />
                        </div>
                        <div class="right">
                            <div class="">
                                <span>作者：</span>
                                <span>糊涂</span>
                            </div>
                            <div class="">
                                <span>邮箱：</span>
                                <span>1048672466@qq.com</span>
                            </div>
                            <div class="">
                                <span>链接：</span>
                                <span>
                                    <a
                                        href="https://lpyhutu.cn/v1/detail?id=18"
                                        target="_blank"
                                        >https://lpyhutu.cn/v1/detail?id=18</a
                                    >
                                </span>
                            </div>
                            <div class="">
                                <span>扫码加入学习交流群</span>
                            </div>
                        </div>
                    </div>
                    <Comment></Comment>
                    <Title :title="'留言列表'" style="margin-top: 20px"></Title>
                    <CommentList></CommentList>
                </div>
            </div>
            <div class="app-right">
                <User style="margin: 0px 0px 15px"></User>
                <Ranking class="app-none" style="margin: 15px 0"></Ranking>
                <HTLink class="app-none" style="margin: 15px 0"></HTLink>
            </div>
        </div>
    </div>
</template>

<script>
import User from "@/components/User";
import Ranking from "@/components/Ranking";
import HTLink from "@/components/Link";
import Comment from "@/components/Comment";
import CommentList from "@/components/CommentList";

export default {
    name: "Detail",
    metaInfo: {
        title: "文章详情 - 分享技术，分享生活 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "网页，后台，技术，分享",
            },
            {
                name: "description",
                content:
                    "博客个人博客网站,一位编程爱好者的成长地。记录工作、生活中的点点滴滴,不定期更新分享，也希望能够认识更多的朋友。",
            },
        ],
    },
    components: { User, Ranking, HTLink, Comment, CommentList },
};
</script>

<style lang="scss" scoped>
.detail {
    .content {
        padding: 20px;
        background: $bg-white;
        .title {
            text-align: center;
            padding-top: 10px;
        }
        .info {
            margin: 20px 0;
            .item {
                div {
                    padding: 2px 3px;
                    color: $bg-white;
                }
                div:first-child {
                    background: $bg-black;
                }
                .item-1 {
                    background: rgb(1, 150, 155);
                }
                .item-2 {
                    background: $bg-theme;
                }
                .item-3 {
                    background: rgb(207, 187, 5);
                }
            }
        }
        .action {
            padding: 20px 0;
        }
        .up-down {
            padding: 10px 0;
            .item {
                padding: 5px 0;
                cursor: pointer;
                &:hover {
                    color: $bg-theme;
                }
            }
        }
        .other {
            margin: 10px 0 30px;
            padding: 10px;
            border-left: 3px solid $bg-theme;
            background: $bg-default;
            .left {
                margin-right: 10px;
                img {
                    background: $bg-white;
                    padding: 5px;
                    height: 80px;
                    width: 80px;
                }
                @media (max-width: 400px) {
                    img {
                        display: none;
                    }
                }
            }
            .right {
                line-height: 160%;
                a {
                    text-decoration: none;
                }
            }
        }
    }
}
</style>

