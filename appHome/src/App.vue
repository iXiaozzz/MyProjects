<template>
  <div id="wrap">
    <my-header v-if="isLayout" :title="title" :isHome="isHome"></my-header>
    <div id="content">
      <!-- <keep-alive> -->
        <transition name="fade" mode="out-in" appear>
          <router-view @jumpTo="changeTitle" @jumpToDetail="toDetail"></router-view>
        </transition>
      <!-- </keep-alive> -->
    </div>
    <my-footer v-if="isLayout">
      <bar-item v-for="(item,index) in barItems"
                :path="item.path" :label="item.label"
                :icon="item.icon" :active="item.active"
                :index="index" :key="index">
      </bar-item>
    </my-footer>
  </div>
  <!-- <div v-else>
    <transition name="fade" mode="out-in" appear>
      <router-view></router-view>
    </transition>
  </div> -->
</template>

<script>
import Bar from "./components/Bar";
import BarItem from "./components/BarItem";
import MyHeader from "./components/MyHeader";
import MyFooter from "./components/MyFooter";

export default {
  components: { Bar, BarItem, MyFooter, MyHeader },
  data() {
    return {
      title: "",
      isHome: true,
      isLayout: true,
      barItems: [
        {
          path: "/home",
          label: "首页",
          icon: "home",
          index: 0,
          active: 1
        },
        {
          path: "/think?name=xiao&&age=24",
          label: "想法",
          icon: "think",
          index: 1,
          active: 0
        },
        {
          path: "/find",
          label: "发现",
          icon: "find",
          index: 2,
          active: 0
        },
        {
          path: "/cart",
          label: "购物车",
          icon: "me",
          index: 3,
          active: 0
        },
        {
          path: "/me",
          label: "我",
          icon: "me",
          index: 4,
          active: 0
        }
      ]
    };
  },
  methods: {
    /*改变标题和底部导航样式*/
    changeTitle(curIndex, t) {
      this.isLayout = true;
      curIndex != 0 ? (this.isHome = false) : (this.isHome = true);
      this.barItems.forEach((item, index) => {
        index === curIndex
          ? ((item.active = 1), (this.title = t))
          : (item.active = 0);
      });
    },
    toDetail(res) {
      this.isLayout = res;
    }
  }
};
</script>

<style lang="css">
@import "./assets/css/common.css";

#wrap {
  position: relative;
  width: 100%;
  height: calc(100vh - 2.701rem);
  margin: 1.2001rem 1px;
  overflow-y: scroll;
  overflow-x: hidden;
  word-break: break-all;
  word-wrap: break-word;
  /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

#content {
  font-size: 0.4rem;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
  opacity: 0;
}
</style>
