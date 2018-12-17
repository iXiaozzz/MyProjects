<template>
  <div class="demo1">
    <div class="box-box">
      <div class="box box1" :class="{active:isActive,unactive:!isActive}">
        <span class="point" @click="clicked"></span>
      </div>
      <div class="box box2" :class="{active:!isActive,unactive:isActive}">
        <span class="point" @click="clicked"></span>
      </div>
    </div>
    <div class="sider-box">
      <div class="sidebar" :class="{zeroW:changeWidth}">
        <span class="switch" @click="changeW">x</span>
      </div>
      <div class="main" :class="{baiW:changeWidth}"></div>
    </div>

   
    <div class="demo2">
      <input type="text" v-focus>
      <to-do :todos="todos">
        <template slot-scope="slotProps">
          <!-- 为待办项自定义一个模板，-->
          <!-- 通过 `slotProps` 定制每个待办项。-->
          <span v-if="slotProps.todo.isComplete">✓</span>
          {{ slotProps.todo.text }}
        </template>
      </to-do>
    </div>
  </div>
</template>
<script>

import ToDo from './components/ToDo'
export default {
  name: 'demo1',
  components: { ToDo },
  directives: {
    focus: {
      inserted: function (el) {
        el.focus();
      }
    }
  },
  data () {
    return {
      myvideo: null,
      init_num: 0,
      isActive: true,
      changeWidth: false,
      todos: [
        { id: 1, text: '时代俊峰', isComplete: 0 },
        { id: 2, text: '时代俊峰束带结发', isComplete: 1 },
        { id: 3, text: '时代俊峰神鼎飞丹砂', isComplete: 0 }
      ]
    }
  },
  mounted () {
    this.myvideo = document.getElementById('myvideo');
    this.myvideo.addEventListener('play', this.play, false);
    this.myvideo.addEventListener('pause', this.stop, false);
  },
  methods: {
    play () {
      if (this.init_num == 0) {
        this.init_num++;
        console.log(this.init_num)
        // videoPlayNum(videoID);
      }
    },
    stop () {
      if (this.init_num) {
        this.init_num--;
        console.log(this.init_num)
      }
    },
    clicked () {
      this.isActive = !this.isActive;
      console.log(this.isActive)
    },
    changeW () {
      this.changeWidth = !this.changeWidth;
      console.log(this.changeWidth)
    }
  },
  
  beforeDestroy () {
    this.myvideo.removeEventListener('play', this.paly, false);
    this.myvideo.removeEventListener('pause', this.stop, false);
  }
}
</script>
<style lang="scss">
.unactive {
  opacity: 0;
  left: 200px !important;
}
.active {
  opacity: 1;
  left: 300px !important;
}
.demo1 {
  position: relative;
  // text-align: center;
  padding-top: 50px;
  .box-box {
    position: relative;
    height: 300px;
    & > .box:nth-of-type(1) {
      background-color: rgba(220, 220, 220, 0.8);
    }
    & > .box:nth-of-type(2) {
      background-color: rgba(23, 123, 216, 0.5);
    }
    .box {
      position: absolute;
      top: 50px;
      width: 150px;
      height: 200px;
      transition: all 1s;
      & > span.point {
        position: absolute;
        right: 8px;
        top: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: rgba(150, 150, 150, 0.8);
      }

      .box1-move {
        // position: absolute;
        left: 150px;
      }
      .box1 {
        left: 300px;
      }
      .box2 {
        // opacity: 0;
        left: 400px;
      }
    }
  }

  .sider-box {
    width: 100%;
    height: 300px;
    background-color: rgba(230, 230, 230, 0.8);
    .zeroW {
      width: 0 !important;
    }
    .baiW {
      width: 100% !important;
    }
    .sidebar {
      position: relative;
      width: 30%;
      height: 100%;
      float: left;
      background-color: aquamarine;
      transition: width 0.5s ease-out;
      & > span.switch {
        position: absolute;
        top: 0;
        right: -18px;
        width: 20px;
        height: 20px;
        line-height: 15px;
        text-align: center;
        cursor: pointer;
        border-radius: 50%;
        background-color: green;
      }
    }
    .main {
      float: right;
      width: 70%;
      height: 100%;
      background-color: blue;
      transition: width 0.5s ease-out;
    }
  }

  .demo2 {
    position: relative;
    height: 300px;
    .box {
      position: absolute;
      top: 0;
      left: 0;
      width: 2000px;
      height: 100%;
      .box1 {
        float: left;
        width: 500px;
        height: 100%;
        background-color: aqua;
      }
      .box2 {
        float: left;
        width: 1500px;
        height: 100%;
        background-color: blue;
      }
    }
  }
}
.demo2 {
  margin: 20px 10px;
}
</style>

