<template>
  <div id="app">
    <component :is="pageType"></component>
  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld'
import Layout from './pages/layout/index'
import FullPage from './pages/layout/FullPage'
export default {
  name: 'App',
  components: {
    Layout
    , HelloWorld
    , FullPage
  },
  data () {
    return {
      pageType: this.$store.getters.pageType
    }
  },
  mounted () {
    // console.log(this.$store.getters)
  }
}
</script>

<style lang="scss">
@import "@/style/variables.scss";
@import "@/style/mixin.scss";

#app {
  height: 100%;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  font-size: $fz_root;
}
</style>
