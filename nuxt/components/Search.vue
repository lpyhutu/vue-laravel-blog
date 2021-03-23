<template>
    <div class="search">
        <a-input-search
            @search="search"
            v-model="title"
            placeholder="请输入关键字"
        />
    </div>
</template>

<script>
import { Message } from "@/assets/js/message";

export default {
    name: "Search",
    data() {
        return {
            title: "",
        };
    },
    methods: {
        search() {
            if (this.title === "") {
                Message(1003, "搜点什么好呢.");
                return;
            }
            // this.$router.push({
            //     path: "/search",
            //     query: {
            //         title: this.title,
            //     },
            // });
            this.$router.push(`/search/${this.title}`);
            if (this.$route.name === "Search") {
                this.$bus.$emit("search", this.title);
            }
        },
    },
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