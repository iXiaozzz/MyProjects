<template>
  <div class="element-container">
     <el-tree :data="data" :props="defaultProps" @node-click="handleNodeClick"></el-tree>

     <!-- <el-button type="text" @click="dialogVisible = true">点击打开 Dialog</el-button>

     <el-dialog
        title="提示"
        :visible.sync="dialogVisible"
        width="30%">
        <div>这是一段信息</div>
        <el-button @click="openLayer">弹窗</el-button>
        
        <span slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
        </span>
      </el-dialog> -->
    <el-button type="text" @click="outerVisible = true">点击打开外层 Dialog</el-button>
      <el-dialog title="外层 Dialog" :visible.sync="outerVisible">
        <el-dialog
          width="30%"
          title="内层 Dialog"
          :visible.sync="innerVisible"
          append-to-body>
          <input type="text" value="请输入...">
          <el-button>button</el-button>
        </el-dialog>
        <div slot="footer" class="dialog-footer">
          <el-button @click="outerVisible = false">取 消</el-button>
          <el-button type="primary" @click="innerVisible = true">打开内层 Dialog</el-button>
        </div>
      </el-dialog>
  </div>
</template>
<script>
export default {
  data () {
    return {
      data: [],
      defaultProps: {
        children: 'children',
        label: 'name'
      },
      data1: [
        { id: 1, name: "办公管理", pid: 0 },
        { id: 2, name: "请假申请", pid: 1 },
        { id: 3, name: "出差申请", pid: 1 },
        { id: 4, name: "请假记录", pid: 2 },
        { id: 5, name: "系统设置", pid: 0 },
        { id: 6, name: "权限管理", pid: 5 },
        { id: 7, name: "用户角色", pid: 6 },
        { id: 8, name: "菜单设置", pid: 6 },
      ],
      dialogVisible: false,
      outerVisible: false,
      innerVisible: false

    };
  },
  created () {
    this.getTreeData();
  },
  methods: {
    handleNodeClick (data) {
      console.log(data);
    },
    getTreeData () {
      // 删除 所有 children,以防止多次调用
      this.data1.forEach(function (item) {
        delete item.children;
      });
      // 将数据存储为 以 id 为 KEY 的 map 索引数据列
      var map = {};
      this.data1.forEach(function (item) {
        map[item.id] = item;
      });
      //        console.log(map);
      var val = [];
      this.data1.forEach(function (item) {
        // 以当前遍历项，的pid,去map对象中找到索引的id
        var parent = map[item.pid];
        // 好绕啊，如果找到索引，那么说明此项不在顶级当中,那么需要把此项添加到，他对应的父级中
        if (parent) {
          (parent.children || (parent.children = [])).push(item);
        } else {
          //如果没有在map中找到对应的索引ID,那么直接把 当前的item添加到 val结果集中，作为顶级
          val.push(item);
        }
      });
      this.data = val;
      // return val;
    },
    handleClose (done) {
      this.$confirm('确认关闭？')
        .then(_ => {
          done();
        })
        .catch(_ => { });
    }
  }
};
</script>
<style>
</style>

