<template>
  <div>
    <swiper :swiper="bannerList"></swiper>
    <ul v-infinite-scroll="loadMore" infinite-scroll-disabled="loading" infinite-scroll-distance="10" infinite-scroll-listen-for-event="test" class="goods-list flex">
      <li class="item" v-for="(item, index) in goodsList" :key = "index" >
          <router-link :to="{path:'/detail',query:{ginfo:item}}" >
            <img alt="暂无图片" :src="preUrl+item.f_good_img_path">
          </router-link>
          <div class="intro">
            <p class="pro-info">{{item.f_good_intro}} ({{item.f_good_id}})</p>
            <p class="price-info">
              <i class="iconfont icon-rmb c-red">{{item.f_good_price_now}}</i>
              <s class="c-hui"><i class="iconfont icon-rmb">{{item.f_good_price_past}}</i></s>
            </p>
          </div>
          <div class="sell-info">
            <span class="c-hui sell-num">销售量：{{item.f_good_sale}}</span>
            <span class="iconfont icon-icon2 fr fs12 addCar-btn" @click="clickCarIcon(index)"></span>
          </div>
      </li>
      <mt-spinner class="triple-bounce" :size="50" type="triple-bounce"></mt-spinner>
    </ul>
    <!-- <div ref="layer1" v-show="show">
      <add-to-car :goodInfo="goodInfo" ref="atc"></add-to-car>
    </div> -->
    <!-- <router-view></router-view> -->
    <add-to-car v-if="isAtcShow" :goodInfo="goodInfo" ref="atc" @closeCover="closeCover"></add-to-car>
  </div>
</template>

<script>
import { Toast, InfiniteScroll, Spinner } from "mint-ui";
import Swiper from "../../components/Swiper";
import AddToCar from "../../components/AddToCar";
import { api_unloginHome,api_unloginHomeList } from '../../api/';
export default {
  name: "home",
  components: {
    Swiper,
    Toast,
    InfiniteScroll,
    // spinner,
    AddToCar
  },
  data() {
    return {
      preUrl:'http://www.ixiaozzz.cn:8090',
      message: "",
      page: 1,
      pageSize: 2,
      show: false,
      goodsID: 0,
      load: false,
      goodInfo: "",
      isAtcShow: false,
      hasToken: false,
      bannerList: [
//        {
//          type: "1",
//          img:
//            "http://www.youdingsoft.com/fileUploadsmall/20180119172411843341.jpg",
//          url: ""
//        },
//        {
//          type: "1",
//          img:
//            "http://www.youdingsoft.com/fileUploadsmall/20180119172434968049.jpg",
//          url: ""
//        },
//        {
//          type: "1",
//          img:
//            "http://www.youdingsoft.com/fileUploadsmall/20180119172503906167.jpg",
//          url: ""
//        },
//        {
//          type: "1",
//          img:
//            "http://www.youdingsoft.com/fileUploadsmall/20180119172518390352.jpg",
//          url: ""
//        },
//        {
//          type: "1",
//          img:
//            "http://www.youdingsoft.com/fileUploadsmall/20180119172540250495.jpg",
//          url: ""
//        },
//        {
//          type: "1",
//          img:
//            "http://www.youdingsoft.com/fileUploadsmall/20180119172552359735.jpg",
//          url: ""
//        }
      ],
      goodsList: [],
    };
  },
  beforeCreate() {
    this.$emit("jumpTo", 0, this.$route.meta.title);
  },
  created() {
    this.$http.post(api_unloginHome,{page: this.page,pageSize: this.pageSize}).then(response=>{
      if(response.code === 1){
        this.page++;
        this.bannerList = response.data.bannerList;
        this.goodsList = response.data.goodsList;
      }else{
        this.$layer.alert("请求数据失败~");
      }
    });
  },
  mounted(){

  },
  methods: {
    // jumpToDetail() {
    //   this.$emit("jumpToDetail", false);
    // },
    clickCarIcon(index) {
      //在这里请求该商品数据
      this.goodInfo = this.goodsList[index];
      this.isAtcShow = true;
    },
    loadTop() {
      this.$refs.loadmore.onTopLoaded();
    },
    loadMore() {
      setTimeout(()=>{
        this.$http.post(api_unloginHomeList,{page: this.page,pageSize: this.pageSize}).then(response=>{
          if(response.code === 1){
            this.page++;
            this.goodsList = this.goodsList.concat(response.data.goodsList);
            this.loading = true;
          }else{
            this.$layer.alert("请求数据失败~");
          }
        },1000);
      })

    },
    closeCover() {
      this.isAtcShow = false;
    }
    // toDetail(gid) {
    //   this.$router.replace("/detail?gid=3");
    // }
  }
};
</script>

<style lang="css" scoped>
.triple-bounce {
  text-align: center;
  width: 100%;
}

ul.goods-list {
  flex-flow: wrap !important;
  padding: 5px;
  background-color: rgba(206, 206, 206, 0.2);
}

ul.goods-list > li.item {
  /*-webkit-box-flex: 49%;*/
  -webkit-flex: 49%;
  -ms-flex: 49%;
  flex: 49%;
}

ul.goods-list > li.item:nth-of-type(odd) {
  margin-right: 3px;
}

ul.goods-list > li.item {
  -webkit-flex: 0 0 49%;
  -ms-flex: 0 0 49%;
  flex: 0 0 49%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin-bottom: 0.5rem;
  background-color: #ffffff;
  -webkit-box-shadow: 3px 3px 3px rgba(206, 206, 206, 0.5);
  -moz-box-shadow: 3px 3px 3px rgba(206, 206, 206, 0.5);
  box-shadow: 3px 3px 3px rgba(206, 206, 206, 0.5);
}

ul.goods-list > li.item img {
  width: 100%;
  max-width: 100%;
}

ul.goods-list > li.item .intro {
  padding: 10px 0 3px;
  margin: 0 4px;
  border-bottom: 1px solid #b0b1b3;
}

ul.goods-list > li.item .sell-info {
  padding: 3px;
  font-size: 0.4rem;
}

ul.goods-list > li.item .intro .pro-info {
  margin-bottom: 0.4rem;
  height: 1.6rem;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  word-break: break-all;
  word-wrap: break-word;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.sell-num {
  line-height: 0.9rem;
}
</style>
