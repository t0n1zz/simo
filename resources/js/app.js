import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import { vTooltip } from 'floating-vue';
import 'floating-vue/dist/style.css';
import Admin from './admin.vue';
import routes from './routes';
import axios from 'axios';
import moment from 'moment';
import { initialize } from './helpers/general';
import { filters } from './helpers/filters.js';
import './echarts';
import './helpers/veeValidate';

// Configure axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configure moment
window.moment = moment;
window.moment.locale('id');

// Create Pinia store
const pinia = createPinia();

// Create Vue Router
const router = createRouter({
  history: createWebHistory('/admins'),
  routes
});

// Create Vue app
const app = createApp(Admin);

// Use plugins
app.use(pinia);
app.config.globalProperties.$filters = filters;

// Tooltip directive — wraps FloatingVue's vTooltip with support for v-tooltip:position argument syntax
app.directive('tooltip', {
  beforeMount(el, binding, vnode, prevVnode) {
    vTooltip.beforeMount(el, normalizeTooltipBinding(binding), vnode, prevVnode);
  },
  updated(el, binding, vnode, prevVnode) {
    vTooltip.updated(el, normalizeTooltipBinding(binding), vnode, prevVnode);
  },
  beforeUnmount(el, binding, vnode, prevVnode) {
    vTooltip.beforeUnmount(el, binding, vnode, prevVnode);
  },
});
function normalizeTooltipBinding(binding) {
  const value = typeof binding.value === 'string'
    ? { content: binding.value, placement: binding.arg || 'top' }
    : { placement: binding.arg || 'top', ...binding.value };
  return { ...binding, value };
}

app.use(router);

// Initialize app (auth guards, axios interceptors)
initialize(pinia, router);

app.mount('#app');

// Export for module usage
export { router, pinia };