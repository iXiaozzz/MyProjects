<template>
    <div class="dialog" id="dialog">
        <div class="dialog-cover" @click="closeSelf"></div>
        <div class="layer-wrap animated bounceInUp">
            <div class="good-info-box flex">
                <div class="good-info-l flex-1">
                    <div class="good-img">
                        <img :src="goodInfo.imgUrl" alt="">
                    </div>
                </div>
                <div class="good-info-r flex-2">
                    <p class="c-red"><i class="iconfont icon-renminbi">{{goodInfo.priceBetween}}</i></p>
                    <p>库存{{goodInfo.rest}}件</p>
                    <p>请选择颜色分类</p>
                </div>
            </div>
            <div class="opt-color-box">
                <div class="t-box">颜色分类</div>
                <div class="color-box flex">
                    <span :class="{default:true,active:index === optInfo.size}" v-for="(item,index) in goodInfo.size" :key="index" @click="optSize(index)">{{item}}</span>
                    <!-- <span class="default">是非得失 </span>
                    <span class="default">个梵蒂冈</span>
                    <span class="default">是否水电费</span>
                    <span class="default">第三方</span>
                    <span class="default">白色</span>
                    <span class="default">胜多负少多少度</span> -->
                </div>
            </div>
            <div class="opt-num-box flex">
                <div class="t-box flex-1" style="padding-bottom:0;">购买数量</div>
                <div class="opt-num flex-2">
                    <span class="iconfont icon-jian btn" @click="jianNum"></span>
                    <span>{{optInfo.buyCount}}</span>
                    <span class="iconfont icon-jia btn" @click="jiaNum"></span>
                </div>
            </div>
            <div class="ok-btn c-bai" @click="okOpt">确定</div>
        </div>
    </div>
</template>

<script>
export default {
  name: "optGoodsStyle",
  props: ["curGoodInfo"],
  data() {
    return {
      goodInfo: this.curGoodInfo,
      optInfo: {
        size: null,
        buyCount: 1
      }
    };
  },
  //   created() {
  //       console.log(this.goodInfo);
  //   },
  //   mounted() {
  //     console.log(this.curGoodInfo);
  //   },
  methods: {
    closeSelf() {
      this.$emit("closeCover");
    },
    optSize(index) {
      this.optInfo.size = index;
    },
    jianNum() {
      if (this.optInfo.buyCount > 1) {
        this.optInfo.buyCount--;
      }
    },
    jiaNum() {
      if (this.optInfo.buyCount < this.goodInfo.rest) {
        this.optInfo.buyCount++;
      }
    },
    okOpt() {
      if (this.optInfo.size != null) {
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
          this.$emit("putOpt", this.optInfo);
        }
      } else {
        this.$layer.msg("请选择商品颜色~");
      }
    }
  }
};
</script>

<style lang="css" scoped>
.dialog {
  position: relative;
  color: #2e2c2d;
  font-size: 16px;
}
/* 遮罩 设置背景层，z-index值要足够大确保能覆盖，高度 宽度设置满 做到全屏遮罩 */
.dialog-cover {
  background: rgba(182, 178, 172, 0.7);
  position: fixed;
  z-index: 200;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.layer-wrap {
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
.good-info-box .good-img {
  width: 90%;
  padding: 4px;
  /* margin-left: 0.5rem; */
  margin-top: -0.6rem;
  border: 1px solid rgba(182, 178, 172, 0.8);
  background-color: #ffffff;
  -moz-border-radius: 0.1rem;
  -ms-border-radius: 0.1rem;
  -o-border-radius: 0.1rem;
  border-radius: 0.1rem;
}
.good-info-box,
.opt-color-box,
.opt-num-box {
  padding: 0.3rem 0 0.3rem 0.5rem;
  border-bottom: 1px solid rgba(182, 178, 172, 0.4);
}

.good-info-box .good-img > img {
  width: 100%;
  max-width: 100%;
}
.good-info-r {
  margin-left: 0.5rem;
  line-height: 0.7rem;
}
.good-info-r > p:nth-of-type(1) > i {
  font-size: 0.6rem;
}
.t-box {
  padding-bottom: 0.15rem;
  font-size: 0.5rem;
}
.opt-color-box .color-box {
  flex-flow: row wrap;
}
.opt-color-box .color-box > span {
  display: block;
  padding: 4px 15px;
  margin: 0 4px 5px 0;
  border: 1px solid #cecece;
  border-radius: 6px;
  font-size: 0.3rem;
  transition: all 0.1s;
}

.active {
  /* border: 1px solid #ffffff; */
  color: #ffffff;
  background-color: rgba(255, 140, 0, 1);
}
.opt-num-box {
  -webkit-box-pack: space-around;
  -ms-flex-pack: space-around;
  -webkit-justify-content: space-around;
  justify-content: space-around;
}
.opt-num-box .opt-num {
  margin-right: 0.1rem;
  text-align: right;
}
.opt-num-box .opt-num span {
  display: inline-block;
  min-width: 1rem;
  text-align: center;
  padding: 0.1rem 0.2rem;
}
.opt-num-box .opt-num .btn {
  background-color: rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(182, 178, 172, 0.4);
}
.ok-btn {
  width: 100%;
  height: 1.2rem;
  line-height: 1.2rem;
  text-align: center;
  background-color: red;
}
</style>

