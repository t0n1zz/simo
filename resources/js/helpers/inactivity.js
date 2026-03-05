/**
 * Inactivity timeout: auto-logout after a period of no user activity.
 * Activity = any API request or user interaction (mouse, keyboard, click).
 */

import { useAuthStore } from '../stores/auth';

const LAST_ACTIVITY_KEY = 'simo_last_activity';

// 6 hours in milliseconds (configurable via VITE_INACTIVITY_TIMEOUT_HOURS; 12h = 12)
const INACTIVITY_TIMEOUT_MS = Number(import.meta.env.VITE_INACTIVITY_TIMEOUT_HOURS || 6) * 60 * 60 * 1000;

const CHECK_INTERVAL_MS = 60 * 1000; // check every minute

let activityThrottle = null;
const THROTTLE_MS = 60 * 1000; // update lastActivity at most once per minute for UI events

export function getLastActivity() {
  const s = localStorage.getItem(LAST_ACTIVITY_KEY);
  return s ? parseInt(s, 10) : null;
}

export function updateLastActivity() {
  const now = Date.now();
  localStorage.setItem(LAST_ACTIVITY_KEY, String(now));
  return now;
}

export function clearLastActivity() {
  localStorage.removeItem(LAST_ACTIVITY_KEY);
}

/**
 * Start the inactivity check. Call once after app init.
 * @param {import('vue-router').Router} router
 * @param {import('pinia').Pinia} pinia
 */
export function startInactivityCheck(router, pinia) {
  function doLogout() {
    const authStore = useAuthStore(pinia);
    authStore.logout();
    clearLastActivity();
    if (typeof window !== 'undefined' && window.axios && window.axios.defaults?.headers?.common) {
      delete window.axios.defaults.headers.common['Authorization'];
    }
    router.push({ path: '/login', query: { redirect: router.currentRoute?.fullPath || '/', reason: 'inactivity' } });
  }

  function check() {
    const authStore = useAuthStore(pinia);
    if (!authStore.isLoggedIn) return;

    const last = getLastActivity();
    if (last === null) return; // not set yet (e.g. old session without lastActivity)

    const elapsed = Date.now() - last;
    if (elapsed >= INACTIVITY_TIMEOUT_MS) {
      doLogout();
    }
  }

  setInterval(check, CHECK_INTERVAL_MS);
  check();
}

/**
 * Register global listeners to update last activity on user interaction (throttled).
 * Call once when app mounts (e.g. in admin or app.js).
 */
export function bindActivityListeners() {
  const events = ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart', 'click'];

  function throttledUpdate() {
    if (activityThrottle) return;
    updateLastActivity();
    activityThrottle = setTimeout(() => {
      activityThrottle = null;
    }, THROTTLE_MS);
  }

  events.forEach((ev) => {
    window.addEventListener(ev, throttledUpdate);
  });
}
