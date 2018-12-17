<template>
  <div>
     <p>this is home page.</p>
     <p><router-link :to="{path:'/add'}">to add</router-link></p>
     <p><router-link :to="{path:'/hlist'}">to hlist</router-link></p>
     <p><router-link :to="{path:'/getData'}">to getData</router-link></p>
     <p><router-view></router-view></p>
  </div>
</template>
<script>
  export default{
    name: 'home',
    data(){
      return {}
    }
  }
</script>
<style lang="scss" scoped>

</style>
