<template>
    <div class="card">
        <div class="title ht-font-size-16px">{{ title }}</div>
        <div class="content">
            <slot name="content"> </slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",
    props: {
        title: String,
    },
};
</script>

<style lang="scss" scoped>
.card {
    padding: 20px;
    background: $bg-white;
    .title {
        padding-bottom: 10px;
        border-bottom: 1.5px solid $bg-theme;
    }
    .content {
        padding-top: 10px;
    }
}
</style>