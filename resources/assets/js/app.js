
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import VueRouter from 'vue-router';
import VModal from 'vue-js-modal';
 
window.Vue.use(VueRouter);
Vue.use(VModal);

// import VueCountUp from 'vue-countup';
// Vue.component('vuecountup', VueCountUp);

Vue.component('top-list', require('./components/TopList.vue'));
Vue.component('activity-list', require('./components/ActivityList.vue'));
Vue.component('user-avatar', require('./components/UserAvatar.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
    	showModal: false,
    },
    mounted: function() {
    }
});

$(window).scroll(function () {
    if ($(document).scrollTop() < 30) {
        $('.nav').addClass('faded');
        $('.nav .circle-button').addClass('shadow');
        $('.nav .profile').addClass('shadow');
    } else {
        $('.nav').removeClass('faded');
        $('.nav .circle-button').removeClass('shadow');
        $('.nav .profile').removeClass('shadow');
    }
});
