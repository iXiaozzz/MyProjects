<template>
  <div class="subnav" :style="{top:top+'px',left:left+'px'}">
    <ul>
      <slot></slot>
    </ul>
  </div>
</template>
<script>
export default {
  name:'subnav',
  props:['ptop','pleft'],
  data(){
    return{
      pos:{top:this.ptop,left:this.pleft}
    }
  }
}
</script>
<style>

</style>
