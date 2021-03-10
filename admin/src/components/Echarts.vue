<template>
    <div :id="id" :style="style"></div>
</template>
<script>
import echartsTheme from "@/assets/js/echartsTheme.js";
export default {
    name: "Chart",
    data() {
        return {
            chart: "",
        };
    },
    props: {
        id: {
            type: String,
        },
        width: {
            type: String,
            default: "100%",
        },
        height: {
            type: String,
            default: "350px",
        },
        option: {
            type: Object,
        },
    },
    computed: {
        style() {
            return {
                height: this.height,
                width: this.width,
            };
        },
    },
    watch: {
        option: {
            handler(newVal, oldVal) {
                if (this.chart) {
                    if (newVal) {
                        this.chart.setOption(newVal);
                    } else {
                        this.chart.setOption(oldVal);
                    }
                } else {
                    this.init();
                }
            },
            deep: true,
        },
    },

    methods: {
        init() {
            this.chart = this.$echarts.init(
                document.getElementById(this.id),
                echartsTheme
            );
            this.chart.setOption(this.option);
            window.addEventListener("resize", this.chart.resize);
        },
    },
    mounted() {
        this.$nextTick(() => {
            this.init();
        });
    },
};
</script>