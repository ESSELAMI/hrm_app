
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
window.Vue = require('vue');

import store from './store/store'
//import Meta from 'vue-meta'
//import lol from './router'
 import Router from 'vue-router'
import { sync } from 'vuex-router-sync'
import createPersistedState from 'vuex-persist'
//Vue.use(Meta)
 Vue.use(Router)

 require('./bootstrap');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
const AdminHome = Vue.component('admin-home', require('./containers/admin/AdminHome'));
const RolesList = Vue.component('roles-list', require('./components/RolesList'));
const PermissionsList = Vue.component('permissions-list', require('./components/PermissionsList'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/', 
      name: 'home',
      component: AdminHome,
      children: [
        {
          // UserProfile will be rendered inside User's <router-view>
          // when /user/:id/profile is matched
          path: '/roles_list',
          component: RolesList
        },
        {
          // UserPosts will be rendered inside User's <router-view>
          // when /user/:id/posts is matched
          path: '/permissions_list',
          component: PermissionsList
        }
      ]
    },
  ]
});

const app = new Vue({
  el: '#app', 
  store,
  router,

});
