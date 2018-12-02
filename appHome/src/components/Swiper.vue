<template>
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide" v-for="(item, index) in swiper" :key="index">
        <img :src="item.img" alt="">
      </div>
    </div>
    <div class="swiper-pagination swiper-pagination-bullets"></div>
  </div>
</template>
<script>
  // npm install swiper --save
  import Swiper from "swiper";
  import "../assets/css/swiper.min.css";

  export default {
    name: "swiper",
    data() {
      return {
        mySwiper: null
      };
    },
    props: ["swiper"], //swiper的就是test这个数据传递来的
    methods: {
      _initSwiper() {
        this.mySwiper = new Swiper(".swiper-container", {
          pagination: {
            // 按钮
            el: ".swiper-pagination",
            clickable: false // 分页导航是否可点击
          },
          loop: true, // 环路(无缝滚动)
          speed: 600, // 切换速度
          autoplay: {
            // 自动切换
            delay: 3000, // 自动切换的时间间隔
            stopOnLastSlide: false, // 如果设置为true,当切换到最后一个slide时停止自动切换(loop模式下无效)
            disableOnInteraction: false // 用户操作swiper之后,是否禁止autoplay.默认为true:停止
          }
        });
      },
      _updateSwiper() {
        this.$nextTick(() => {
          this.mySwiper.update(true); //swiper update的方法
        });
      },
      swiperUpdate() {
        if (this.mySwiper) {
          //节点存在
          this._updateSwiper(); //更新
        } else {
          this._initSwiper(); //创建
        }
      }
    },
    watch: {
      //通过props传来的数据 和 组件一加载节点就创建成功 二者不是同步，实时监听的swiper(传递的值)的变化
      swiper() {
        this.swiperUpdate();
      }
    },
    mounted() {
      this.swiperUpdate(); //页面一加载拉去数据创建节点
    }
  };
</script>
<style lang="css">
  .swiper-container .swiper-wrapper > .swiper-slide > img {
    width: 100%;
    max-width: 100%;
  }

  .swiper-slide {
    text-align: center;
  }
</style>
