

require('./bootstrap');

window.Vue = require('vue');

Vue.component('example', require('./components/Example.vue'));
Vue.component('user-table', require('./components/UserTable.vue'));
Vue.component('pegawai-table', require('./components/PegawaiTable.vue'));
Vue.component('rekanan-table', require('./components/RekananTable.vue'));

const app = new Vue({
    el: '#app'
});
