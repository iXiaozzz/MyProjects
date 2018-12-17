<template>
  <div>
    <p>this is home page.</p>
    <p>
      <router-link :to="{path:'/add',query:{'id':12,'name':'ixiaozzz'}}">to add</router-link>
    </p>
    
    <p>
      <router-link :to="{path:'/getData'}">to getData</router-link>
    </p>
    <a-button>Click Me</a-button>

    <router-view></router-view>
  </div>
</template>
<script>
export default {
  name: 'home',
  data () {
    return {}
  }
}
</script>
<style lang="scss" scoped>
</style>
