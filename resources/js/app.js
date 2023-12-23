import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import App from './components/App.vue';
import {routes} from './router';

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});


const app = createApp(App);
app.use(router);
app.mount('#app');
