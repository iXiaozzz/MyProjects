<template>
    <div>
        <div class="input-box">
          <div class="input-box2">
            <p>
                <label for="uname">账号：&nbsp;</label>
                <input id="uname" type="account" name="uname" placeholder="请输入账号" v-model="uname">
            </p>
            <p>
                <label for="upwd">密码：&nbsp;</label>
                <input  id="upwd" type="password" name="upwd" placeholder="请输入密码" v-model="upwd">
            </p>
            <p>
                <label for="reupwd">确认密码：&nbsp;</label>
                <input  id="reupwd" type="repassword" name="reupwd" placeholder="请再次输入密码" v-model="reupwd">
            </p>
          </div>
        </div>
        <div class="login-btn-box">
          <input type="button" value="注册" @click="registerAction">
        </div>
        <div class="link">
            <router-link to="/home">首页</router-link>&nbsp;&nbsp;
            <router-link to="/login">登录</router-link>&nbsp;&nbsp;
        </div>
    </div>
</template>
<script>
// import md5 from 'js-md5';
export default {
  data() {
    return {
      uname: "",
      upwd: ""
    };
  },
  created() {
    this.$emit("jumpToDetail", false);
  },
  methods: {
    registerAction() {
      this.$http.get("/user/login").then(response => {
        console.log(response);
      });
    }
  }
};
</script>
<style lang="css" scoped>
.input-box {
  margin: 4rem auto 0;
  text-align: center;
}
.input-box2 {
  margin: 0 auto;
  width: 80%;
}
.input-box p {
  padding: 0.2rem 0;
}
.link{
  text-align:center;padding: .2rem 0;
}
.login-btn-box {
  text-align: center;
}
.login-btn-box input {
  width: 67%;
}
</style>

