<template>
    <div class="panel">
        <div class="number">
            <StatisticsList :num="num" :online="online"></StatisticsList>
        </div>
        <div class="distribution ht-flex">
            <div class="left">
                <UserDistribution :userList="userAll"></UserDistribution>
            </div>
            <div class="right">
                <UserNew :userList="userList"></UserNew>
            </div>
        </div>
        <div class="visual">
            <Analysis
                :visitsInterval="visitsInterval"
                :totalList="totalList"
            ></Analysis>
        </div>
    </div>
</template>

<script>
import StatisticsList from "@/components/StatisticsList.vue";
import Analysis from "@/components/Analysis.vue";
import UserNew from "@/components/UserNew.vue";
import UserDistribution from "@/components/UserDistribution.vue";
import { TotalNum } from "@/assets/api/api";

export default {
    name: "Panel",
    components: {
        StatisticsList,
        Analysis,
        UserNew,
        UserDistribution,
    },
    data() {
        return {
            num: {},
            totalList: [],
            userList: [],
            visitsInterval: [],
            userAll: [],
            online: 0,
        };
    },
    methods: {
        TotalNum() {
            TotalNum().then((res) => {
                if (res) {
                    const {
                        num,
                        total,
                        user,
                        visitsInterval,
                        userAll,
                    } = res.data;
                    this.num = num;
                    this.totalList = total;
                    this.userList = user;
                    this.visitsInterval = visitsInterval;
                    this.userAll = userAll;
                }
            });
        },
        initWebSocket() {
            // this.websock = new WebSocket("ws://127.0.0.1:2346");
            this.websock = new WebSocket("wss://wss.lpyhutu.cn/blog");
            this.websock.onmessage = this.websocketonmessage;
            this.websock.onopen = this.websocketonopen;
            this.websock.onerror = this.websocketonerror;
            this.websock.onclose = this.websocketclose;
        },
        websocketonopen() {
            this.websocketsend(
                JSON.stringify({
                    type: "admin",
                    group: "admin_login",
                })
            );
        },
        websocketonerror() {
            this.initWebSocket();
        },
        websocketonmessage(e) {
            let data = JSON.parse(e.data);
            if (data.type == "online") {
                this.online = data.data.online;
            }
        },
        websocketsend(Data) {
            this.websock.send(Data);
        },
    },
    created() {
        this.TotalNum();
        this.initWebSocket();
    },
};
</script>

<style lang="scss" scoped>
.panel {
    > .number {
        // > .left {
        //     flex: 1;
        //     margin-right: 15px;
        // }

        // > .right {
        //     flex: 2.5;
        // }
    }
    > .distribution {
        margin: 20px 0;
        > .left {
            flex: 2;
            margin-right: 15px;
        }
        > .right {
            flex: 1;
        }
    }
    > .visual {
    }
}
</style>