// require('./bootstrap');
import { createApp } from 'vue';
import router from './router';
import App from '@/App.vue';
// Membuat instance Vue

createApp(App).use(router).mount('#app')