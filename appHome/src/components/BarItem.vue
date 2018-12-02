<template>
  <div>
    <router-link :to="path" :class="{activeC:active}">
      {{label}}
    </router-link>
    <!--<router-view></router-view>-->
  </div>
</template>
<script>
  export default {
    props: ['path', 'label', 'icon', 'active', 'index']
  }
</script>
<style>
  .activeBg {
    background-color: rgba(22, 163, 255, 1);
  }

  .activeC {
    color: rgba(22, 163, 255, 1);
    transition: color .5s;
  }
</style>
