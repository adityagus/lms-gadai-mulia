// require('./bootstrap');
import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import router from './router';
import App from '@/App.vue';
import { VueQueryPlugin, QueryClient } from '@tanstack/vue-query';
// Membuat instance Vue
const queryClient = new QueryClient();
const app = createApp(App);
app.use(VueQueryPlugin, { queryClient });
app.use(InstantSearch);
app.use(router);
// Mounting the app to the DOM
app.mount('#app');  