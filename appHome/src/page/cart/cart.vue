<template>
    <div id="cart">
        <!-- <p>{{goodsList}}</p> -->
        <div style="padding:.5rem 0;text-align:center;color: rgba(206,206,206,.9)" v-if="!goodsList.length">
          <p>空空如也~</p>
          <p >赶快去添加商品吧~~~</p> 
        </div>
        <div class="item-title flex" v-if="goodsList.length">
            <div class="checkbox-box">
                <input id="item" type="checkbox" @click="checkedAll" :checked="goodsList.length === options.length" >
                <label for="item"></label>
                <span>全选</span>
            </div>
            <div class="edit-btn" @click="inEdit">编辑</div>
        </div>
   
        <div class="goods-list" v-if="goodsList.length">
          <div class="goods-item flex" v-for="(item,index) in goodsList" :key="index">
            <div class="opt-box">
              <input type="checkbox" :checked="options.indexOf(item.goodId)>=0"  v-model="options" :id="index" :value="item.goodId" @click="checkedOne(item.goodId)">
              <label class="input-label" :for="index"></label>
            </div>
            <div class="img-box flex-1">
              <img  src="../../assets/img/goods.jpg" alt="loading...">
            </div>
            <div class="good-info-box flex-2">
               <p class="good-desc my-ellipsis-more">斯蒂芬斯蒂芬说的地方水电费沙发斯蒂芬沙发斯蒂芬水电费</p>
               <p class="c-hui">第三方斯蒂芬斯蒂芬</p>
               <div class="priceAndNum-box flex">
                 <div class="flex-2"><i class="iconfont icon-rmb c-red">{{item.price}}</i></div>
                 <div class="flex-1">&nbsp;</div>
                 <div class="flex-3 optNum-btn">
                   <span class="iconfont icon-jian btn c-hui" type="jian" @click.stop.prevent="jianGoodNum(item.goodId)"></span>
                   <span class="iconfont text buy-count">{{item.buyCount}}</span>
                   <span class="iconfont icon-jia btn" type="add" @click.stop.prevent="addGoodNum(item.goodId)"></span>
                </div>
               </div>
            </div>
          </div>
        </div>
        <div class="settle-box" v-if="goodsList.length">
          <div class="group-btn">
              <div class="bg-hui">
                  <div class="fr count-box" id="count-box" v-if="!isEdit">
                      <p class="text-align-r c-cheng" id="heji">合计:<i class="iconfont icon-renminbi">{{totalPrice}}</i></p>
                      <p class="fs5 c-hui text-align-r tip">无发票</p>
                  </div>
              </div>
              <div :class="{'c-bai':true, 'bg-red':totalPrice,'bg-hui1': !totalPrice}" id="btn-settle" v-if="!isEdit">结算</div>
              <div class="c-bai bg-red" v-if="isEdit" @click="deleteGoods">删除</div>
          </div>
        </div>
    </div>
</template>
<script>
// import { Checklist } from "mint-ui";
import { mapGetters, mapActions, mapState } from "vuex";

export default {
  name: "cart",
  components: {
    // Banner,
    // Checklist
  },
  data() {
    return {
      options: [],
      demo: [1, 2, 3, 4],
      isCheckedAll: false,
      totalPrice: parseFloat(0).toFixed(2),
      isEdit: false
    };
  },
  beforeCreate() {
    this.$emit("jumpTo", 3, this.$route.meta.title);
  },
  computed: mapState({
    goodsList: state => state.cart.items
  }),
  computed: mapGetters({
    goodsList: "cart/getItem"
  }),

  methods: {
    checkedOne(id) {
      let idIndex = this.options.indexOf(id);
      if (idIndex >= 0) {
        //已选择
        this.goodsList.forEach(function(item) {
          if (id == item.goodId) {
            this.totalPrice = (
              parseFloat(this.totalPrice) -
              parseFloat(item.price) * item.buyCount
            ).toFixed(2);
          }
        }, this);
        this.options.splice(idIndex, 1);
      } else {
        //未选
        this.options.push(id);
        this.goodsList.forEach(function(item) {
          if (id == item.goodId) {
            this.totalPrice = (
              parseFloat(this.totalPrice) +
              parseFloat(item.price) * item.buyCount
            ).toFixed(2);
          }
        }, this);
      }
    },
    checkedAll() {
      this.isCheckedAll = !this.isCheckedAll;
      if (this.isCheckedAll) {
        // 全选时
        this.options = [];
        this.totalPrice = 0;
        this.goodsList.forEach(function(item) {
          this.options.push(item.goodId);
          this.totalPrice = (
            parseFloat(this.totalPrice) +
            parseFloat(item.price) * item.buyCount
          ).toFixed(2);
        }, this);
      } else {
        this.totalPrice = 0;
        this.options = [];
      }
    },
    inEdit() {
      this.isEdit = !this.isEdit;
    },
    //删除购物车里面的商品
    deleteGoods() {
      // console.log(this.options)
      this.$store.dispatch("cart/deleteGoods", this.options);
    },
    //减少该商品的数量
    jianGoodNum(gid) {
      // console.log(this.goodsList);
      if (this.options.indexOf(gid) > -1) {
        this.goodsList.forEach(function(item) {
          if (item.goodId == gid) {
            if (item.buyCount > 1) {
              this.totalPrice = (
                parseFloat(this.totalPrice) - parseFloat(item.price)
              ).toFixed(2);
            }
          }
        }, this);
      }
      this.$store.dispatch("cart/jianGoodNum", gid);
    },
    //增加该商品的数量
    addGoodNum(gid) {
      if (this.options.indexOf(gid) > -1) {
        this.goodsList.forEach(function(item) {
          if (item.goodId == gid) {
            this.totalPrice = (
              parseFloat(this.totalPrice) + parseFloat(item.price)
            ).toFixed(2);
          }
        }, this);
      }
      this.$store.dispatch("cart/addGoodNum", gid);
    }
  }
};
</script>

<style lang="css" scoped>
#cart input[type="checkbox"] {
  width: 22px;
  height: 20px;
  opacity: 0;
  position: relative;
  left: 5px;
  top: 3px;
  margin-right: 5px;
}
label {
  position: absolute;
  left: 5px;
  top: 5px;
  width: 20px;
  height: 20px;
  -moz-border-radius: 50%; /* Firefox */
  -webkit-border-radius: 50%; /* Safari 和 Chrome */
  border-radius: 50%; /* Opera 10.5+, 以及使用了IE-CSS3的IE浏览器 */
  border: 1px solid #999;
}
#cart input:checked + label {
  background-color: #19a094;
  border: 1px solid #19a094;
}

#cart input:checked + label::after {
  position: absolute;
  content: "";
  width: 5px;
  height: 10px;
  top: 1px;
  left: 6px;
  border: 2px solid #fff;
  border-top: none;
  border-left: none;
  -ms-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}
.goods-item {
  padding: 8px 8px 8px 15px;
  line-height: 0.65rem;
  border-bottom: 1px solid rgba(206, 206, 206, 0.5);
  /* height: 5rem; */
}
.item-title {
  padding: 8px 15px;
}
.item-title > .checkbox-box {
  -webkit-box-flex: 10;
  -webkit-flex: 10;
  -ms-flex: 10;
  flex: 10;
}
.checkbox-box {
  position: relative;
  line-height: 30px;
}
.edit-btn {
  color: cadetblue;
  line-height: 30px;
  -webkit-box-flex: 1;
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
}
.goods-list .opt-box {
  position: relative;
  width: 25px;
  -webkit-display: flex;
  display: flex;
  -webkit-align-items: center;
  align-items: center;
  -webkit-justify-content: center;
  justify-content: center;
  text-align: center;
}
.goods-list .opt-box label {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.goods-list .img-box {
  padding: 0 8px;
}
.goods-list .img-box img {
  max-width: 100%;
}
.good-desc {
  padding-bottom: 0.1rem;
}
.priceAndNum-box {
  margin-top: 0.25rem;
}
.goods-list .optNum-btn .buy-count {
  min-width: 0.5rem;
}
.optNum-btn {
  text-align: right;
}
.optNum-btn > span {
  padding: 3px;
}

.settle-box {
  position: fixed;
  left: 0;
  bottom: 1.5rem;
  width: 100%;
}
.settle-box .group-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-flex-flow: row nowrap;
  flex-flow: row nowrap;
  height: 2rem;
  line-height: 2rem;
  text-align: center;
}
.bg-hui {
  background-color: rgba(206, 206, 206, 0.3);
}
.bg-hui1 {
  background-color: rgba(206, 206, 206, 1);
}
.bg-red {
  background-color: rgba(230, 20, 20, 0.7);
}
.settle-box .group-btn > div:first-child {
  line-height: 0.8rem;
  -webkit-box-flex: 5;
  -webkit-flex: 5;
  -ms-flex: 5;
  flex: 5;
}
.c-cheng {
  color: rgba(255, 140, 0, 1);
}

.settle-box .group-btn > div:nth-child(2),
.settle-box .group-btn > div:nth-child(3) {
  line-height: 2rem;
  -webkit-box-flex: 1;
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
}
.count-box {
  padding: 0.2rem;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
</style>
