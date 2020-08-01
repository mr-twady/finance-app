import App from './components/App.vue';

window.Vue = require('vue');
window.axios = require('axios');
window.AppBaseUrl = process.env.MIX_APP_URL;
window.ApiBaseUrl = process.env.MIX_API_URL;

Vue.prototype.axios = axios;

Vue.filter('formatCurrency', function (value) {
    if(!value) return ''

    value = value.toString()            
    if(value.charAt(0)=='-') 
    return '-$' + value.substr(1, value.length)

    return '+$' + value
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
});
