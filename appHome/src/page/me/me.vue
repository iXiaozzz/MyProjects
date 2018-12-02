<template>
    <div id="me">
        <a href="javascript:;" class="my-account">
            <img class="ubg-img" src="../../assets/img/me_head_bg.jpg" alt="">
            <div class="user-box flex">
                <div class="uhead-box flex">
                  <img class="uhead" src="../../assets/img/me_default.jpg" alt="">
                </div>
                <div class="user-info flex">
                  <div>
                    <p class="uname">HELLO</p>
                    <p class="introduce fs4 c-hui my-ellipsis">暂无</p>
                  </div> 
                </div>
                <div class="login-box flex flex-1">
                  <div><a>退出</a></div>
                </div>
            </div>
        </a> 
        <div class="user-behavior bg-bai">
            <ul class="user-behavior-list flex">
              <li>
                <a href="">
                  <p>0</p>
                  <p>收藏的宝贝</p>
                </a>
              </li>
              <li>
                <a href=""> 
                  <p>0</p>
                  <p>收藏的店铺</p>
                </a>
              </li>
              <li>
                <a href="">
                  <p>0</p>
                  <p>我的足迹</p>
                </a>
              </li>
            </ul>
        </div>  

        <div class="order-act bg-bai">
          <ul class="order-act-items flex">
            <li><a href=""><p><i class="iconfont icon-daifukuan"></i></p><p>代付款</p></a></li>
            <li><a href=""><p><i class="iconfont icon-daifahuo"></i></p><p>待发货</p></a></li>
            <li><a href=""><p><i class="iconfont icon-daishouhuo"></i></p><p>待收货</p></a></li>
            <li><a href=""><p><i class="iconfont icon-daipingjia"></i></p><p>待评价</p></a></li>
            <li><a href=""><p><i class="iconfont icon-tuikuanshouhou"></i></p><p>待售后</p></a></li>
          </ul>
          <div class="label-act">
            <a href="">
            <div class="label-act-item flex">
              <div class="icon iconfont icon-quanbudingdan"></div>
              <h4 class="title flex-1">全部订单</h4>
              <div class="arrow"><span>查看全部订单</span>&nbsp;&nbsp;<i class="iconfont icon-dayuhao"></i></div>
            </div>
            </a>
            </div>
        </div>

        <div class="core-entry bg-bai">
          <div class="label-act">
            <a href="">
            <div class="label-act-item flex">
              <div class="icon iconfont icon-gouwuche"></div>
              <h4 class="title flex-1">购物车</h4>
              <div class="arrow"><i class="iconfont icon-dayuhao"></i></div>
            </div>
            </a>
          </div>
           <div class="label-act">
            <a href="">
            <div class="label-act-item flex">
              <div class="icon iconfont icon-sousuo1"></div>
              <h4 class="title flex-1">搜索</h4>
              <div class="arrow"><i class="iconfont icon-dayuhao"></i></div>
            </div>
            </a>
          </div>
        </div>
    </div>
</template>
<script>
// import { mapGetters, mapActions, mapState } from "vuex";

export default {
  name: "me",
   beforeCreate() {
    this.$emit("jumpTo", 4, this.$route.meta.title);
  },
  created() {
    document.getElementById('wrap').style.backgroundColor = 'rgba(239, 238, 236, 1)';
  },
  destroyed() {
     document.getElementById('wrap').style.backgroundColor = '#ffffff';
  }
};
</script>
<style lang="css" scoped>
#me {
  position: relative;
  background-color: rgba(239, 238, 236, 1);
}
.ubg-img {
  width: 100%;
  max-width: 100%;
}
.my-account {
  display: block;
  height: 3rem;
  color: #333;
  position: relative;
  background: -webkit-linear-gradient(top, #e1dace, #dfc8b4);
  border-bottom: 1px solid #c0bbb2;
  overflow: hidden;
}

.my-account .uhead {
  width: 2rem;
  height: 2rem;
  overflow: hidden;
  border-radius: 50%;
}

.my-account .user-box {
  position: absolute;
  top: 0.5rem;
  left: 0;
  width: 100%;
  z-index: 6;
}

.my-account .uhead-box {
  -webkit-box-flex: 2;
  -webkit-flex: 2;
  -ms-flex: 2;
  flex: 2;
  -webkit-justify-content: center;
  -ms-justify-content: center;
  -moz-justify-content: center;
  justify-content: center;
  -webkit-align-items: center;
  -ms-align-items: center;
  -moz-align-items: center;
  align-items: center;
}

.my-account .user-info {
  -webkit-box-flex: 3;
  -webkit-flex: 3;
  -ms-flex: 3;
  flex: 3;
  -webkit-align-items: center;
  -ms-align-items: center;
  -moz-align-items: center;
  align-items: center;
}
.login-box {
  -webkit-justify-content: center;
  -ms-justify-content: center;
  -moz-justify-content: center;
  justify-content: center;
  -webkit-align-items: center;
  -ms-align-items: center;
  -moz-align-items: center;
  align-items: center;
}
.user-behavior-list {
  flex-wrap: wrap;
}
.user-behavior-list > li {
  -webkit-box-flex: 0 1 33.33%;
  -webkit-flex: 0 1 33.33%;
  -ms-flex: 0 1 33.33%;
  flex: 0 1 33.33%;
  text-align: center;
  padding: 0.3rem 0;
}
.order-act-items,.core-entry{
  margin: 1rem 0 0;
}
.order-act-items {
  padding: 0.3rem 0 0.3rem;
  border-bottom: 1px solid rgba(239, 238, 236, 0.7);
}
.order-act-items > li {
  -webkit-box-flex: 0 1 20%;
  -webkit-flex: 0 1 20%;
  -ms-flex: 0 1 20%;
  flex: 0 1 20%;
  text-align: center;
}
.label-act {
  padding: 0.3rem 0.2rem;
}
.label-act-item {
  -webkit-align-items: space-around;
  -ms-align-items: space-around;
  -moz-align-items: space-around;
  align-items: space-around;
}
.label-act-item .icon {
  position: relative;
  margin-right: .2rem;
  /* bottom: -0.05rem; */
}
.core-entry .label-act{
   border-bottom: 1px solid rgba(239, 238, 236, 0.7);
}
.core-entry .label-act:last-of-type{
   border-bottom: none !important;
}
</style>

