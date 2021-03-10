<template>
    <div
        class="footer ht-white ht-flex ht-row-center ht-flow-column ht-col-center ht-font-size-12px"
    >
        <div>Copyright © 2020-2021 lpyhutu.cn All Rights Reserved</div>
        <div>运行时间：1年11月424天</div>
        <a
            href="http://beian.miit.gov.cn/"
            target="_blank"
            class="record ht-flex"
        >
            <div class="left">备案号</div>
            <div class="right">粤ICP备20027673号</div>
        </a>
    </div>
</template>

<script>
export default {
    name: "Footer",
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