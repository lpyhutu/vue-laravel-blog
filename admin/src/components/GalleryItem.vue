<template>
    <div class="gallery-item">
        <div
            class="item"
            :class="currentIndex === item.id ? 'item-active' : ''"
            v-for="(item, key) in data"
            :key="key"
            @click="handleCurrentIndex(item.id, item.img_url)"
        >
            <img :src="$api + item.img_url" alt="" />
        </div>
    </div>
</template>

<script>
import { GalleryGet } from "@/assets/api/api";

export default {
    name: "GalleryItem",
    data() {
        return {
            data: [],
            currentIndex: 0,
        };
    },
    methods: {
        /**
         * 获取
         */
        get() {
            GalleryGet({
                start: 0,
                pageSize: 0,
            }).then((res) => {
                if (res) {
                    const { data } = res;
                    this.data = data;
                } else {
                    this.data = [];
                }
            });
        },
        handleCurrentIndex(index, img_url) {
            this.currentIndex = index;
            this.$emit("handleCover", img_url);
        },
    },
    created() {
        this.get();
    },
};
</script>

<style lang="scss" scoped>
.gallery-item {
    display: flex;
    flex-wrap: wrap;
    .item {
        padding: 10px;
        border: 2px solid $ht-white;
        img {
            width: 90px;
            height: 90px;
        }
    }
    .item-active {
        border: 2px solid $ht-theme;
    }
}
</style>