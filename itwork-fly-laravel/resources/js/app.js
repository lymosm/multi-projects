require('./bootstrap');
window.Vue = require("vue");
// import Test from "../views/components/Test.vue";
import App from "./App.vue";
import store from "./store/store";

// vue 2
/*
var app = new Vue({
    el: "#app",
    template: "<div>Vue Test</div>"
});
*/

// vue 3
/*
var app = Vue.createApp({
    data(){
        return {
            message: "Vue"
        }
    }
}).mount("#app");
*/

const app = Vue.createApp(App);
app.use(store);
app.mount("#app");