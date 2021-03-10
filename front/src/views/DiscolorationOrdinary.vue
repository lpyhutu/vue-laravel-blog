<template>
    <div class="discoloration-ordinary">
        <Loading v-show="isLoading" :tip="'loading'"></Loading>

        <div
            class="header ht-flex ht-row-between"
            :style="{ width: `${contentWidth}px` }"
        >
            <div class="item">关卡：{{ level }}</div>
            <div class="item">当前步数：{{ currentSteps }}</div>
            <div class="item">总步数：{{ steps }}</div>
        </div>
        <div
            class="content"
            :style="{ width: `${contentWidth}px`, height: `${contentWidth}px` }"
        >
            <div
                class="item item-color1"
                :class="item == 0 ? 'item-color1' : 'item-color2'"
                :style="{
                    height: `${(contentWidth - level) / level}px`,
                    width: `${(contentWidth - level) / level}px`,
                }"
                v-for="(item, key) in list"
                :key="key"
                @click="handleCurrentIndex(key)"
            ></div>
        </div>
        <div
            class="footer ht-flex ht-row-between"
            :style="{ width: `${contentWidth}px` }"
        >
            <a-popconfirm
                title="是否重玩本关？"
                ok-text="确定"
                cancel-text="取消"
                @confirm="playAgain"
            >
                <a-button>重玩本关</a-button>
            </a-popconfirm>
            <a-popconfirm
                title="是否重玩游戏？该用户最高记录不会重置！"
                ok-text="确定"
                cancel-text="取消"
                @confirm="restartGame"
            >
                <a-button>重玩游戏</a-button>
            </a-popconfirm>
            <a-popconfirm
                title="是否退出游戏？"
                ok-text="确定"
                cancel-text="取消"
                @confirm="back"
            >
                <a-button>退出游戏</a-button>
            </a-popconfirm>
        </div>
    </div>
</template>

<script>
import { Message } from "@/assets/js/message";
import { discolorationCurrent, discolorationEdit } from "@/assets/api/api";
import Loading from "@/components/Loading";

export default {
    name: "DiscolorationOrdinary",
    metaInfo: {
        title: "变色方块(一般) - 网页设计，模板分享，源码下载 - 糊涂博客",
        meta: [
            {
                name: "keyWords",
                content: "网页,游戏,益智,休闲,难度",
            },
            {
                name: "description",
                content:
                    "糊涂个人博客，一位编程爱好者的成长地。专注于前后端的学习，不定期更新分享踩坑过程，学习记录、网页模板、demo源码等，也希望借此能够认识更多的朋友。",
            },
        ],
    },
    components: {
        Loading,
    },
    data() {
        return {
            contentWidth: 500,
            list: [],
            successList: [],
            level: 1,
            steps: 0,
            currentSteps: 0,
            isLoading: true,
        };
    },
    methods: {
        getUserData() {
            this.isLoading = true;
            discolorationCurrent(this.$cookies.get("userInfo"), 1).then(
                (res) => {
                    this.isLoading = false;
                    const { data } = res;
                    if (res && data.length === 0) {
                        this.initializeData();
                        return false;
                    }
                    const { level, steps } = data[0];
                    if (level === 0) {
                        this.initializeData();
                        return false;
                    }

                    this.level = level + 1;
                    this.steps = steps;
                    this.setData();
                    this.initializeData();
                }
            );
        },
        editUserData() {
            discolorationEdit(
                this.$cookies.get("userInfo"),
                this.$store.state.discolorationName,
                1,
                this.level - 1,
                this.steps
            );
        },
        initializeData() {
            if (!this.$store.state.discolorationName) {
                this.$router.push("/discoloration");
                return false;
            }
            let ordinary = sessionStorage.getItem("ordinary");
            if (ordinary) {
                ordinary = JSON.parse(ordinary);
                this.level = ordinary.level;
                this.steps = ordinary.steps - ordinary.currentSteps;
                this.currentSteps = 0;
            } else {
                this.level = 1;
                this.steps = 0;
                this.currentSteps = 0;
            }
            this.handleList();
        },
        setData() {
            sessionStorage.setItem(
                "ordinary",
                JSON.stringify({
                    level: this.level,
                    steps: this.steps,
                    currentSteps: this.currentSteps,
                })
            );
        },
        /**
         * 赋值
         */
        handleList() {
            this.currentSteps = 0;
            this.list = [];
            this.successList = [];
            for (let i = 0; i < this.level * this.level; i++) {
                this.list.push(0);
                this.successList.push(1);
            }
        },
        handleCurrentIndex(currentIndex) {
            this.steps++;
            this.currentSteps++;
            this.setData();
            //当前
            this.setList(currentIndex);
            // 上一级
            if (currentIndex > this.level - 1) {
                const upLevelIndex = currentIndex - this.level;
                this.setList(upLevelIndex);
            }
            // 下一级
            if (currentIndex < (this.level - 1) * this.level) {
                const downLevelIndex = currentIndex + this.level;
                this.setList(downLevelIndex);
            }
            //左
            if (currentIndex % this.level !== 0) {
                const leftLevelIndex = currentIndex - 1;
                this.setList(leftLevelIndex);
            }
            //右
            if ((currentIndex + 1) % this.level !== 0) {
                const rightLevelIndex = currentIndex + 1;
                this.setList(rightLevelIndex);
            }
            this.checkList();
        },
        checkList() {
            if (this.list.toString() === this.successList.toString()) {
                this.level++;
                Message(1000, "恭喜你，通关了.");
                this.editUserData();
                this.handleList();
                this.setData();
            }
        },
        /**
         * 修改
         */
        setList(index) {
            this.$set(this.list, index, this.handleVal(this.list[index]));
        },
        /**
         * 判断1还是0
         */
        handleVal(value) {
            let val = value === 1 ? 0 : 1;
            return val;
        },
        /**
         * 重玩本关
         */
        playAgain() {
            this.steps = this.steps - this.currentSteps;
            this.currentSteps = 0;
            this.setData();
            this.handleList();
        },
        /**
         * 重玩游戏
         */
        restartGame() {
            this.level = 1;
            this.steps = 0;
            this.currentSteps = 0;
            this.setData();
            this.handleList();
        },
        back() {
            this.$router.go(-1);
        },
        handleOnresize() {
            const _this = this;
            let screenWidth = document.body.clientWidth;
            let screenHeight = document.body.clientHeight;
            _this.handleWidthHeight(screenWidth, screenHeight);
            window.onresize = () => {
                return (() => {
                    let screenWidth = document.body.clientWidth;
                    let screenHeight = document.body.clientHeight;
                    _this.handleWidthHeight(screenWidth, screenHeight);
                })();
            };
        },
        handleWidthHeight(width, height) {
            if (width > height) {
                this.contentWidth = height * 0.7;
            } else {
                this.contentWidth = width * 0.9;
            }
        },
    },
    created() {
        this.getUserData();
    },
    mounted() {
        this.handleOnresize();
    },
};
</script>

<style lang="scss" scoped>
.discoloration-ordinary {
    position: fixed;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-flow: column;
    background: $bg-default;
    > .header {
        padding-bottom: 10px;
    }
    .content {
        display: flex;
        flex-wrap: wrap;
        align-content: space-between;
        justify-content: space-between;
        .item {
            cursor: pointer;
        }
        .item-color1 {
            background: #07be91;
        }
        .item-color2 {
            background: #e0c007;
        }
    }
    > .footer {
        padding-top: 10px;
        button {
            margin-bottom: 7px;
        }
    }
}
</style>