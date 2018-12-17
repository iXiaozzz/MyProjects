<template>
  <div>
    <h4>子组件：</h4>
    <span @click="addSubNum">+</span>&nbsp;&nbsp;{{testNum}}&nbsp;&nbsp;<span @click="jianSubNum">-</span>
    <div>{{subNum}}</div>
  </div>
</template>
<script>
  export default {
    name:"test",
    props: ['subNum'],
    data() {
      return {
        testNum: this.subNum
      }
    },
    watch: {
      testNum(newV) {
        this.$emit('subNumChange',newV);
      },
      subNum(newV){
        this.testNum = newV;
      }
    },
    computed: {

    },
    methods: {
      addSubNum() {
        this.testNum++;
      },
      jianSubNum() {
        this.testNum--;
      }
    }
  }
</script>
