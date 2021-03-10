<template>
    <div
        class="footer ht-white ht-flex ht-row-center ht-flow-column ht-col-center ht-font-size-12px"
    >
        <div>{{ $store.state.userInfo.copyright }}</div>
        <div>运行时间：{{ time }}</div>
        <a
            :href="$store.state.userInfo.record_link"
            target="_blank"
            class="record ht-flex"
        >
            <div class="left">备案号</div>
            <div class="right">{{ $store.state.userInfo.record }}</div>
        </a>
    </div>
</template>

<script>
import { runningTime } from "@/assets/js/time";
export default {
    name: "Footer",
    data() {
        return {
            time: 0,
        };
    },
    methods: {
        runningTime() {
            setTimeout(() => {
                this.time = runningTime(Date.now());
                this.runningTime();
            }, 1000);
        },
    },
    created() {
        this.runningTime();
    },
};
</script>

<style lang="scss" scoped>
.footer {
    margin-top: 20px;
    padding: 8px 0;
    background: $bg-white;
    > div {
        padding-bottom: 6px;
    }
    .record {
        text-decoration: none;
        div {
            padding: 3px;
            color: $bg-white;
        }
        .left {
            border-radius: 3px 0 0 3px;
            background: #000;
        }
        .right {
            border-radius: 0 3px 3px 0;
            background: $bg-theme;
        }
    }
}
</style>