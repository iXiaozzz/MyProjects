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
//登录页面
const Login = r => require.ensure([], () => r(_crmimport('login/Index')));

// 后台页面
const Admin = r => require.ensure([], () => r(_crmimport('admin/Index')));
const Test1 = r => require.ensure([], () => r(_crmimport('test1/Index')));
const Test2 = r => require.ensure([], () => r(_crmimport('test2/Index')));
const Test3 = r => require.ensure([], () => r(_crmimport('test3/Index')));

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
  // 登录
  {
    name: 'login',
    path: '/login',
    component: Login,
    meta: {
      pageType: '',
      title: '登录'
    }
  },
  {
    name: 'admin',
    path: '/admin',
    component: Admin,
    meta: {
      pageType: ''
    },
    children: [{
        path: '',
        component: Test1,
        meta: {
          pageType: '',
          title: 'test1'
        },
      },
      {
        name: 'test1',
        path: '/test1',
        component: Test1,
        meta: {
          pageType: '',
          title: 'test1'
        }
      }, {
        name: 'test2',
        path: '/test2',
        component: Test2,
        meta: {
          pageType: '',
          title: 'test2'
        }
      }, {
        name: 'test3',
        path: '/test3',
        component: Test3,
        meta: {
          pageType: '',
          title: 'test3'
        }
      }
    ]
  }

];

export default new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: constantRouterMap
})
