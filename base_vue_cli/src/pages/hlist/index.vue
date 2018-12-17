<template>
  <div>
    <div><router-link :to="{path:'/home'}">to home</router-link></div>
    <div>
        <input type="button" value="-" @click="jianCount">
        <input type="text" :value="getCount">
        <input type="button" value="+" @click="addCount">
    </div>
    <div>
      <el-upload
        class="upload-demo"
        drag
        action="https://jsonplaceholder.typicode.com/posts/"
        multiple
        ref = "upload"
      >
        <i class="el-icon-upload"></i>
        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
        <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
      </el-upload>
      <el-button @click="clearFile">删除文件列表</el-button>
    </div>
    <div>
      <template>
        <el-table
          :data="tableData"
          :border="false"
          row-class-name="test-demo"
          style="width: 100%">
          <el-table-column
            prop="date"
            label="日期"
            width="180">
          </el-table-column>
          <el-table-column
            prop="name"
            label="姓名"
            width="180">
          </el-table-column>
          <el-table-column
            prop="address"
            label="地址">
          </el-table-column>
        </el-table>
      </template>
    </div>
    <div>
      <el-date-picker
        v-model="value1"
        type="date"
        placeholder="选择日期"
        :picker-options="pickerOptions0">
      </el-date-picker>
    </div>
    <div>{{msg}}</div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  name: 'hlist',
  data () {
    return {
      // count:
      msg:'sfsd',
      tableData: [{
        date: '2016-05-02',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1518 弄'
      }, {
        date: '2016-05-04',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1517 弄'
      }, {
        date: '2016-05-01',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1519 弄'
      }, {
        date: '2016-05-03',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1516 弄'
      }],
      pickerOptions0: {
        disabledDate(time) {
          return time.getTime() < Date.now() - 8.64e7;
        }
      },
      value1:''
    }
  },
  created () {
    console.log(this.$store.getters.count)
    this.$nextTick(()=>{
      this.msg = 'hello world'
    })
  },
  computed: {
    getCount () {
      return this.$store.getters.count;
    },
    ...mapGetters([
      "count"
    ])

  },
  methods: {
    jianCount () {
      this.$store.dispatch('jianCount', 'jian');
    },
    addCount () {
      this.$store.dispatch('addCount', 'add');
    },
    clearFile(){
      this.$refs.upload.clearFiles();
    }
  }

}
</script>

<style lang="scss">
  .test-demo{
    th,td{
      border: none;
    }
  }
</style>
