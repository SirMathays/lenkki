
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// VUE
import Vue from 'vue';
window.Vue = require('vue');

// VUE ROUTER
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

// OTHER VUE COMPONENTS
Vue.component('top-list', require('./components/TopList.vue'));
Vue.component('activity-list', require('./components/ActivityList.vue'));
Vue.component('user-avatar', require('./components/UserAvatar.vue'));
Vue.component('nav-menu', require('./components/NavMenu.vue'));
Vue.component('nav-drawer', require('./components/NavDrawer.vue'));
Vue.component('activity-modal', require('./components/modals/ActivityModal.vue'));
Vue.component('award-modal', require('./components/modals/AwardModal.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// VUE APP
const app = new Vue({
    el: '#app',
    data: {
        loading: true,
        activeActivity: false,
        unseenAwards: false,
        showMenu: false,
    },
    methods: {
        showActivity: function(rowId) {
            this.activeActivity = rowId;
        },
        checkMedals() {
            var app = this;

            axios.get('/v1/user/unseenAwards?count=true')
                .then(function (resp) {
                    if(resp.data.count > 0) {
                        app.unseenAwards = true;
                    } else {
                        app.unseenAwards = false;
                    }
                })
                .catch(function (resp) {
                    alert("Could not load awards");
                });
        }
    },
    mounted: function() {
        this.loading = false;
        this.checkMedals();
    }
});

// SOME UGLY JQUERY - works though
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

var position = $(window).scrollTop();
$(window).scroll(function() {
  var scroll = $(window).scrollTop();
  if (scroll > position) {
    console.log("scrolling downwards");
  } else {
    console.log("scrolling upwards");
  }
  position = scroll;
});
