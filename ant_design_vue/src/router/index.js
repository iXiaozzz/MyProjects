import Vue from "vue";
import VueRouter from 'vue-router';

const _crmimport = require("./_import_crm" + process.env.NODE_ENV);

//异步加载组件
// 404页面
const error404 = r => require.ensure([], () => r(_crmimport('error/404')));

const Layout = r => require.ensure([], () => r(_crmimport('layout/index')));
const Home = r => require.ensure([], () => r(_crmimport('home/index')));
const Add = r => require.ensure([], () => r(_crmimport('home/components/Add')));
const GetData = r => require.ensure([], () => r(_crmimport('getData/index')));

// 后台页面
const Admin = r => require.ensure([], () => r(_crmimport('admin/Index')));

Vue.use(VueRouter);

export const constantRouterMap = [{
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
    children: [{
      name: 'add',
      path: '/add',
      component: Add,
      meta: {
        pageType: 'Layout'
      },
    }]
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
    name: 'admin',
    path: '/admin',
    component: Admin,
    meta: {
      pageType: ''
    }
  },

];

export default new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: constantRouterMap
})
