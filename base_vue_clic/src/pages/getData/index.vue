<template>
  <div>this is getData page.</div>
</template>
<script>
import { getTestData, getArticle } from '@/api/test'

export default {
  name: 'getData',
  data () {
    return {

    }
  },
  created () {
    getTestData().then(response => {
      console.log(response);
    })

    getArticle().then(response =>{
      console.log(response);
    })
    // axios.get('/article/list').then(res => {
    //   console.log(res);
    // })
  }
}
</script>
<style lang="scss" scoped>
</style>
