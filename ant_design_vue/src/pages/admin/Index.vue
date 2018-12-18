<template>
  <a-layout id="components-layout-demo-fixed-sider">
    <a-layout-sider :style="{ overflow: 'auto', height: '100vh', position: 'fixed', left: 0 }" :trigger="null" collapsible v-model="collapsed" collapse="collapse">
      <div class="logo"></div>
      <a-menu theme="dark" mode="inline" :defaultSelectedKeys="['sub1']">
        <a-menu-item key="sub1">
          <a-icon type="user"/>
          <span>nav 1</span>
        </a-menu-item>
        <a-sub-menu key="sub2">
          <span slot="title">
            <a-icon type="user"/>
            <span>subnav 1</span>
          </span>
          <a-menu-item key="1">
            <router-link :to="{path:'/test1',query:{}}">option1</router-link>
          </a-menu-item>
          <a-menu-item key="2">
            <router-link :to="{path:'/test2',query:{}}">option2</router-link>
          </a-menu-item>
          <a-menu-item key="3">
            <router-link :to="{path:'/test3',query:{}}">option3</router-link>
          </a-menu-item>
          <a-menu-item key="4">
            <router-link :to="{path:'/test4',query:{}}">option4</router-link>
          </a-menu-item>
        </a-sub-menu>
        <a-sub-menu key="sub3">
          <span slot="title">
            <a-icon type="laptop"/>
            <span>subnav 2</span>
          </span>
          <a-menu-item key="5">option5</a-menu-item>
          <a-menu-item key="6">option6</a-menu-item>
          <a-menu-item key="7">option7</a-menu-item>
          <a-menu-item key="8">option8</a-menu-item>
        </a-sub-menu>
        <a-sub-menu key="sub4">
          <span slot="title">
            <a-icon type="notification"/>
            <span>subnav 3</span>
          </span>
          <a-menu-item key="9">option9</a-menu-item>
          <a-menu-item key="10">option10</a-menu-item>
          <a-menu-item key="11">option11</a-menu-item>
          <a-menu-item key="12">option12</a-menu-item>
        </a-sub-menu>
        <a-sub-menu key="sub5">
          <span slot="title">
            <a-icon type="notification"/>
            <span>subnav 3</span>
          </span>
          <a-menu-item key="9">option9</a-menu-item>
          <a-menu-item key="10">option10</a-menu-item>
          <a-menu-item key="11">option11</a-menu-item>
          <a-menu-item key="12">option12</a-menu-item>
        </a-sub-menu>
        <a-sub-menu key="sub6">
          <span slot="title">
            <a-icon type="notification"/>
            <span>subnav 3</span>
          </span>
          <a-menu-item key="9">option9</a-menu-item>
          <a-menu-item key="10">option10</a-menu-item>
          <a-menu-item key="11">option11</a-menu-item>
          <a-menu-item key="12">option12</a-menu-item>
        </a-sub-menu>
      </a-menu>
    </a-layout-sider>
    <a-layout :style="{ marginLeft: !collapsed?'200px':'80px' }" style="position:relative;">
      <a-layout-header :style="{ background: '#fff'}" style="padding:0 16px;position:fixed;top:0;z-index:5;width:100%;box-shadow:0 2px 8px #f0f1f2;">
        <div>
          <a-icon class="trigger" :type="collapsed ? 'menu-unfold' : 'menu-fold'" @click="()=> collapsed = !collapsed"/>
        </div>
        <div style="padding:5px 0;">
          <!-- <a-breadcrumb :routes="routes" style="font-size:16px">
            <template slot="itemRender" slot-scope="{route, params, routes, paths}">
              <span v-if="routes.indexOf(route) === routes.length - 1">{{route.breadcrumbName}}</span>
              <router-link v-else :to="paths.join('/')">{{route.breadcrumbName}}</router-link>
            </template>
          </a-breadcrumb>-->
          <tag-views></tag-views>
        </div>
      </a-layout-header>
      <a-layout-content :style="{ margin: '84px 16px 0', overflow: 'initial' }">
        <div :style="{ padding: '24px', background: '#fff' }" style="min-height:600px;">
          <keep-alive>
            <router-view></router-view>
          </keep-alive>
        </div>
      </a-layout-content>
      <a-layout-footer :style="{ textAlign: 'center' }">Ant Design ©2018 Created by Ant UED</a-layout-footer>
    </a-layout>
  </a-layout>
</template>

<script>
import TagViews from './components/TagsView';
export default {
  components: { TagViews },
  data () {
    return {
      collapsed: false,
      routes: [{
        path: 'index',
        breadcrumbName: '首页'
      }, {
        path: 'first',
        breadcrumbName: '一级面包屑'
      }, {
        path: 'second',
        breadcrumbName: '当前页面'
      }],
    }
  },
  method: {
    collapse (collapsed, type) {
      console.log(collapsed)
    }
  }
}
</script>

<style lang="scss" scoped>
#components-layout-demo-fixed-sider .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px;
}
#components-layout-demo-custom-trigger .trigger:hover {
  color: #1890ff;
}

#components-layout-demo-custom-trigger .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px;
}
</style>
