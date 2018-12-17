<template>
  <div class="navbarItem-container" :style="{top:posTop+'px',left:posLeft+'px',width:width+'px'}"
       @mouseover.stop="overNavbar" @mouseout.stop="outNavbar"
  >
    <ul>
      <slot></slot>
    </ul>
  </div>
</template>
<script>
  export default {
    props: ['posLeft', 'posTop', 'width'],
    data() {
      return {
        // isShow2: false
      };
    },
    created() {
      this.width = this.width || 100;
    },
    methods:{
      overNavbar(){
        this.$emit('changeShow',true);
      },
      outNavbar(){
        this.$emit('changeShow',false);
      }
    }

  }
</script>
<style lang="scss">
  .navbarItem-container {
    position: absolute;
    z-index: 100;
    background-color: greenyellow;
    li {
      padding: 10px 3px;
      text-align: center;
      cursor: pointer;
      border-bottom: 1px solid #cecece;
      &:nth-last-of-type(1) {
        border-bottom: none;
      }
    }
  }
</style>
