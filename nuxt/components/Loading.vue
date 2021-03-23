<template>
    <div
        class="loading ht-flex ht-row-center ht-col-center ht-flow-column"
        :style="{ background: bgModal }"
    >
        <div
            class="ht-wave ht-flex ht-row-between"
            :style="{ height: height, width: width }"
        >
            <div
                class="ht-wave-rect"
                :style="{ background: bgColor }"
                v-for="(item, key) in 5"
                :key="key"
            ></div>
        </div>
        <div class="text">{{ tip }}</div>
    </div>
</template>

<script>
export default {
    name: "Loading",
    props: {
        loading: {
            type: Boolean,
            default: true,
        },
        bgColor: {
            type: String,
            default: "#1890ff",
        },
        width: {
            type: String,
            default: "40px",
        },
        height: {
            type: String,
            default: "40px",
        },
        bgModal: {
            type: String,
            // default: "rgba(0, 0, 0, 0.5)",
            default: "rgba(255, 255, 255, 0.9)",
        },
        tip: {
            type: String,
            default: "Loading",
        },
    },
};
</script>

<style lang="scss" scoped>
.loading {
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0px;
    left: 0px;
    z-index: 10000;
    .ht-wave {
        @for $i from 1 through 5 {
            .ht-wave-rect:nth-child(#{$i}) {
                animation-delay: -1.2s + $i * 0.1;
            }
        }
        .ht-wave-rect {
            height: 100%;
            width: 15%;
            animation: ht-wave 1.2s infinite ease-in-out;
        }
        @keyframes ht-wave {
            0%,
            40%,
            100% {
                transform: scaleY(0.4);
            }
            20% {
                transform: scaleY(1);
            }
        }
    }
    .text {
        font-size: 12px;
        color: $bg-theme;
    }
}
</style>