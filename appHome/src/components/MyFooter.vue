<template>
  <div id="footer" class="my-navbar flex">
    <slot></slot>
    <!--<router-link to="/home">首页</router-link>-->
    <!--<router-link to="/think">想法</router-link>-->
    <!--<router-link to="/find">发现</router-link>-->
    <!--<router-link to="/me">我</router-link>-->
  </div>
</template>
<script>
  export default {
//   name:'Footer',
    data() {
      return {

      }
    }
  }
</script>
<style lang="css" scoped>
  #footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 1.5rem;
    line-height: 1.5rem;
    border-top: 1px solid rgba(160, 160, 160, .6);
  }

  #footer > div {
    -webkit-box-flex: 1;
    -webkit-flex: 0 1 25%;
    -ms-flex: 0 1 25%;
    flex: 0 1 25%;
    text-align: center;
    font-size: .5rem;
  }
</style>
