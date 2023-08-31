/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import store from "./store/index";

Vue.component('createPost', require('./components/CreatePost.vue'))
Vue.component("example", require("./components/Example.vue"));
Vue.component("firebase-messages", require("./components/Message.vue"));

const app = new Vue({
    el: "#app",
    components: {
        'firebase-messages': require('./components/Message.vue'),
    },
    store
});
