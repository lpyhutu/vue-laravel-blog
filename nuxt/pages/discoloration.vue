<template>
    <div class="discoloration ht-flex ht-row-center ht-col-center">
        <div class="content">
            <div class="ht-font-size-16px" style="padding-bottom: 10px">
                欢迎回来：{{ $store.state.discolorationName }}
            </div>
            <nuxt-link to="disordinary">
                <a-button size="large">开始游戏 </a-button>
            </nuxt-link>
            <a-button size="large" @click="levelFlag = !levelFlag"
                >难度选择</a-button
            >
            <template v-if="levelFlag">
                <nuxt-link to="disordinary">
                    <a-button>一般 </a-button>
                </nuxt-link>
                <nuxt-link to="disadvanced">
                    <a-button>进阶 </a-button>
                </nuxt-link>
            </template>
            <a-button size="large" @click="tipsHintsFlag = true"
                >游戏说明</a-button
            >
            <a-button size="large" @click="rankingListFlag = true"
                >排行榜</a-button
            >
            <nuxt-link to="experiment">
                <a-button size="large">返回</a-button>
            </nuxt-link>
        </div>
        <a-modal
            title="游戏说明"
            :visible="tipsHintsFlag"
            @ok="handleOk"
            @cancel="handleOk"
            ok-text="确认"
            cancel-text="取消"
        >
            <p>
                《变色方块》是一款休闲益智小游戏，在游戏中遵循一定的基本规则和技巧，拼凑出目标图形，看似简单实际挑战不容易，你能够顺利的通关吗？反正我是不能
                <img
                    style="height: 25px"
                    :src="`${$assets}/upload/img/emotion/29.png`"
                    alt=""
                />
            </p>
            游戏操作:
            <br />
            <p>
                点击操作盘上的任意一个格子，格子本身和上下左右4个格子都将反色（原来是绿色变成黄色，原来是黄色变成绿色）
            </p>
            游戏难度<br />
            一般：玩家需要把所有的绿色变成黄色，即游戏通关！
            <br />
            进阶：在一个8*8正方形里，玩家根据提示拼凑出目标图形，即游戏通关！
        </a-modal>

        <a-modal
            title="温馨提示"
            :visible="isAddGame"
            :confirm-loading="confirmLoading"
            @ok="handleConfirm"
            @cancel="back"
            okText="确定"
            cancelText="取消"
        >
            <a-input v-model="nick_name" placeholder="请输入游戏昵称"></a-input>
        </a-modal>
        <a-modal
            title="游戏排行"
            :visible="rankingListFlag"
            @ok="rankingListFlag = false"
            @cancel="rankingListFlag = false"
            okText="确定"
            cancelText="取消"
        >
            <div class="title ht-font-size-16px">一般模式</div>
            <div class="content">
                <div class="item ht-flex ht-row-between">
                    <div>排名</div>
                    <div>昵称</div>
                    <div>通关</div>
                    <div>步数</div>
                </div>
                <div
                    class="item ht-flex ht-row-between"
                    v-for="(item, key) in ordinary"
                    :key="key"
                >
                    <div>{{ key + 1 }}</div>
                    <div>{{ item.nick_name }}</div>
                    <div>{{ item.level }}</div>
                    <div>{{ item.steps }}</div>
                </div>
            </div>
            <div class="title ht-font-size-16px">进阶模式</div>
            <div class="content">
                <div class="item ht-flex ht-row-between">
                    <div>排名</div>
                    <div>昵称</div>
                    <div>通关</div>
                    <div>步数</div>
                </div>
                <div
                    class="item ht-flex ht-row-between"
                    v-for="(item, key) in advanced"
                    :key="key"
                >
                    <div>{{ key + 1 }}</div>
                    <div>{{ item.nick_name }}</div>
                    <div>{{ item.level }}</div>
                    <div>{{ item.steps }}</div>
                </div>
            </div>
        </a-modal>
    </div>
</template>

<script>
import { Message } from "@/assets/js/message";
import {
    discolorationCurrent,
    discolorationAdd,
    discolorationRanking,
} from "@/assets/api/api";
export default {
    name: "Discoloration",
    layout: function () {
        return "WhiteTheme";
    },
    head() {
        return {
            title: "变色方块 - 网页设计，模板分享，源码下载 - 糊涂博客",
            meta: [
                {
                    hid: "keywords",
                    name: "keywords",
                    content: "变色方块,益智游戏,点灯游戏,游戏",
                },
                {
                    hid: "description",
                    name: "description",
                    content:
                        "《变色方块》是一款休闲益智小游戏，在游戏中遵循一定的基本规则和技巧，拼凑出目标图形，看似简单实际挑战不容易，你能够顺利的通关吗？反正我是不能。",
                },
            ],
        };
    },
    data() {
        return {
            levelFlag: false,
            tipsHintsFlag: false,
            rankingListFlag: false,
            confirmLoading: false,
            isAddGame: false,
            nick_name: "",
            advanced: [],
            ordinary: [],
        };
    },
    methods: {
        getUserData() {
            discolorationCurrent(this.$cookies.get("userInfo"), 0).then(
                (res) => {
                    const { data } = res;
                    if (res && data.length !== 0) {
                        this.$store.commit(
                            "setDiscolorationName",
                            data[0].nick_name
                        );
                    } else {
                        this.$store.commit("setDiscolorationName", "");
                        this.isAddGame = true;
                    }
                }
            );
        },
        /**
         * 游戏排行
         */
        ranking() {
            discolorationRanking().then((res) => {
                if (res) {
                    this.advanced = res.data.advanced;
                    this.ordinary = res.data.ordinary;
                }
            });
        },
        handleConfirm() {
            if (this.nick_name === "") {
                Message(1003, "请输入游戏昵称.");
                return false;
            }
            if (this.nick_name.length > 10) {
                Message(1003, "昵称过长.");
                return false;
            }
            this.confirmLoading = true;
            discolorationAdd(
                this.$cookies.get("userInfo"),
                this.nick_name
            ).then((res) => {
                if (res) {
                    const { nick_name } = res.data;
                    this.$store.commit("setDiscolorationName", nick_name);
                    this.isAddGame = false;
                }
                this.confirmLoading = false;
            });
        },
        back() {
            this.$router.push("/experiment");
        },

        handleOk() {
            this.tipsHintsFlag = false;
        },
    },
    mounted() {
        this.ranking();
        this.getUserData();
    },
};
</script>

<style lang="scss" scoped>
.discoloration {
    position: fixed;
    height: 100%;
    width: 100%;
    background: $bg-default;
    overflow: auto;
    .content {
        padding: 20px;
        width: 300px;
        background: $bg-white;
        button {
            width: 100%;
            margin: 10px 0;
        }
    }
}
.title {
}
.content {
    padding: 20px 0;
    .item {
        text-align: center;
        padding: 2px 0;
        div {
            flex: 1;
        }
    }
}
</style>