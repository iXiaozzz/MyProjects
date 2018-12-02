import Vue from 'vue'
import Router from 'vue-router'

import HelloWorld from '@/components/HelloWorld'
import Apple from '@/components/Apple'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [{
    path: '/hello',
    name: 'HelloWorld',
    component: HelloWorld
  }, {
    path: '/apple/:type',
    name: 'Apple',
    component: Apple
  }]
})
