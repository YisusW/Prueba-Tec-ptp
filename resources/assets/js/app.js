
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('form-bank', require('./components/form-bank.vue'));

Vue.component('form-bayer', require('./components/form-bayer.vue'));

Vue.component('form-payer', require('./components/form-payer.vue'));

const app = new Vue({
    el: '#app'
});
