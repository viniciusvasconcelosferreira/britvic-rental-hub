import {createApp} from 'vue';
import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router';
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import App from './components/App.vue';
import {routes} from './router/index';
import mitt from 'mitt';

const emitter = mitt();

const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});


const app = createApp(App);
app.use(router);
app.config.globalProperties.emitter = emitter;
app.mount('#app');
