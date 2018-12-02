<template>
  <div id="find">
     this is find.
  </div>
</template>
<script>

//  import {Swipe, SwipeItem} from 'mint-ui';

  export default {
    name: "find",
    components: {
      // Banner,
//      'mt-swipe': Swipe,
//      'mt-swipe-item': SwipeItem
    },
    data() {
      return {
        showLayer: true,
        show: false,
        isTest: true
      };
    },
    beforeCreate() {
      this.$emit("jumpTo", 2, this.$route.meta.title);
    },
    created() {
      this.getData();
    },
    methods: {
      getData() {
        // this.$http
        //   .post(
        //     "http://192.168.1.177:8089/api/ApiHome/getNewsAllListByLimit",
        //     this.$qs.stringify({
        //       menuId: "all",
        //       page: 1, //得到当前页，
        //       pageSize: 10 //得到每页显示的条数
        //     })
        //   )
        //   .then(function(response) {
        //     console.log(response.data);
        //   })
        //   .catch(function(error) {
        //     console.log(error);
        //   });
      },
      yesFn() {
        this.showLayer = false;
      },
      clickMe() {
        // console.log(this.$refs.layer1.innerHTML)
        this.isTest = !this.isTest;
      }
    }
  };
</script>
<style lang="css" scoped>
  #find {
    background-color: rgba(255, 255, 255, 1);
  }


</style>
