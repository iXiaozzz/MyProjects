// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
// import axios from 'axios'
import VueRouter from 'vue-router'
import routes from './router/router'
import MintUI from 'mint-ui'
import store from './store/'
import 'mint-ui/lib/style.css'
import './config/flexible'
import fastClick from 'fastclick'
import { Loadmore, Toast } from 'mint-ui'
import layer from 'vue2-layer-mobile'
import 'animate.css'
import http from './api/http'
import { getLocalStorage, setLocalStorage } from './utils/commonFunc'
import { api_addTokenTime, api_checkTokenByDb } from './api/'
import VueLazyload from 'vue-lazyload'

// import Qs from 'qs'
// import api from './api/'

// Vue.prototype.$qs = Qs
// Vue.prototype.$http = axios

fastClick.attach(document.body);
Vue.prototype.$http = http;

// Vue.prototype.$api = api
Vue.component(Loadmore.name, Loadmore);
Vue.component(Toast.name, Toast);

Vue.config.productionTip = false;
Vue.config.devtools = true;
Vue.use(VueRouter);
Vue.use(MintUI);
Vue.use(layer);
Vue.use(VueLazyload, {
  preLoad: 2,
  error: '',
  loading: '',
  attempt: 2
});
const router = new VueRouter({
  mode: 'history',
  base: __dirname,
  routes
});
//获取token
let token = getLocalStorage("token");
store.state.global.token = token ? token.token : "";
// console.log(layer)
router.beforeEach((to, from, next) => {
  let token = store.state.global.token;
  if (to.meta.requireAuth) {
    if (token) {
      http.post(api_checkTokenByDb, {
        actionMsg: 'addTokenTime',
        token: token
      }).then(response => {
        if (response.code) {
          switch (response.data.token_status) {
            case 0:
              next({
                path: '/login',
                query: {
                  redirect: to.fullPath
                }
              });
              break;
            case 1:
              store.state.global.token = response.data.token;
              setLocalStorage({
                token: response.data.token
              }, "token");
              next();
              break;
            case 2:
              next();
              break;
            default:
              layer.alert('错误~');
              break;
          }
        } else {
          layer.alert(response.msg);
        }
      })
    } else {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath
        }
      });
    }
  } else {
    next();
  }
});

// router.afterEach((to, form, next) => {

// });
/* eslint-disable no-new */
new Vue({
  router,
  store,
  layer
}).$mount('#app');
