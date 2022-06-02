import Vue from "vue";
import App from "./App.vue";
import ElementUI from "element-ui";
import axios from "axios";
import router from "./router";
import store from "./store";
import moment from "moment";
import "./plugins/element.js";
import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css';
import LoadingMixin from './LoadingNotificationMixin'
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
import 'boxicons'
import VueEllipseProgress from 'vue-ellipse-progress';

Vue.component('v-select', vSelect);
Vue.mixin(LoadingMixin)
Vue.use(ElementUI);
Vue.use(Vuesax);
Vue.use(VueEllipseProgress);
Vue.config.productionTip = false;

// Vue.prototype.$url = "http://api.budgetify.com";

axios.defaults.baseURL = 'http://localhost:80/api';
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

axios.defaults.headers.common = {
    Authorization: `Bearer ${localStorage.getItem("token") || null}`,
    //withCredentials: true,
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "*",
    "dataType": "json"
}

new Vue({
    router,
    store,
    render: (h) => h(App),
}).$mount("#app");

