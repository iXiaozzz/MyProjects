<template>
  <div>
    <div id="header" class="flex">
      <span class="flex-1" @click="goBack"><</span>
      <span class="title">
          <!-- {{title}} -->
      </span>
      <span class="flex-1">&nbsp;</span>
    </div>
    <swiper :swiper="bannerList"></swiper>
    <div class="section1 flex">
        <div class="sl flex">
            <div class="sll"><i class="iconfont icon-rmb"></i><span class="fs13">{{curGoodInfo.price}}</span></div>
            <div class="slr">
                <p>985件已售</p>
                <p><s><i class="iconfont icon-rmb">169</i></s></p>
            </div>
        </div>
        <div class="sr"></div>
    </div>
    <section class="section2 bg-bai">
        <div class="flex pdLeft10">
            <div class="sl">
                <p class="my-ellipsis-more">{{curGoodInfo.desc}}</p>
            </div>
            <div class="sr">
                <p><i class="iconfont icon-shoucang"></i></p>
                <p>收藏</p>
            </div>
        </div>
        <div class="tishi">618提前购 满300减30 满500减50</div>
        <div class="notice pdLeft10 c-hong">
            <i class="iconfont icon-youhui fs10" style="margin-right: 5px;"></i>此商品6月18号开卖，请提前加入购物车
        </div>
        <div class="box1">
            <p class="c-hong fs10" style="font-weight: 600;">非常大牌</p>
            <p class="chengnuo">
                            <span><i class="iconfont icon-xuanzeyixuanze c-hong"></i><span
                                    class="c-hui">包邮</span></span>
                <span><i class="iconfont icon-xuanzeyixuanze c-hong"></i><span
                        class="c-hui">退货赔运费</span></span>
                <span><i class="iconfont icon-xuanzeyixuanze c-hong"></i><span
                        class="c-hui">七天退换</span></span>
            </p>
        </div>
    </section>
    <section class="section4 bg-bai marginTop">
        <div class="item box1 fs7">
            <i class="iconfont icon-youhuiquan c-hong"></i>
            <span>领取优惠券</span>
            <span class="fr"><i class="iconfont icon-xiayibu c-hui"></i></span>
        </div>
        <div class="item box2 fs7" id="s4box2">
            <div class="flex">
                <p><i class="iconfont icon-cuxiao1 c-hong"></i><span>生活的根基，是一颗自然的平常心，如同涓涓清流从心底消失，来自我们与世间周遭的人与事和睦妥当相处的道理，它是一种无法言说的愉悦，是不那么确定的事</span>
                </p>
                <div class="xiayibuBox"><i class="iconfont icon-xiayibu c-hui"></i></div>
            </div>
            <div class="flex">
                <p><i class="iconfont icon-xiangou c-hong"></i><span>一直喜欢一种淡雅的心境，说之迷恋，似乎太过，谓之欣赏，又恐不足，只是喜欢着，那样深深浅浅地喜欢着，即使有一天不慎坠入爱恨悲喜的风浪里，却又于无声处嗅到似曾相识的芬芳</span>
                </p>
                <div class="xiayibuBox"><i class="iconfont icon-xiayibu c-hui"></i></div>
            </div>
        </div>
    </section>
    <section class="section5 bg-bai marginTop">
        <p class="fs7">评价(5435)</p>
        <div class="pbox">
            <span>束带结发</span>
            <span>束带结发</span>
            <span>束带结发</span>
            <span>束带结发</span>
            <span>束带结发</span>
        </div>
        <div class="pickComment">
            <div>
                <div class="user">
                    <i class="iconfont icon-renwu fs12" style="position: relative;bottom:-3px;"></i>&nbsp;
                    <span class="fs9">xiao</span>&nbsp;
                    <span>
                        <i class="iconfont icon-zan1 c-red"></i>
                        <i class="iconfont icon-zan1 c-red"></i>
                        <i class="iconfont icon-zan1 c-red"></i>
                    </span>
                </div>
                <div class="comment-content">
                    寂寂红尘，逝去的光阴，伴随一些或深或浅的记忆，如花美眷抵不过似水流年。烟花这样美，因为短暂，所以美到心碎，让人心碎的东西，总是好的，那随后一地寂寞的烟灰，就是结局。
                </div>
                <div class="comment-date c-hui">
                    2017-06-13 &nbsp;&nbsp;大份
                </div>
            </div>
            <div class="look-more"><span class="look-btn fs7" id="look-btn" @click="toCommentPart">查看更多评论</span></div>
        </div>
    </section>
    <section class="section6" ref="commentPart">继续拖动&nbsp;&nbsp;查看图文详情</section>
    <section class="section7">
        <div style="position: relative;" id="nav-container">
            <ul class="nav flex bg-bai" id="nav">
                <li @click="changeNav(1)">详情</li>
                <li @click="changeNav(5)">评价</li>
            </ul>
            <div class="nav-underline c-red" id="nav-underline" ref="navUnderline"></div>
        </div>
        <div class="nav-swiper" id="nav-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-bai" v-if="isGoodIntro">
                    详情页面
                </div>
               <div class="swiper-slide swiper-slide-active" id="comment-container" v-else>
                 <div v-infinite-scroll="loadMore" infinite-scroll-disabled="loading" infinite-scroll-distance="10">
                    <div class="comment-item" v-for="(item,index) in commentList" :key="index">
                      <div class="user">
                          <i class="iconfont icon-character-avatar fs12" style="position: relative;bottom:-3px;"></i>&nbsp;
                          <span class="fs9">{{item.name}}</span>&nbsp;
                          <span>
                              <i class="iconfont icon-zan1 c-red"></i><i class="iconfont icon-zan1 c-red"></i><i class="iconfont icon-zan1 c-red"></i>
                          </span>
                      </div>
                      <div class="comment-content">
                         {{item.commentContent}}
                      </div>
                      <div class="comment-date c-hui">
                          {{item.dateTime}} &nbsp;&nbsp;{{item.size}}
                      </div>
                    </div>
                    <mt-spinner class="triple-bounce" :size="50" type="triple-bounce"></mt-spinner>
                  </div>
                </div>
            </div>
        </div>
    </section>
    <footer id="footer">
        <div class="sl fl" @click="addToCar">加入购物车</div>
        <div class="sr fr fs9" id="buy-btn">购买</div>
        <div class="clear"></div>
    </footer>
    <opt-goods-style v-if="isOptStyle" :curGoodInfo="curGoodInfo" @closeCover="closeCover" @putOpt="putOpt"></opt-goods-style>
  </div>
</template>
<script>
import "../../assets/css/detail.css";
import { InfiniteScroll, Spinner } from "mint-ui";
import Swiper from "../../components/Swiper";
import OptGoodsStyle from "../../components/OptGoodsStyle";
export default {
  name: "detail",
  components: {
    Swiper,
    InfiniteScroll,
    OptGoodsStyle,
    Spinner
  },
  data() {
    return {
      winW: 0,
      winH: 0,
      navStartPos: 0,
      timer: null,
      oContent: null,
      isTop: false,
      isGoodIntro: true,
      isOptStyle: false, //是否显示弹窗
      curGoodInfo: null, //当前商品的信息
      //选择商品的信息
      optGoodInfo: null,
      bannerList: [
        {
          type: "1",
          img:
            "http://www.youdingsoft.com/fileUploadsmall/20180119172411843341.jpg",
          url: ""
        },
        {
          type: "1",
          img:
            "http://www.youdingsoft.com/fileUploadsmall/20180119172434968049.jpg",
          url: ""
        },
        {
          type: "1",
          img:
            "http://www.youdingsoft.com/fileUploadsmall/20180119172503906167.jpg;",
          url: ""
        },
        {
          type: "1",
          img:
            "http://www.youdingsoft.com/fileUploadsmall/20180119172518390352.jpg",
          url: ""
        },
        {
          type: "1",
          img:
            "http://www.youdingsoft.com/fileUploadsmall/20180119172540250495.jpg",
          url: ""
        },
        {
          type: "1",
          img:
            "http://www.youdingsoft.com/fileUploadsmall/20180119172552359735.jpg",
          url: ""
        }
      ],
      commentList: [
        {
          name: "xiao1",
          commentContent: "第十六届法律时代峰峻楼上的积分说多了几分",
          dateTime: "2018-06-01",
          size: "中份"
        },
        {
          name: "xiao2",
          commentContent: "圣诞节福利顺利的交付了商机地方说多了几分",
          dateTime: "2018-07-01",
          size: "小份"
        },
        {
          name: "xiao3",
          commentContent:
            "时代峰峻了商量的会计法胜利大街发顺利的交付顺利的交付",
          dateTime: "2018-07-18",
          size: "中份"
        },
        {
          name: "xiao4",
          commentContent:
            "书法家李沙拉酱豆腐楼上的积分死链接设计费老师束带结发楼上的积分沙拉酱豆腐",
          dateTime: "2018-08-19",
          size: "大份"
        }
      ]
    };
  },
  created() {
    this.$emit("jumpToDetail", false);
  },
  beforeMount(){
    this.curGoodInfo = this.$route.query.ginfo;
    this.optGoodInfo = {
      goodId: this.curGoodInfo.id,
      size: -1, //
      buyCount: 1,
      price: this.curGoodInfo.price
    };
    console.log(this.curGoodInfo);
  },
  mounted() {
//    window.addEventListener("scroll", this.handleScroll, true);
    this.onLoad();
  },
  destroyed() {
//    window.removeEventListener("scroll", this.handleScroll);
  },
  // computed: {},
  methods: {
    onLoad() {
      this.winW =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.body.clientWidth;
      let navUnderlineW = this.winW / 4;
      this.navStartPos = this.winW / 8;
      this.$refs.navUnderline.style.width = navUnderlineW + "px";
      this.$refs.navUnderline.style.webkitTransform =
        "translateX(" + this.navStartPos + "px)";
      this.$refs.navUnderline.style.transform =
        "translateX(" + this.navStartPos + "px)";
      //设置评论部分的高度
      this.winH =
        window.innerHeight ||
        document.documentElement.clientHeight ||
        document.body.Height;
      let headerH = document.getElementById("header").offsetHeight,
        footerH = document.getElementById("footer").offsetHeight,
        navH = document.getElementById("nav").offsetHeight,
        oSwiperSlide = document
          .getElementById("nav-swiper")
          .getElementsByClassName("swiper-slide"),
        oSwiperSlideH = this.winH - headerH - navH - footerH;
      for (let i = 0; oSwiperSlide[i]; i++) {
        oSwiperSlide[i].style.height = oSwiperSlideH + "px";
      }
    },
    loadTop() {
      this.$refs.loadmore.onTopLoaded();
    },
    loadMore() {
      this.loading = true;
      setTimeout(() => {
//        let last = this.list[this.commentList.length - 1];
        for (let i = 1; i <= 2; i++) {
          this.commentList.push({
            name: "xiao" + i,
            commentContent: "第十六届法律时代峰峻楼上的积分说多了几分",
            dateTime: "2018-06-01",
            size: "中份"
          });
        }
        this.loading = false;
      }, 1000);
    },
    goBack() {
      this.$emit("jumpToDetail", true);
      // this.$router.push('/home')
      window.history.go(-1);
    },
    toCommentPart() {
      let top = this.getTop(this.$refs.commentPart);
      document.getElementById('wrap').scrollTop = top;
      this.changeNav(5);
    },
    changeNav(index) {
      index === 1 ? (this.isGoodIntro = true) : (this.isGoodIntro = false);
      let startPos = index * this.navStartPos;
      this.$refs.navUnderline.style.webkitTransform =
        "translateX(" + startPos + "px)";
      this.$refs.navUnderline.style.transform =
        "translateX(" + startPos + "px)";
    },
    getTop(e) {
      let offset = e.offsetTop;
      if (e.offsetParent != null) offset += this.getTop(e.offsetParent);
      return offset;
    },
//    handleScroll() {
//      let tpScrollTop =
//        window.pageYOffset ||
//        document.documentElement.scrollTop ||
//        document.getElementById("wrap").scrollTop;
//      // console.log(tpScrollTop);
//    },
    //关闭弹窗
    closeCover() {
      this.isOptStyle = false;
    },
    //加入购物车
    addToCar() {
      if (this.optGoodInfo.size == -1) {
        this.isOptStyle = true;
      }else{
        this.$layer.alert('已经存在于购物车中~');
      }
    },
    putOpt(data) {
      this.optGoodInfo.size = data.size;
      this.optGoodInfo.buyCount = data.buyCount;
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
      this.isOptStyle = false;
    },
    //判断购物车中是否已经存在商品了
    theGoodExisted(c, g) {
      if (!c.length) return -1;
      for (let i = 0; c[i]; i++) {
        if (c[i]["goodId"] === g.goodId) {
          return i;
        }
      }
      return -1;
    }
  }
};
</script>
<style lang="css" scoped>
.wrap {
  /* height: 100%; */
  height: 100vh;
  /* padding-top: 3rem; */
  /* text-align: center; */
}

#header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 1.2rem;
  line-height: 1.2rem;
  text-align: center;
  /* background-color: rgba(22, 163, 255, 1); */
  background-color: rgba(248, 248, 255, 0.3);
  color: rgba(206, 206, 206, 0.8);
  border-bottom: 1px solid rgba(176, 177, 179, 0.3);
  font-size: 0.5rem;
}

#header > span.title {
  -webkit-box-flex: 3;
  -webkit-flex: 3;
  -ms-flex: 3;
  flex: 3;
}
#nav-swiper .swiper-slide {
  text-align: left;
}
.triple-bounce {
  text-align: center;
  width: 100%;
}
</style>
