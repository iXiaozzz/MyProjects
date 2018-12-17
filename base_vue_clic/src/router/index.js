import Vue from "vue";
import VueRouter from 'vue-router'

const _crmimport = require("./_import_crm" + process.env.NODE_ENV)

//异步加载组件
// 404页面
const error404 = r => require.ensure([], () => r(_crmimport('error/404')));

const Layout = r => require.ensure([], () => r(_crmimport('layout/index')));
const Home = r => require.ensure([], () => r(_crmimport('home/index')));
const Add = r => require.ensure([], () => r(_crmimport('home/components/Add')));
const Hlist = r => require.ensure([], () => r(_crmimport('hlist/index')));
const GetData = r => require.ensure([], () => r(_crmimport('getData/index')));
const El = r => require.ensure([], () => r(_crmimport('element/index')));
const Demo1 = r => require.ensure([], () => r(_crmimport('demo/index')));
const Demo2 = r => require.ensure([], () => r(_crmimport('demo/demo2')));
Vue.use(VueRouter)

export const constantRouterMap = [
  {
    path: '*',
    name: 'error404',
    component: error404,
    // meta: {
    //   requiresAuth: true
    // }
  },
  {
    path: '',
    component: Home,
    meta: {
      pageType: 'Layout'
    },
  },
  {
    name: 'home',
    path: '/home',
    component: Home,
    meta: {
      pageType: 'Layout'
    },
    children: [
      {
        name: 'add',
        path: '/add',
        component: Add,
        meta: {
          pageType: 'Layout'
        },
      }
    ]
  },
  {
    name: 'hlist',
    path: '/hlist',
    component: Hlist,
    meta: {
      pageType: 'Layout'
    }
  },
  {
    name: 'getData',
    path: '/getData',
    component: GetData,
    meta: {
      pageType: 'Layout'
    }
  },
  {
    name: 'element',
    path: '/element',
    component: El
  },
  {
    name: 'demo1',
    path: '/demo1',
    component: Demo1,
  },
  {
    name: 'demo2',
    path: '/demo2',
    component: Demo2,
  }

];

export default new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: constantRouterMap
})
