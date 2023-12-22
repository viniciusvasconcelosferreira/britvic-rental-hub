require('./bootstrap');
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Import components
import App from './components/App.vue';
import {routes} from './router';

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});


const app = createApp(App);
app.use(router);
app.mount('#app');
