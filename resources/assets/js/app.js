

require('./bootstrap');

window.Vue = require('vue');
//pengelolaan
Vue.component('example', require('./components/Example.vue'));
Vue.component('user-table', require('./components/UserTable.vue'));
Vue.component('pegawai-table', require('./components/PegawaiTable.vue'));
Vue.component('rekanan-table', require('./components/RekananTable.vue'));
Vue.component('kontrak-table', require('./components/KontrakTable.vue'));
Vue.component('faskes-table', require('./components/FaskesTable.vue'));
//pencarian
Vue.component('filter-pegawai', require('./components/PegawaiFilter.vue'));
Vue.component('filter-rekanan', require('./components/RekananFilter.vue'));
Vue.component('filter-kontrak', require('./components/KontrakFilter.vue'));
Vue.component('filter-faskes', require('./components/FaskesFilter.vue'));
Vue.component('filter-rambu', require('./components/RambuFilter.vue'));

Vue.component('coba', require('./components/Coba.vue'));

//qrcode
Vue.component('qrcode-generator', require('./components/QrcodeGenerator.vue'));

const app = new Vue({
    el: '#app'
});
