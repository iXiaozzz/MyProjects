import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import router from './router'
import store from "./store"

router.beforeEach((to, from, next) => {
  NProgress.start();
  let pageType = to.meta.pageType || 'FullPage';
  store.dispatch('updatePageType', pageType);
  next();
})

router.afterEach(transition => {
  NProgress.done();
})
