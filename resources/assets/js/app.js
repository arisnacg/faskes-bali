

require('./bootstrap');

window.Vue = require('vue');

Vue.component('example', require('./components/Example.vue'));
Vue.component('pegawai-table', require('./components/PegawaiTable.vue'));

const app = new Vue({
    el: '#app'
});
