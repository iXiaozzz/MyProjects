<template>
  <div id="header" class="flex">
    <span class="flex-1" v-if="!isHome" @click="goBack"><</span>
    <span class="flex-1" v-else>&nbsp;</span>
    <span class="title">
          {{title}}
    </span>
    <span class="flex-1" v-if="isHome"><router-link to="/login" class="c-bai" style="font-size:.4rem;" v-if="!checkHasToken">登录</router-link></span>
    <span class="flex-1" v-else>&nbsp;</span>
  </div>
</template>
<script>
export default {
  props: ["title", "isHome"],
  data() {
    return {
      hasToken: false
    };
  },
  computed: {
    checkHasToken() {
      return this.$store.state.global.token ? true : false;
      
    }
  },
  methods: {
    goBack() {
      window.history.go(-1);
    }
  }
};
</script>
<style lang="css" scoped>
#header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 1.2rem;
  line-height: 1.2rem;
  text-align: center;
  background-color: rgba(22, 163, 255, 1);
  color: #fff;
  font-size: 0.5rem;
}

#header > span.title {
  -webkit-box-flex: 3;
  -webkit-flex: 3;
  -ms-flex: 3;
  flex: 3;
}
</style>
