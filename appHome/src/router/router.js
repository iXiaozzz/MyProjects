import App from '../App'

const home = r => require.ensure([], () => r(require('../page/home/home')), 'mainpage')
const homeChildOne = r => require.ensure([], () => r(require('../page/home/children/homeChildOne')), 'homeChildOne')
const me = r => require.ensure([], () => r(require('../page/me/me')), 'mainpage')
const find = r => require.ensure([], () => r(require('../page/find/find')), 'mainpage')
const think = r => require.ensure([], () => r(require('../page/think/think')), 'mainpage')
const detail = r => require.ensure([], () => r(require('../page/detail/detail')), 'mainpage')
const cart = r => require.ensure([], () => r(require('../page/cart/cart')), 'cart')
const resume = r => require.ensure([], () => r(require('../page/person/resume')), 'resume')
//登录页面
const login = r => require.ensure([], () => r(require('../page/login/login')), 'login')
const register = r => require.ensure([], () => r(require('../page/register/register')), 'register')

export default [
  {
    path: '/',
    component: App,
    children: [{
      path: '',
      redirect: '/home'
    },
    {
      name: 'home',
      path: '/home',
      component: home,
      meta: {
        'title': '首页'
      },
      children: [{
        path: 'homeChildOne',
        component: homeChildOne
      },
      {
        path: 'homeChildOne',
        component: homeChildOne
      }
      ]
    }, {
      name: 'me',
      path: '/me',
      component: me,
      meta: {
        'title': '我的',
        requireAuth: true
      },
    }, {
      name: 'find',
      path: '/find',
      component: find,
      meta: {
        'title': '发现'
      }
    }, {
      name: 'think',
      path: '/think',
      component: think,
      meta: {
        title: '想法'
      }
    }, {
      name: 'detail',
      path: '/detail',
      component: detail,
      // meta: {
      //   title: '详情'
      // }
    }, {
      name: 'resume',
      path: '/resume',
      component: resume,
      // meta: {
      //   'title': '简历'
      // }
    },
    {
      name: 'cart',
      path: '/cart',
      component: cart,
      meta: {
        requireAuth: true,
        title: '我的购物车'
      }
    },
    {
      name: 'login',
      path: '/login',
      component: login
    },
    {
      name: 'register',
      path: '/register',
      component: register
    },

    //404页面
    {
      path: '*',
      component: 404,
      // meta: {
      //   requiresAuth: true
      // }
    },

    ]
  }]
