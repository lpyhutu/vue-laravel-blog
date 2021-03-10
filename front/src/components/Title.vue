<template>
    <div class="title">
        <div class="content">{{title}}</div>
    </div>
</template>

<script>
export default {
    name: "Title",
    props: {
        title: String,
    },
};
</script>

<style lang="scss" scoped>
.title {
    // padding: 10px 0;
    background: $bg-default;
    .content {
        font-weight: bold;
        padding: 8px;
        border-left: 3px solid $bg-theme;
    }
}
</style>