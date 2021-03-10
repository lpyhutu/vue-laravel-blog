<template>
    <div class="analysis app-card">
        <div class="title">数据分析（日数据统计/访问时段)</div>
        <div class="content ht-flex ht-row-between">
            <div class="left">
                <Echarts id="PCTotal" :option="blogTotal"></Echarts>
            </div>
            <div class="right">
                <Echarts id="PCInterval" :option="blogInterval"></Echarts>
            </div>
        </div>
    </div>
</template>

<script>
import Echarts from "@/components/Echarts.vue";
import { SwitchDate } from "@/assets/js/formatTime";

export default {
    name: "Analysis",
    props: {
        visitsInterval: Array,
        totalList: Array,
    },
    components: {
        Echarts,
    },
    data() {
        return {
            blogTotal: {
                tooltip: {
                    trigger: "axis",
                    axisPointer: {
                        type: "cross",
                        label: {
                            backgroundColor: "#6a7985",
                        },
                    },
                },
                grid: {
                    left: "3%",
                    right: "4%",
                    bottom: "3%",
                    containLabel: true,
                },
                legend: {
                    data: [
                        "访客量(人)",
                        "访问量(次)",
                        "浏览时长(时)",
                        "文章(章)",
                    ],
                },
                xAxis: {
                    type: "category",
                    axisLabel: {
                        show: true,
                    },
                    data: [],
                },
                yAxis: {
                    type: "value",
                },
                series: [
                    {
                        name: "访客量(人)",
                        data: [],
                        type: "bar",
                    },
                    {
                        name: "访问量(次)",
                        data: [],
                        type: "bar",
                    },
                    {
                        name: "浏览时长(时)",
                        data: [],
                        type: "bar",
                    },
                    {
                        name: "文章(章)",
                        data: [],
                        type: "bar",
                    },
                ],
            },
            blogInterval: {
                tooltip: {
                    trigger: "item",
                    formatter: "{a} <br/>{b} : {c} ({d}%)",
                },
                legend: {
                    orient: "vertical",
                    left: "left",
                    data: ["0~6时", "7~11时", "12~18时", "19~24时"],
                },
                grid: {
                    left: "3%",
                    right: "4%",
                    bottom: "3%",
                    containLabel: true,
                },
                series: [
                    {
                        name: "用户访问时段",
                        type: "pie",
                        radius: "55%",
                        center: ["50%", "60%"],
                        data: [
                            { value: 335, name: "0~6时" },
                            { value: 335, name: "7~11时" },
                            { value: 310, name: "12~18时" },
                            { value: 234, name: "19~24时" },
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: "rgba(0, 0, 0, 0.5)",
                            },
                        },
                    },
                ],
            },
        };
    },
    watch: {
        visitsInterval(newV) {
            this.handleBlogInterval(newV);
        },
        totalList(newV) {
            this.handleBlogTotal(newV);
        },
    },
    methods: {
        /**
         * 数据分析
         */
        handleBlogTotal(data) {
            let visitors_num = 0,
                visits_num = 0,
                visits_time = 0,
                article_num = 0,
                visitors_num_arr = [],
                visits_num_arr = [],
                visits_time_arr = [],
                article_num_arr = [],
                current_time_arr = [];
            for (let i = 0; i < data.length; i++) {
                visitors_num = data[i].visitors_num + visitors_num;
                visits_num = data[i].visits_num + visits_num;
                article_num = data[i].article_num + article_num;
                visits_time = data[i].visits_time + visits_time;
                visitors_num_arr.push(data[i].visitors_num);
                visits_num_arr.push(data[i].visits_num);
                visits_time_arr.push(
                    parseFloat(data[i].visits_time / 60).toFixed(2)
                );
                article_num_arr.push(data[i].article_num);
                let d = new Date(
                    parseInt(Date.parse(new Date(data[i].created_at)))
                );
                let M = d.getMonth() + 1;
                let D = d.getDate();
                current_time_arr.push(`${M}-${D}`);
            }
            this.blogTotal.xAxis.data = current_time_arr;
            this.blogTotal.series[0].data = visitors_num_arr;
            this.blogTotal.series[1].data = visits_num_arr;
            this.blogTotal.series[2].data = visits_time_arr;
            this.blogTotal.series[3].data = article_num_arr;
            this.visitors_num = visitors_num;
            this.visits_num = visits_num;
            this.visits_time = parseFloat(visits_time / 60).toFixed(2);
            this.article_num = article_num;
        },
        /**
         * 访问时间段
         */
        handleBlogInterval(data) {
            let Early = 0,
                morning = 0,
                noon = 0,
                evening = 0,
                hours = 0;
            for (let i = 0; i < data.length; i++) {
                let d = new Date(
                    parseInt(Date.parse(new Date(data[i].created_at)))
                );
                hours = d.getHours();
                if (hours < 7) {
                    Early = Early + 1;
                } else if (hours < 12) {
                    morning = morning + 1;
                } else if (hours < 19) {
                    noon = noon + 1;
                } else {
                    evening = evening + 1;
                }
            }
            this.blogInterval.series[0].data[0].value = Early;
            this.blogInterval.series[0].data[1].value = morning;
            this.blogInterval.series[0].data[2].value = noon;
            this.blogInterval.series[0].data[3].value = evening;
        },
        /**
         * 日期转换
         */
        formatTime(time) {
            return SwitchDate(Date.parse(new Date(time)) / 1000);
        },
    },
};
</script>

<style lang="scss" scoped>
.analysis {
    > .content {
        .left {
            flex: 2;
        }
        .right {
            flex: 1;
        }
    }
}
</style>