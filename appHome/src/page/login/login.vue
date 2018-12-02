<template>
    <div id="login-container">
        <div class="container-top flex">
          <div><router-link to="/home">首页</router-link></div>
          <div>&nbsp;</div>
          <div class="top-right">
            <span :class="{activePage:isLogin}" @click="changeIsLogin(1)">登录</span>
            <span :class="{activePage:!isLogin}" @click="changeIsLogin(0)">注册</span>
          </div>
        </div>
        <div v-if="isLogin">
           <div class="input-box">
            <div class="input-box2">
              <div class="flex input-item">
                <label for="uname"><i class="iconfont icon-guanbi"></i></label>
                <input class="flex-1" id="uname" type="account"  placeholder="请输入账号" v-model="uname">
              </div>
              <div class="flex input-item">
                <label for="upwd"><i class="iconfont icon-zhanghaomima"></i></label>
                <input  id="upwd" type="password"  placeholder="请输入密码" v-model="upwd">
              </div>
            </div>
          </div>
          <div class="login-btn-box">
             <a class="login-btn" @click="loginAction">登录</a>
          </div>
          <div class="link">
            <router-link to="/forgetPwd">忘记密码</router-link>
          </div>
        </div>
        <div v-else>
           <div class="input-box">
            <div class="input-box2">
              <div class="flex input-item">
                <label for="runame"><i class="iconfont icon-guanbi"></i></label>
                <input class="flex-1" id="runame" type="account"  placeholder="请输入账号" v-model="runame">
              </div>
              <div class="flex input-item">
                <label for="rupwd"><i class="iconfont icon-zhanghaomima"></i></label>
                <input  id="rupwd" type="password" placeholder="请输入密码" v-model="rupwd">
              </div>
              <div class="flex input-item">
                <label for="rupwd2"><i class="iconfont icon-zhanghaomima"></i></label>
                <input  id="rupwd2" type="password"  placeholder="请确认密码" v-model="rupwd2">
              </div>
            </div>
          </div>
          <div class="login-btn-box">
             <a class="login-btn" @click="registerAction">注册</a>
          </div>
        </div>
    </div>
</template>
<script>
import md5 from "js-md5";
import { setLocalStorage } from "../../utils/commonFunc";
import { api_login, api_register,api_loginDb } from "../../api/";
export default {
  data() {
    return {
      uname: "",
      upwd: "",
      runame: "",
      rupwd: "",
      rupwd2: "",
      isLogin: true
    };
  },
  beforeCreate() {
    this.$emit("jumpToDetail", false);
  },
  methods: {
    loginAction() {
      if (this.uname.trim() != "") {
        if (this.uname.trim != "") {
          this.$http
            .post(api_loginDb, {
              token: this.$store.state.global.token,
              uname: this.uname,
              upwd: md5(this.upwd)
            })
            .then(response => {
              if (response.code === 1) {
                if (this.$store.state.global.token != response.data.token) {
                  this.$store.state.global.token = response.data.token;
                }
                setLocalStorage({ token: response.data.token }, "token");
                let redirectPath = this.$route.query.redirect;
                redirectPath
                  ? this.$router.replace(redirectPath)
                  : this.$router.replace("/home");
              } else {
                this.$layer.alert(response.msg);
              }
            });
        } else {
          this.$layer.alert("密码不能为空~");
        }
      } else {
        this.$layer.alert("账号不能为空~");
      }
    },
    registerAction() {
      if (this.runame.trim() != "") {
        // if (this.runame.trim().length<6) {
        //   this.$layer.alert("账号过于简单~");
        //   return;
        // }
        if (this.rupwd.trim().length > 5) {
          if (this.rupwd === this.rupwd2) {
            this.$http
              .post(api_register, {
                runame: this.runame,
                rupwd: md5(this.rupwd)
              })
              .then(response => {
                let vm = this;
                if (response.code == 1) {
                  this.$layer.open({
                    btn: ["否", "是"],
                    content: "恭喜您注册成功，是否现在登录~",
                    shade: true,
                    success(layer) {
                      // console.log('成功')
                    },
                    yes(index, $layer) {
                      // console.log('确认')
                      // 函数返回 false 可以阻止弹层自动关闭，需要手动关闭
                      // return false;
                    },
                    no() {
                      this.runame = "";
                      this.rupwd = "";
                      this.rupwd2 = "";
                      vm.changeIsLogin();
                    },
                    end() {
                      // console.log('end')
                    }
                  });
                } else {
                  this.$layer.alert(response.msg);
                }
              });
          } else {
            this.$layer.alert("两次密码不一致~");
            return;
          }
        } else {
          this.$layer.alert("密码过于简单~");
          return;
        }
      } else {
        this.$layer.alert("账号不能为空~");
        return;
      }
    },
    changeIsLogin(flag) {
      flag = flag == 0 ? false : true;
      if (!flag) {
        this.uname = "";
        this.upwd = "";
      } else {
        this.runame = "";
        this.rupwd = "";
        this.rupwd2 = "";
      }
      this.isLogin = flag;
    }
  }
};
</script>
<style lang="css" scoped>
.container-top {
  margin-top: 0.1rem;
  -webkit-justify-content: space-around;
  -moz-justify-content: space-around;
  -ms-justify-content: space-around;
  justify-content: space-around;
}
.top-right {
  /* padding: 0.1rem 0; */
  color: rgba(162, 159, 153, 1);
}
.top-right span {
  padding: 0.05rem 0.1rem;
  transition: all 0.5s;
  border: 1px solid rgba(231, 225, 216, 1);
}
.top-right span:nth-of-type(1) {
  border-right: 0.5px solid rgba(231, 225, 216, 1);
}
.top-right span:nth-of-type(2) {
  border-left: 0.5px solid rgba(231, 225, 216, 1);
}
.activePage {
  background-color: rgba(198, 113, 113, 0.6);
  color: #ffffff;
}
.input-box {
  margin: 4rem auto 0;
  text-align: center;
}
.input-box2,
.login-btn-box,
.link {
  margin: 0 auto;
  width: 80%;
}
.input-box2 label {
  width: 1rem;
  text-align: center;
}
.input-item {
  padding: 0.2rem 0.1rem;
  border: 1px solid rgba(231, 225, 216, 1);
}
.input-item:nth-of-type(1) {
  border-bottom: none;
}
.input-item:nth-of-type(3) {
  border-top: none;
}
.login-btn-box {
  margin-top: 0.2rem;
}
.login-btn {
  display: inline-block;
  padding: 0.2rem 0.1rem;
  width: 100%;
  /* color: #fff; */
  background-color: rgba(231, 225, 216, 1);
}
.login-btn:active {
  box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
}
.input-box p {
  padding: 0.2rem 0;
}
.login-btn-box {
  text-align: center;
}
.login-btn-box input {
  width: 67%;
  outline: none;
}
.link {
  text-align: right;
  padding: 0.2rem 0;
}
#wrap {
  background-color: rgba(229, 229, 229, 0.8) !important;
}
</style>

