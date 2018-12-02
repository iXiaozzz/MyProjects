<template>
<div class="dialog" id="dialog">
  <div class="dialog-cover" @click="closeSelf"></div>
  <!-- <transition name="fade" mode="out-in" appear > -->
    <div id="layer1" ref="layerAct"  class="animated bounceInUp">
      <ul class="my-table-view">
        <li class="my-table-view-cell">
            <img class="my-media-object fl" :src="goodInfo.imgUrl" alt="正在加载...">
            <div class="mui-media-body">
                <p class="my-ellipsis">
                    {{goodInfo.desc}}
                    <!-- 人生路上不是每轮艳阳都暖人，不是每片云彩都下雨。一些事，想开自然微笑，看透肯定放下。人在旅途，心宽，才是海阔天空。 -->
                </p>
                <p class="my-ellipsis">
                  <i class="iconfont icon-rmb c-red">{{goodInfo.price}}</i>
                  <span class="fr">剩余{{goodInfo.rest}}件</span>
                </p>
            </div>
        </li>
        <li class="my-table-view-cell">
            <p>分类：</p>
            <div class="opt-box flex">
              <div v-for="(item,index) in goodInfo.size" :key="index">
                <div :class="{size:true,selected:index === optGoodInfo.size}" @click="optSize(index)">{{item}}</div>
              </div>
            </div>
        </li>
        <li class="my-table-view-cell buyNum-box">
            <span>购买数量:</span>
            <div class="optNum-btn fr flex" id="optNum-btn">
                <div class="iconfont icon-jian btn c-hui" type="jian" @click.stop.prevent="decrement"></div>
                <div class="iconfont text">{{optGoodInfo.buyCount}}</div>
                <div class="iconfont icon-jia btn" type="add" @click.stop.prevent="increment"></div>
            </div>
        </li>
        <li class="group-btn" id="bottomBtn">
            <span class="btn c-bai btn-bg2" @click="addToCar">加入购物车</span>
            <span class="btn c-bai btn-bg1">立即购买</span>
        </li>
    </ul>
    </div>
  <!-- </transition> -->
</div>
</template>
<script>
// import { mapActions } from "vuex";
export default {
  props: ["goodInfo"],
  data() {
    return {
      optGoodInfo: {
        goodId: this.goodInfo.id,
        size: 1, //默认选择中码
        buyCount: 1,
        price: this.goodInfo.price
      },
      curGoodInfo: this.goodInfo
    };
  },
  computed: {},
  created() {
    console.log(this.goodInfo);
  },
  methods: {
    optSize(index) {
      this.optGoodInfo.size = index;
    },
    addToCar() {
      if (!this.$store.state.global.token.trim()) {
        let router = this.$router;
        this.$layer.open({
          btn: ["是", "否"],
          content: "您尚未登录，是否先登录~",
          shade: true,
          yes(index) {
            router.push("/login");
            // 函数返回 false 可以阻止弹层自动关闭，需要手动关闭
            // return false;
          },
          no() {
            // obj.routerSelf.replace("/cart");
          }
        });
      } else {
        let idExist = this.theGoodExisted(
          this.$store.state.cart.items,
          this.optGoodInfo
        );

        if (idExist > -1) {
          this.$layer.msg("商品已经存在于购物车中");
          return;
        }
        this.$store.dispatch("cart/addToCar", {
          optGoodInfo: this.optGoodInfo,
          layer: this.$layer,
          routerSelf: this.$router
        });
      }
    },
    // ...mapActions('addToCar',this.optGoodInfo),
    closeSelf() {
      this.$emit("closeCover");
    },
    increment() {
      this.optGoodInfo.buyCount =
        this.buyCount > this.curGoodInfo.rest
          ? this.optGoodInfo.buyCount
          : this.optGoodInfo.buyCount + 1;
    },
    decrement() {
      this.optGoodInfo.buyCount =
        this.optGoodInfo.buyCount > 1
          ? this.optGoodInfo.buyCount - 1
          : this.optGoodInfo.buyCount;
    },
    //判断购物车中是否已经存在商品了
    theGoodExisted(c, g) {
      if (!c.length) return -1;
      for (var i = 0; c[i]; i++) {
        if (c[i]["goodId"] === g.goodId) {
          return i;
        }
      }
      return -1;
    }
  }
};
</script>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  /* .fade-leave-active below version 2.1.8 */
  opacity: 0;
}
.dialog {
  position: relative;
  color: #2e2c2d;
  font-size: 16px;
}
/* 遮罩 设置背景层，z-index值要足够大确保能覆盖，高度 宽度设置满 做到全屏遮罩 */
.dialog-cover {
  background: rgba(182, 178, 172, 0.5);
  position: fixed;
  z-index: 200;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
#layer1 {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  z-index: 211;
  background-color: #ffffff;
  border: none;
  -webkit-animation-duration: 0.5s;
  animation-duration: 0.5s;
}
#layer1 .my-table-view-cell {
  padding: 8px 13px;
  border-bottom: 1px solid rgba(206, 206, 206, 0.5);
}

#layer1 .my-table-view-cell p {
  line-height: 30px;
}

#layer1 img.my-media-object {
  line-height: 60px;
  max-width: 60px;
  height: 60px;
  border: 1px solid #cecece;
}

.buyNum-box > span {
  position: relative;
  bottom: -0.3rem;
}

.buyNum-box .optNum-btn > div {
  display: inline-block;
  padding: 5px 8px;
  height: 1.1rem;
  line-height: 0.85rem;
  /*border: 1px solid #cecece;*/
  border-top: 1px solid #cecece;
  border-bottom: 1px solid #cecece;
  border-left: 1px solid #cecece;
}

.optNum-btn > div:last-child {
  border-right: 1px solid #cecece;
}

.optNum-btn > div:nth-child(2) {
  padding: 5px 10px;
}

#layer1 .group-btn span.btn:first-child {
  background-color: rgba(255, 165, 0, 1);
}

#layer1 .group-btn span.btn:last-child {
  background-color: rgba(230, 20, 20, 1);
}

#layer1 .opt-box {
  flex-wrap: wrap !important;
}

#layer1 .selected {
  border: 1px solid #ffffff !important;
  color: #ffffff;
  background-color: rgba(255, 140, 0, 1);
}

#layer1 .opt-box div.size {
  padding: 4px 15px;
  margin: 0 4px 5px 0;
  border: 1px solid #cecece;
  -moz-border-radius: 6px;
  -ms-border-radius: 6px;
  -o-border-radius: 6px;
  border-radius: 6px;
  font-size: 0.3rem;
}
.group-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-flex-flow: row nowrap;
  flex-flow: row nowrap;
  height: 1.5rem;
  line-height: 1.5rem;
  text-align: center;
}
.group-btn > .btn {
  display: inline-block;
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.my-table-view-cell {
  position: relative;
  overflow: hidden;
  padding: 11px 15px;
  -webkit-touch-callout: none;
}
</style>
