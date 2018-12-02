import axios from 'axios'
import Qs from 'qs'

axios.defaults.timeout = 5 * 1000;
//服务器api地址
axios.defaults.baseURL = 'http://139.199.62.95:8090/api/v1';
//本地api地址
// axios.defaults.baseURL = 'http://127.0.0.1:8090/api/v1';


//http request 拦截器
axios.interceptors.request.use(
  config => {
    // const token = getCookie('名称');注意使用的时候需要引入cookie方法，推荐js-cookie
    config.data = config.data;
    config.headers = {
      'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
    };
    // if(token){
    //   config.params = {'token':token}
    // }
    return config;
  },
  error => {
    return Promise.reject(err);
  }
);


//http response 拦截器
axios.interceptors.response.use(
  response => {
    // if (response.data.errCode == 2) {
    //   router.push({
    //     path: "/login",
    //     query: {
    //       redirect: router.currentRoute.fullPath
    //     } //从哪个页面跳转
    //   })
    // }
    return response;
  },
  error => {
    return Promise.reject(error)
  }
)

export default {
  /**
   * 封装get方法
   * @param url
   * @param data
   * @returns {Promise}
   */

  get(url, params = {}) {
    return new Promise((resolve, reject) => {
      axios.get(url, {
          params: params
        })
        .then(response => {
          resolve(response.data);
        })
        .catch(err => {
          reject(err)
        })
    })
  },

  /**
   * 封装post请求
   * @param url
   * @param data
   * @returns {Promise}
   */

  post(url, data = {}) {
    return new Promise((resolve, reject) => {
      axios.post(url, Qs.stringify(data))
        .then(response => {
          resolve(response.data);
        }, err => {
          reject(err)
        })
    })
  },

  /**
   * 封装patch请求
   * @param url
   * @param data
   * @returns {Promise}
   */

  patch(url, data = {}) {
    return new Promise((resolve, reject) => {
      axios.patch(url, data)
        .then(response => {
          resolve(response.data);
        }, err => {
          reject(err)
        })
    })
  },

  /**
   * 封装put请求
   * @param url
   * @param data
   * @returns {Promise}
   */

  put(url, data = {}) {
    return new Promise((resolve, reject) => {
      axios.put(url, data)
        .then(response => {
          resolve(response.data);
        }, err => {
          reject(err)
        })
    })
  }
}
