<template>
  <div>
    <!-- this is think.vue -->
    <div class="slider">
      <mt-swipe :auto="4000">
        <mt-swipe-item class="my-swipe-item">1</mt-swipe-item>
        <mt-swipe-item class="my-swipe-item">2</mt-swipe-item>
        <mt-swipe-item class="my-swipe-item">3</mt-swipe-item>
      </mt-swipe>
    </div>
    <ul>
      <li v-for="(item,index) in person" :key="index">
        <p @click="clickMe(item.info,$event)">{{item.name}}</p>
      </li>
    </ul>
  </div>
</template>
<script>
import { Swipe, SwipeItem } from "mint-ui";
export default {
  name: "think",
  components: { Swipe, SwipeItem },
  data() {
    return {
      name: "",
      age: "",
      p1: {
        age: 12,
        class: 1
      },
      p2: {
        age: 12,
        class: 1
      },
      person: [
        {
          name: "xiao1",
          info: this.p1
        },
        {
          name: "xiao2",
          info: this.p2
        },
        {
          name: "xiao3",
          info: {
            age: 15,
            class: 3
          }
        }
      ]
    };
  },
  beforeCreate() {
    this.$emit("jumpTo", 1, this.$route.meta.title);
  },
  created() {
    /*改变底部导航栏的状态*/
    // this.name = this.$route.query.name;
    // this.age = this.$route.query.age;
  },
  methods: {
    // emitJump(){
    //   this.$emit('jumpTo', 1);
    // }
    clickMe(obj, e) {
      console.log(e.target);
      e.target.style.color = "red";
      console.log(e.currentTarget);
      console.log("p1的值", this.p1);
      console.log(obj);
    }
  }
};
</script>
<style lang="css" scoped>
.mint-swipe {
  height: 10rem;
}
.my-swipe-item {
  line-height: 10rem;
  text-align: center;
  color: #fff;
}
.my-swipe-item:nth-of-type(1) {
  background-color: #0000ff;
}
.my-swipe-item:nth-of-type(2) {
  background-color: #9aff9a;
}
.my-swipe-item:nth-of-type(3) {
  background-color: #ffc1c1;
}
</style>
