<template>
    <div class="search">
        <a-input-search placeholder="请输入关键字" />
    </div>
</template>

<script>
export default {
    name: "Search",
};
</script>

<style lang="scss" scoped>
.search {
    max-width: 1200px;
    margin: auto;
    margin-top: 20px;
    padding: 20px;
    background: $bg-white;
}
@media (max-width: 767px) {
    .search {
        margin: 20px 10px 0;
    }
}
</style>