// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'

// import 'normalize.css'
// import Element from "element-ui"
// import "element-ui/lib/theme-chalk/index.css"
import Antd from "ant-design-vue"
import "ant-design-vue/dist/antd.css"

import router from './router/'
import store from './store/'
import './utils/flexible'
import './permission'

if (process.env.NODE_ENV === 'development') {
  require('./mock') // simulation data
}
// Vue.use(Element);
Vue.use(Antd)
Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: {
    App
  },
  template: '<App/>'
});
