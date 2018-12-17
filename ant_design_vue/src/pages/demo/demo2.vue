<template>
  <div id="demo2">
    <h2>demo:</h2>
    <ul class="nav">
      <li>菜单1</li>
      <li @mouseover.stop="overNav" @mouseout.stop="outNav" ref="curLi">菜单2</li>
      <li @mouseover.stop="overNav2" @mouseout.stop="outNav2" ref="curLi2">菜单3</li>
      <li>菜单4</li>
      <li>菜单5</li>
    </ul>
    <navbar-item
      v-show="isShow"
      :posLeft = "posLeft" :posTop = "posTop" width="100" :isShow="isShow"
      @changeShow = "changeShow"
    >
      <slot>
        <li>子菜单a</li>
        <li>子菜单b</li>
        <li>子菜单c</li>
        <li>子菜单d</li>
      </slot>
    </navbar-item>
    <navbar-item
      v-show="isShow2"
      :posLeft = "posLeft" :posTop = "posTop" width="100" :isShow="isShow2"
      @changeShow = "changeShow2"
    >
      <slot>
        <li>子菜单1</li>
        <li>子菜单2</li>
        <li>子菜单3</li>
        <li>子菜单4</li>
      </slot>
    </navbar-item>
  </div>
</template>
<script>
  import navbarItem from './components/navbarItem';
  export default {
    name: 'demo2',
    components:{navbarItem},
    data() {
      return {
        isShow: false,
        isShow2: false,
        posLeft: 0,
        posTop: 0
      }
    },
    mounted() {

    },
    methods: {
      overNav() {
        var pos = this.$refs.curLi.getBoundingClientRect();
        // if (!this.posLeft && !this.posTop) {
        this.posLeft = pos.left + pos.width + 5;
        this.posTop = pos.top;
        // }
        this.isShow = true;
      },
      overNav2() {
        var pos = this.$refs.curLi2.getBoundingClientRect();
        // if (!this.posLeft && !this.posTop) {
        this.posLeft = pos.left + pos.width + 5;
        this.posTop = pos.top;
        // }
        this.isShow2 = true;
      },
      outNav(){
        this.isShow = false;
      },
      outNav2(){
        this.isShow2 = false;
      },
      changeShow(value){
        this.isShow = value;
      },
      changeShow2(value){
        this.isShow2 = value;
      }
    }
  }
</script>
<style lang="scss" scoped>

  #demo2 {
    position: relative;
    width: 100%;
    height: 100%;
    /*min-height: 100vh;*/
    background-color: #eee;
    $liHeight: 32px;
    * {
      box-sizing: border-box;
      -webkit-box-sizing: border-box;
    }
    .nav {
      width: 100px;
      background-color: #fff;
      margin: 50px 10%;
      li {
        padding: 10px 3px;
        text-align: center;
        cursor: pointer;
        border-bottom: 1px solid #cecece;
        &:nth-last-of-type(1) {
          border-bottom: none;
        }
      }

    }
    .subnav {
      position: absolute;
      left: 0;
      top: 0;
      width: 100px;
      z-index: 100;
      background-color: greenyellow;
      li {
        padding: 10px 3px;
        text-align: center;
        cursor: pointer;
        border-bottom: 1px solid #cecece;
        &:nth-last-of-type(1) {
          border-bottom: none;
        }
      }
    }

  }


</style>
