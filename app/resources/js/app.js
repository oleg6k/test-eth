require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue
require('vue-resource');

Vue.http.interceptors.push((request, next) => {
  request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

  next();
});

import dashboard from './components/dashboard.vue'

const app = new Vue({
  el: '#app',
  components: { dashboard }
});