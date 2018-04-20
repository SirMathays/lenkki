
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import VueRouter from 'vue-router';
 
window.Vue.use(VueRouter);

// import VueCountUp from 'vue-countup';
// Vue.component('vuecountup', VueCountUp);

Vue.component('top-list', require('./components/TopList.vue'));
Vue.component('activity-list', require('./components/ActivityList.vue'));
Vue.component('user-avatar', require('./components/UserAvatar.vue'));
Vue.component('activity-modal', require('./components/modals/ActivityModal.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
    	showActivityModal: false,
        activeActivity: null
    },
    methods: {
        showActivity: function(rowId) {
            this.showActivityModal = true;
            this.activeActivity = rowId;
        }
    },
    mounted: function() {
        // 
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
