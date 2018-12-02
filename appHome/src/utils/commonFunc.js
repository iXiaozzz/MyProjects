//公共函数
export function setLocalStorage(objData, name) {
  let strData = JSON.stringify(objData);
  localStorage.setItem(name, strData);
}

//获取本地存储
export function getLocalStorage(name) {
  var data = localStorage.getItem(name); //取值
  return JSON.parse(data); //返回JSON对象
}

export function setSessionStorage(objData, name) {
  var strData = JSON.stringify(objData);
  sessionStorage.setItem(name, strData);
}

//获取本地存储
export function getSessionStorage(name) {
  var data = sessionStorage.getItem(name); //取值
  return JSON.parse(data); //返回JSON对象
}

//获取屏幕宽度
export function getWindowWidth() {
  return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
}
//获取屏幕高度
export function getWindowHeight() {
  return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
}

//项目中可共用的函数
//非app可按钮的页面
export function setWrapStyle(elem){
  elem.style.margin = 0 + 'px';
  elem.style.height = 100 + '%';
}
