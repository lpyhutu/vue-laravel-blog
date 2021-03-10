<template>
    <div class="user-distribution app-card">
        <div class="title">用户分布</div>
        <div class="content">
            <Echarts id="address" :option="mapData"></Echarts>
        </div>
    </div>
</template>

<script>
import Echarts from "@/components/Echarts.vue";
export default {
    name: "UserDistribution",
    components: {
        Echarts,
    },
    props: {
        userList: Array,
    },
    data() {
        return {
            mapData: {
                tooltip: { show: true },
                dataRange: {
                    show: true,
                    min: 0,
                    max: 1000,
                    realtime: true,
                    calculable: true,
                    color: ["orangered", "yellow", "lightskyblue"],
                },
                geo: {
                    map: "china",
                    roam: true,
                    label: {
                        normal: {
                            show: true, // 是否显示对应地名
                            textStyle: {
                                color: "rgba(0,0,0,0.4)",
                            },
                        },
                    },
                    itemStyle: {
                        normal: {
                            // borderColor: "rgba(0, 0, 0, 0.3)",
                        },
                        emphasis: {
                            areaColor: null,
                            shadowOffsetX: 0,
                            shadowOffsetY: 0,
                            shadowBlur: 20,
                            borderWidth: 0,
                            shadowColor: "rgba(0, 0, 0, 0.5)",
                        },
                    },
                },
                series: [
                    {
                        type: "scatter",
                        coordinateSystem: "geo", // 对应上方配置
                    },
                    {
                        name: "用户数量", // 浮动框的标题
                        type: "map",
                        geoIndex: 0,
                        data: [],
                    },
                ],
            },

            address: [
                {
                    name: "北京",
                    value: "",
                },

                {
                    name: "天津",
                    value: "",
                },

                {
                    name: "河北",
                    value: "",
                },

                {
                    name: "山西",
                    value: "",
                },

                {
                    name: "内蒙古",
                    value: "",
                },

                {
                    name: "辽宁",
                    value: "",
                },

                {
                    name: "吉林",
                    value: "",
                },

                {
                    name: "黑龙江",
                    value: "",
                },

                {
                    name: "上海",
                    value: "",
                },

                {
                    name: "江苏",
                    value: "",
                },

                {
                    name: "浙江",
                    value: "",
                },

                {
                    name: "安徽",
                    value: "",
                },

                {
                    name: "福建",
                    value: "",
                },

                {
                    name: "江西",
                    value: "",
                },

                {
                    name: "山东",
                    value: "",
                },

                {
                    name: "河南",
                    value: "",
                },

                {
                    name: "湖北",
                    value: "",
                },

                {
                    name: "湖南",
                    value: "",
                },

                {
                    name: "广东",
                    value: "",
                },

                {
                    name: "广西",
                    value: "",
                },

                {
                    name: "海南",
                    value: "",
                },

                {
                    name: "重庆",
                    value: "",
                },

                {
                    name: "四川",
                    value: "",
                },

                {
                    name: "贵州",
                    value: "",
                },

                {
                    name: "云南",
                    value: "",
                },

                {
                    name: "西藏",
                    value: "",
                },

                {
                    name: "陕西",
                    value: "",
                },

                {
                    name: "甘肃",
                    value: "",
                },

                {
                    name: "青海",
                    value: "",
                },

                {
                    name: "宁夏",
                    value: "",
                },

                {
                    name: "新疆",
                    value: "",
                },
            ],
        };
    },
    watch: {
        userList(val) {
            this.handleUserList(val);
        },
    },
    methods: {
        handleUserList(data) {
            // let aa = 440001;

            data.forEach((k) => {
                switch (this.handleAdCode(k.adcode)) {
                    case 11: //北京
                        this.handleAddress(0);
                        break;
                    case 12: //天津
                        this.handleAddress(1);
                        break;
                    case 13: //河北
                        this.handleAddress(2);
                        break;
                    case 14:
                        this.handleAddress(3);
                        break;
                    case 15:
                        this.handleAddress(4);
                        break;
                    case 21:
                        this.handleAddress(5);
                        break;
                    case 22:
                        this.handleAddress(6);
                        break;
                    case 23:
                        this.handleAddress(7);
                        break;
                    case 31:
                        this.handleAddress(8);
                        break;
                    case 32:
                        this.handleAddress(9);
                        break;
                    case 33: //浙江
                        this.handleAddress(10);
                        break;
                    case 34:
                        this.handleAddress(11);
                        break;
                    case 35: //福建
                        this.handleAddress(12);
                        break;
                    case 36:
                        this.handleAddress(13);
                        break;
                    case 37:
                        this.handleAddress(14);
                        break;
                    case 41:
                        this.handleAddress(15);
                        break;
                    case 42:
                        this.handleAddress(16);
                        break;
                    case 43:
                        this.handleAddress(17);
                        break;
                    case 44: //广东
                        this.handleAddress(18);
                        break;
                    case 45:
                        this.handleAddress(19);
                        break;
                    case 46:
                        this.handleAddress(20);
                        break;
                    case 50:
                        this.handleAddress(21);
                        break;
                    case 51:
                        this.handleAddress(22);
                        break;
                    case 52:
                        this.handleAddress(23);
                        break;
                    case 53:
                        this.handleAddress(24);
                        break;
                    case 54:
                        this.handleAddress(25);
                        break;
                    case 61:
                        this.handleAddress(26);
                        break;
                    case 62:
                        this.handleAddress(27);
                        break;
                    case 63:
                        this.handleAddress(28);
                        break;
                    case 64:
                        this.handleAddress(29);
                        break;
                    case 65:
                        this.handleAddress(30);
                        break;
                    case 66:
                        this.handleAddress(31);
                        break;
                }
            });
            this.mapData.series[1].data = this.address;
        },
        handleAdCode(code) {
            // console.log(parseInt(code.toString().substring(0, 2)))
            return parseInt(code.toString().substring(0, 2));
        },
        handleAddress(key) {
            this.address[key].value =
                (this.address[key].value == "" ? 0 : this.address[key].value) +
                1;
        },
    },
    created() {
        // console.log(this.address);
    },
};
</script>

<style>
</style>