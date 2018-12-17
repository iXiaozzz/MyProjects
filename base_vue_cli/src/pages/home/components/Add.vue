<template>
  <div>
    <div>
      <router-link :to="{path:'/home'}">to home</router-link>
    </div>
    <div>this is add page.</div>
    <div style="margin-top: 20px;">
      <h3>父组件：</h3>
      <span @click="()=>++num">+</span>&nbsp;&nbsp;
      <input type="text" v-model="num">&nbsp;&nbsp;
      <span @click="()=>--num">-</span>
      <test :subNum="num" @subNumChange="updateNum"></test>
    </div>
  </div>
</template>
<script>
  import {mapGetters} from 'vuex'
  import Test from "./test"

  export default {
    name: 'add',
    components: {
      Test
    },
    data() {
      return {
        num: 10
      }
    },
    methods:{
      updateNum(num){
        this.num = num;
      }
    }

  }
</script>

<style>
  span{
    cursor: pointer;
  }
</style>
