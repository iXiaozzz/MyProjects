<template>
  <div id="resume">
    <div class="f-header">
      <p><img class="img-head" src="../../assets/img/icon.png" alt="my head img"></p>
      <h2>张孝军</h2>
      <p class="c-bai">求职web前端</p>
    </div>
    <div class="f-info flex">
      <div class="f-info-item" v-for="(item,index) in dataList0" :key="index">
        <i class="iconfont" :class="[item.icon]"></i>
        <span v-html="item.text"></span>
      </div>
    </div>
    <div class="f-main">
      <div data-scroll-reveal="enter left and move 40px over 2s" class="f-part reveal f-part-1">
        <div class="f-title"><h3>个人简介</h3></div>
        <div class="f-part-content">
          2016年本科毕业，现从事web开发2年，由于前两家公司不是专门的软件公司，所以开发项目都是独立负责一个项目，前端是html、css、javascript，后台开发用的是thinkphp5，对linux也有一定的了解。现想在前端深入学习。个人的github地址：<a
          href="https://github.com/iXiaozzz" target="_blank">https://github.com/iXiaozzz。</a>
        </div>
      </div>
      <div data-scroll-reveal="wait 0.3s, then enter from the left after 0.3s, move 40px, over 2s"
           class="f-part reveal f-part-2">
        <div class="f-title arrow-right">教育经历</div>
        <div class="f-part-content">
          <div class="timeline-block" v-for="(item,index) in dataList1" :key="index">
            <div class="ctimeline-img cd-picture">
              <!-- <img src="/images/point.png" alt="Picture"> -->
              <!-- <span class="point" style=""></span> -->
            </div>
            <div class="ctimeline"></div>
            <span class="item dot-top"></span>
            <div class="r-info">
              <div style="padding-bottom:5px;">
                <span style="margin-left: -30px;">{{item.date}}</span>
              </div>
              <div class="msgBox">
                <div>{{item.msg}}</div>
                <!-- <span class="cd-date">2017-12-16 08:08:08</span> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div data-scroll-reveal="wait 0.2s, then enter right move 40px over 2s after 0.3s" class="f-part reveal f-part-3">
        <div class="f-title arrow-right">工作经历</div>
        <div class="f-part-content">
          <mt-swipe :show-indicators="true" :auto="5000">
            <mt-swipe-item v-for="(item,index) in dataList2" :key="index">
              <div class="job-name">{{item.name}}</div>
              <div class="job-content" v-html="item.content">

              </div>
              <div class="job-time">{{item.date}}</div>
            </mt-swipe-item>
          </mt-swipe>
        </div>
      </div>
      <div data-scroll-reveal="wait 0.1s, then enter left, move 40px, over 2s, wait 0.3s"
           class="f-part reveal f-part-4">
        <div class="f-title arrow-right">项目经验</div>
        <div class="f-part-content">
          <div class="accordion arrows">
            <!--<header class="box">-->
            <!--<label for="acc-close" class="box-title">Accordion menu</label>-->
            <!--</header>-->
            <!--<div v-for="(item,index) in dataList3" :key="index">-->
            <!--<input type="radio" name="accordion" id="cbs1"/>-->
            <!--<section class="box">-->
            <!--<label class="box-title" for="item.id">{{item.title}}</label>-->
            <!--<label class="box-close" for="acc-close"></label>-->
            <!--<div class="box-content">{{item.content}}</div>-->
            <!--</section>-->
            <!--</div>-->
            <input type="radio" name="accordion" id="cb1"/>
            <section class="box">
              <label class="box-title" for="cb1">联通ICT在线支撑平台系统</label>
              <label class="box-close" for="acc-close"></label>
              <div class="box-content">
                <strong>项目描述：</strong><br/>
                  该系统主要用于联通内部部门对各个地区的ICT的项目进行一个管理，对合作伙伴的管理、客户的管理、以及商机流程：商机的录入、审核、合作伙伴筛选、标前决策会到合同的签订等一系列的流程的管理的一个系统。<br/>
                <strong>工作内容：</strong><br/>
                  1. 完成前端页面。<br/>
                  2. 配合后端实现数据交互。<br/>
              </div>
            </section>

            <input type="radio" name="accordion" id="cb3"/>
            <section class="box">
              <label class="box-title" for="cb3">公司官网的制作</label>
              <label class="box-close" for="acc-close"></label>
              <div class="box-content">
                <strong>项目描述：</strong><br/>
                为公司制作了官网，使用了响应式的布局，兼容移动端，独立的网站管理后台，便于公司的人事部发表公司新闻，修改网站的部分局部图片，发表招聘信息。在网址为：<a href="http://www.hntrtx.com" target="_blank">http://www.hntrtx.com</a><br/>
                <strong>项目技术：</strong><br/>
                1.  该网站的部署环境是LAMP环境。<br/>
                2.  前端页面采用了响应式布局。<br/>
                3.  网站的后台页面的使用了layui搭建。<br/>
                4.  整个项目使用的是thinkphp5搭建。<br/>
                5.  部分的数据交互采用api接口的方式。<br/>
                6.  部分页面使用了图片的预加载技术。<br/>
                7.  企业资质、荣誉的图片查看使用了图片查看器。<br/>
              </div>
            </section>
            <input type="radio" name="accordion" id="cb2"/>
            <section class="box">
              <label class="box-title" for="cb2">酒店微信营业额（移动端）</label>
              <label class="box-close" for="acc-close"></label>
              <div class="box-content">
                <strong>项目描述：</strong><br/>
                酒店管理人员关注该公司的公众号，从公众号进入页面，可以查看酒店的本日，本月的营业情况、实时房态，房价走势及详细、业绩监管、续费和评价等功能。该项目主要的功能是数据的展示，其展示的方式有柱状图、折线图和表格。由于基于微信公众号开发，需权限，但可演示。<br/>
                <strong>技术描述：</strong><br/>
                1. mui框架的使用。<br/>
                2. echart的使用。<br/>
                3. 前后端的数据交互方式Ajax+Json。<br/>
                4. 部分数据存储使用了HTML5的LocalStorage的技术<br/>
                5. 使用rem的布局方式。<br/>
                6. thinkphp5的后端开发。<br/>
              </div>
            </section>
            <input type="radio" name="accordion" id="cb4"/>
            <section class="box">
              <label class="box-title" for="cb4">仿写商城demo</label>
              <label class="box-close" for="acc-close"></label>
              <div class="box-content">
                <strong>使用的技术：</strong><br/>
                 1. 前端用的是vue。<br/>
                 2. 后端使用的是php。<br/>
                 <strong>目前完成的功能：</strong><br/>
                 1. 首页商品列表。<br/>
                 2. 登录注册功能。账号：helloz 密码: 123456<br/>
                 3. 加入购物车功能。<br/>
                 4. 购物车列表。<br/>
                 5. 商品详情页。<br/>
                 6. 个人主页。<br/>
                 待续...<br/>
                 在线地址：<a href="http://www.ixiaozzz.cn:8091" target="_blank">http://www.ixiaozzz.cn:8091</a><br/>
              </div>
            </section>
            <input type="radio" name="accordion" id="acc-close"/>
          </div>
        </div>
      </div>
    </div>
    <div data-scroll-reveal="enter bottom, move 40px, over 2s, wait 0.3s" class="f-footer reveal">
      @2018 by iXiaozzz
    </div>
  </div>
</template>

<script>
  //  import '../../assets/css/page/resume.less';
  import scrollReveal from 'scrollreveal';
  import {Swipe, SwipeItem} from 'mint-ui';

  import {setWrapStyle, getWindowWidth} from '../../utils/commonFunc';

  export default {
    name: "resume",
    components: {
      // Banner,
      'mt-swipe': Swipe,
      'mt-swipe-item': SwipeItem
    },
    data() {
      return {
        scrollReveal: scrollReveal(),
        dataList0: [
          {icon: 'icon-nianling', text: '25岁'},
          {icon: 'icon-xingbie', text: '男'},
          {icon: 'icon-youxiang', text: '934170831@qq.com'},
//          {icon: 'icon-weibiaoti-', text: '<a href="https://github.com/iXiaozzz">https://github.com/iXiaozzz</a>'},
        ],
        dataList1: [
          {
            msg: '重庆科技学院'
            , date: '2012.9--2016.6'
          },
//          {
//            msg: '束带结发惊世毒妃'
//            , date: '2008.9--2012.6'
//          },
        ],
        dataList2: [
          {
            name: '湖南天瑞通信技术有限公司'
            , content: '1. 负责公司的软件开发的前端页面的实现及数据交互接口。<br/>2. 了解客户的对产品的需求及客户对需求的更改。<br/>3. 在开发阶段对产品的功能进行测试。<br/>4. 维护公司官网的服务器。'
            , date: '2017.10--2018.9'
          },
          {
            name: '上海余乐计算机有限公司'
            , content: '独立完成公司安排的项目：<br/>1. 负责公司的软件开发的前端页面的实现及数据交互接口。<br/>2. 用thinkphp5实现项目的业务逻辑及数据交互的api接口。<br/>'
            , date: '2016.9--2017.9'
          },
        ],
        dataList3: [
          {
            id: 'cb1',
            title: 'Readme',
            content: 'Click on an item to open. Click on its header or the list header to close.'
          },
          {
            id: 'cb2',
            title: 'Readme too',
            content: 'Add the class \'arrows\' to nav.accordion to add dropdown arrows.'
          },
          {
            id: 'cb3',
            title: 'Readme too too',
            content: 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Quisque finibus tristique nisi, maximus ullamcorper ante finibus eget.'
          },
        ]
      };
    },
    beforeCreate() {
      this.$emit("jumpToDetail", false);
    },
    created() {

    },
    mounted() {
      this.initLayout();
      this.handleResize();
      this.scrollReveal.reveal('.reveal', {
        //动画的时长
        duration: 2000,
        //延迟时间
        delay: 300,
        //动画开始的位置，'bottom', 'left', 'top', 'right'
        origin: 'top',
        //回滚的时候是否再次触发动画
        reset: false,
        //在移动端是否使用动画
        mobile: true,
        //滚动的距离，单位可以用%，rem等
        distance: '0.8rem',
        //其他可用的动画效果
        opacity: 0.001,
        easing: 'ease-in-out', //linear ease-in-out
        scale: 0.9,
      });
      window.addEventListener("resize", this.handleResize, true);
    },
    destroyed() {
      window.removeEventListener("resize", this.handleResize);
    },
    methods: {
      initLayout() {
        let oWrap = document.getElementById('wrap');
        document.title = '个人主页';
        setWrapStyle(oWrap);
      },
      handleResize() {
        let wWin = getWindowWidth();
        let oResume = document.getElementById('resume');
        if (wWin > 900) {
          oResume.style.margin = '0 auto';
          oResume.style.width = wWin * 0.6 + 'px';
          document.body.style.backgroundColor = 'rgba(235,234,231,.7)';
//          this.$layer.alert('建议移动端观看');
        } else {
          oResume.style.width = wWin + 'px';
//          document.body.style.backgroundImage = "none";
        }
      }
    }
  };
</script>
<style lang="scss" scoped>
  $bgColor: rgba(255, 255, 255, .7);
  $mainColor: rgba(187, 159, 144, 1);
  $timePointColor: rgba(187, 159, 144, .6);
  $infoColor: rgba(240, 224, 212, 1);
  /* $arrowRightColor: rgba(27, 192, 152, 1);*/
  $arrowRightColor: rgba(187, 159, 144, .8);
  /*卡片颜色*/
  $cardColor1: rgba(237, 196, 152, 1);
  $cardColor2: rgba(168, 183, 170, 1);
  $cardColor3: rgba(203, 210, 197, 1);
  $cardColor4: rgba(222, 237, 244, 1);
  $cardBoxShadow: rgba(240, 224, 212, .4);
  #resume {
    background-color: $bgColor;
    /*background-size: cover;*/
    /*background-position:bottom center;*/
  }

  .f-header {
    text-align: center;
    padding: 0.7rem 0 .2rem;
    background-color: $mainColor;
    /*background: url("../../assets/img/bg_r_header.jpg") no-repeat;*/
    /*background-size: cover;*/
    /*background-position:bottom center;*/

  }

  .f-header img.img-head {
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 2.4rem;
  }

  .f-info {
    flex-wrap: wrap !important;
    padding: 0.2rem 0.4rem;
    justify-content: center;
    background-color: $infoColor;
  }

  .f-info .f-info-item {
    color: rgba(0, 0, 0, .6);
    font-size: .4rem;
    text-align: center;
    margin-right: .2rem;
  }

  .f-info .f-info-item > i.iconfont {
    color: rgba(0, 0, 0, .8);
    font-weight: bolder;
    font-size: .4rem;
    margin-right: .1rem;
  }

  .f-part-1 .f-part-content {
    /*text-align: center;*/
    text-indent: 2em;
  }

  .f-part-1 .f-title > h3 {
    width: 3rem;
    margin: 0 auto;
    padding-bottom: .1rem;
    border-bottom: 1px dashed $mainColor;
  }

  .f-part-2 .f-part-content {
    text-indent: 2em;
  }

  @media screen and (max-width: 768px) {
    .f-info {
      line-height: .6rem;
    }

    .f-info .f-info-item:nth-of-type(3), .f-info .f-info-item:nth-of-type(4) {
      /*-webkit-box-flex: 1;*/
      -webkit-flex: 0 0 100% !important;
      -ms-flex: 0 0 100% !important;
      flex: 0 0 100% !important;
    }

    .f-info .f-info-item:nth-of-type(1), .f-info .f-info-item:nth-of-type(2) {
      /*-webkit-box-flex: 1;*/
      -webkit-flex: 0 0 50% !important;
      -ms-flex: 0 0 50% !important;
      flex: 0 0 50% !important;
    }

    .f-info .f-info-item:nth-of-type(1) {
      text-align: right;
      padding-right: .1rem;
      margin-right: 0;
    }

    .f-info .f-info-item:nth-of-type(2) {
      text-align: left;
      padding-left: .1rem;
      margin-right: 0;
    }
  }

  .f-part {
    padding: 0.3rem 0;
    margin: 0 0.4rem;
  }

  .f-part-content {
    line-height: 0.6rem;
    /*text-indent: 2em;*/
  }

  .f-part-1 {
    border-bottom: 2px solid $mainColor;
  }

  .f-part .f-title {
    font-size: 0.45rem;
    padding-bottom: 0.2rem;
  }

  .f-part-1 .f-title {
    text-align: center;
  }

  /* 时间轴的样式 */
  .timeline-block {
    position: relative;
  }

  .timeline-block .timeline {
    position: relative;
    text-align: left;
  }

  .timeline-block .timeline::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0.7rem;
    height: 100%;
    width: 0.1rem;
    /* background: url("/images/v-line.png"); */
  }

  .timeline-block .ctimeline {
    position: absolute;
    top: 0.5rem;
    left: 0.6rem;
    width: 1px;
    height: 101%;
    background-color: $mainColor;
  }

  .timeline-block .ctimeline-img {
    position: relative;
    left: 0.4rem;
    top: 0.5rem;
    width: 0.45rem;
    height: 0.45rem;
    background-color: $mainColor;
    border-radius: 50%;
  }

  .timeline-block .cd-date {
    font-size: 12px;
    color: #cccccc;
  }

  .timeline-block .item {
    float: left;
    clear: both;
    margin-bottom: 0.8rem;
  }

  /* 向上的箭头 */
  .timeline-block .dot-top {
    position: relative;
    top: 0.585rem;
    left: 1.5rem;
    font-size: 0;
    line-height: 0;
    border: 0.3rem dashed $infoColor;
    border-top-width: 0;
    border-right-color: transparent;
    border-bottom-style: solid;
    border-left-color: transparent;
  }

  .timeline-block .msgBox {
    border: 2px solid $infoColor;
    width: 100%;
    padding: 2%;
    margin-left: 0.2rem;
    margin-top: 0.15rem;
  }

  .timeline-block .r-info {
    position: relative;
    top: 0px;
    left: 1rem;
    width: 70%;
  }

  .mint-swipe {
    height: 8rem;
    color: #fff;
  }

  .mint-swipe .mint-swipe-item {
    padding: .3rem;
    /*background-color: rgba(237, 196, 152, 1);*/
    -webkit-box-shadow: 0 1px 10px 1px $cardBoxShadow;
    box-shadow: 0 1px 10px 1px $cardBoxShadow;
  }

  .mint-swipe .mint-swipe-item:nth-of-type(1) {
    background-color: $cardColor1;
    /*background-color: rgba(96, 221, 168, 1);*/
  }

  .mint-swipe .mint-swipe-item:nth-of-type(2) {
    background-color: $cardColor2;
  }

  .mint-swipe .mint-swipe-item:nth-of-type(3) {
    background-color: $cardColor3;
  }

  .mint-swipe .mint-swipe-item:nth-of-type(4) {
    background-color: $cardColor4;
  }

  .mint-swipe-item .job-name {
    font-size: .45rem;
  }

  .mint-swipe-item .job-name, .job-content {
    padding: .1rem 0 .2rem;
    font-size: .4rem !important;
    border-bottom: 1px solid rgba(255, 255, 255, 1);
  }

  .mint-swipe-item .job-time {
    text-align: right;
    padding: .3rem 0 .1rem;
  }

  .mint-swipe-item .job-content {
    height: 5.6rem;
    font-size: .45rem;
    color: hsla(0, 0%, 100%, 1);
  }

  .f-footer {
    text-align: center;
    height: 1.5rem;
    line-height: 1.5rem;
    color: #fff;
    background-color: $mainColor;
  }

  /*折叠卡片的样式*/
  .accordion {
    margin: auto;
    width: 100%;
  }

  .accordion input {
    display: none;
  }

  .box {
    position: relative;
    background: white;
    height: 1.5rem;
    line-height: 1.5rem;
    transition: all .15s ease-in-out;
  }

  .box::before {
    content: '';
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    pointer-events: none;
    box-shadow: 0 -1px 0 #e5e5e5, 0 0 2px rgba(0, 0, 0, .12), 0 2px 4px rgba(0, 0, 0, .24);
  }

  header.box {
    background: #00BCD4;
    z-index: 100;
    cursor: initial;
    box-shadow: 0 -1px 0 #e5e5e5, 0 0 2px -2px rgba(0, 0, 0, .12), 0 2px 4px -4px rgba(0, 0, 0, .24);
  }

  header .box-title {
    margin: 0;
    font-weight: normal;
    /*font-size: 16pt;*/
    font-size: .4rem;
    color: white;
    cursor: initial;
  }

  .box-title {
    width: 100%;
    height: 1.5rem;
    line-height: 1.5rem;

    padding: 0 .7rem;
    display: inline-block;
    cursor: pointer;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  .box-content {
    /*width: calc(100% - 40px);*/
    width: 100%;
    padding: .4rem .5rem;
    font-size: .4rem;
    line-height: .7rem;
    /*font-size: 11pt;*/
    color: rgba(0, 0, 0, .54);
    display: none;
  }

  .box-close {
    position: absolute;
    height: 2rem;
    width: 100%;
    top: 0;
    left: 0;
    cursor: pointer;
    display: none;
  }

  input:checked + .box {
    height: auto;
    margin: 16px 0;
    box-shadow: 0 0 6px rgba(0, 0, 0, .16), 0 6px 12px rgba(0, 0, 0, .32);
  }

  input:checked + .box .box-title {
    border-bottom: 1px solid rgba(0, 0, 0, .18);
  }

  input:checked + .box .box-content,
  input:checked + .box .box-close {
    display: inline-block;
  }

  .arrows section .box-title {
    font-size: .4rem !important;
    padding-left: 44px;
    width: calc(100% - .5rem);
  }

  .arrows section .box-title:before {
    position: absolute;
    display: block;
    content: '\203a';
    font-size: .6rem;
    left: 20px;
    top: -2px;
    -webkit-transition: transform .15s ease-in-out;
    -moz-transition: transform .15s ease-in-out;
    -ms-transition: transform .15s ease-in-out;
    -o-transition: transform .15s ease-in-out;
    transition: transform .15s ease-in-out;
    color: rgba(0, 0, 0, .54);
  }

  input:checked + section.box .box-title:before {
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
  }

  /*导航的样式*/
  .f-part .arrow-right {
    position: relative;
    width: 3rem;
    background-color: $arrowRightColor;
    height: 1.17rem;
    line-height: 1.2rem;
    margin-bottom: .5rem;
    text-align: center;
    color: #fff;
  }

  .f-part .arrow-right:after {
    content: "";
    position: absolute;
    right: -.6rem;
    top: 0;
    border-top: .6rem solid transparent;
    border-bottom: .6rem solid transparent;
    border-left: .6rem solid $arrowRightColor;
  }
</style>
