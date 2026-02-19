import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
// import './helpers/filter.js'; // TODO: Migrate Vue 2 filters to Vue 3 (use methods/computed instead)
import Admin from './admin.vue';
import routes from './routes';
import axios from 'axios';
import moment from 'moment';
import { initialize } from './helpers/general';
import store from './store'; // Vuex store for backward compatibility

console.log('🚀 App.js: Starting initialization...');

// Configure axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
console.log('✅ Axios configured');

// Configure moment
window.moment = moment;
window.moment.locale('id');
console.log('✅ Moment configured');

// Create Pinia store
console.log('📦 Creating Pinia store...');
const pinia = createPinia();
console.log('✅ Pinia created');

// Create Vue Router
console.log('🧭 Creating Vue Router with', routes.length, 'routes...');
const router = createRouter({
  history: createWebHistory('/admins'),
  routes
});
console.log('✅ Router created');

// Create Vue app
console.log('🏗️ Creating Vue app...');
const app = createApp(Admin);
console.log('✅ Vue app created');

// Use plugins
console.log('🔌 Installing Pinia plugin...');
app.use(pinia);
console.log('✅ Pinia installed');

import { filters } from './helpers/filters.js';
app.config.globalProperties.$filters = filters;
console.log('✅ Global filters registered');

// Import and configure Floating Vue (tooltip library)
// TEMPORARILY DISABLED: Not compatible with v-tooltip:position syntax
// TODO: Either migrate all v-tooltip:position to v-tooltip or find compatible library
// import FloatingVue from 'floating-vue';
// import 'floating-vue/dist/style.css';
// console.log('🔌 Installing Floating Vue (tooltip library)...');
// app.use(FloatingVue, {
//   themes: {
//     tooltip: {
//       placement: 'top',
//       delay: { show: 200, hide: 0 }
//     }
//   }
// });
// console.log('✅ Floating Vue installed');

// Register a no-op tooltip directive to prevent errors
// This is a temporary solution until we migrate to a proper tooltip library
console.log('🔧 Registering stub tooltip directive...');
app.directive('tooltip', {
  mounted() {
    // No-op: do nothing, just prevent Vue warnings
  }
});
console.log('✅ Stub tooltip directive registered');

console.log('🔌 Installing Vuex store (backward compatibility)...');
app.use(store);
console.log('✅ Vuex store installed');

console.log('🔌 Installing Router plugin...');
app.use(router);
console.log('✅ Router installed');

// Initialize app (auth guards, etc.)
console.log('⚙️ Initializing helpers (auth guards, axios interceptors)...');
try {
  initialize(pinia, router);
  console.log('✅ Helpers initialized');
} catch (error) {
  console.error('❌ Error initializing helpers:', error);
}

// Mount app
console.log('🎯 Mounting app to #app...');
try {
  app.mount('#app');
  console.log('✅✅✅ APP MOUNTED SUCCESSFULLY! ✅✅✅');
} catch (error) {
  console.error('❌❌❌ ERROR MOUNTING APP:', error);
  console.error('Error stack:', error.stack);
}

// Export for module usage
export { router, pinia, store };