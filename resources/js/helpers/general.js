import { refreshToken } from "./auth.js";
import { getLocalUser } from "./auth";
import { useGlobalStore } from "../stores/global";
import { useAuthStore } from "../stores/auth";
import { updateLastActivity, startInactivityCheck, bindActivityListeners } from "./inactivity";

// Refresh token when within this many seconds of expiry (backend sends expires_at as Unix timestamp)
const REFRESH_BUFFER_SECONDS = 600;

export function initialize(pinia, router) {
	router.beforeEach((to, from, next) => {
		const globalStore = useGlobalStore(pinia);
		const authStore = useAuthStore(pinia);

		window.scrollTo(0, 0);
		document.body.classList.remove("modal-open");
		globalStore.setLoading(true);
		authStore.setRedirect(from.fullPath);

		const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
		const currentUser = authStore.currentUser;

		if (requiresAuth && !currentUser) {
			return next({
				path: '/login',
				query: { redirect: to.fullPath }  // Store the full path to redirect the user to after login
			});
		}

		if (to.path == '/login' && currentUser) {
			return next('/');
		}
		next();
	});

	router.afterEach((to, from) => {
		const globalStore = useGlobalStore(pinia);
		globalStore.setLoading(false);
	})

	const authStore = useAuthStore(pinia);
	if (authStore.currentUser) {
		setAuthorization(authStore.currentUser.token);
	}

	// Update last activity on every API request (for inactivity timeout)
	axios.interceptors.request.use((config) => {
		if (authStore.isLoggedIn) {
			updateLastActivity();
		}
		return config;
	});

	axios.interceptors.response.use(response => {
		const authStore = useAuthStore(pinia);

		if (authStore.isLoggedIn) {
			const user = getLocalUser();
			const expiresAt = user?.expires_at; // Unix timestamp from API (Sanctum tokens are not JWT)
			const nowSec = Math.floor(Date.now() / 1000);

			if (expiresAt != null && nowSec > expiresAt - REFRESH_BUFFER_SECONDS && !authStore.isLoading) {
				authStore.login();

				refreshToken()
					.then((res) => {
						authStore.loginSuccess(res);
						return response;
					})
					.catch((error) => {
						authStore.loginFailed();
						authStore.logout();
						router.push('/login/redirect');
						return Promise.reject(error);
					});
			} else {
				return response;
			}
		} else {
			return response;
		}
	}, error => {
		const authStore = useAuthStore(pinia);

		if (error?.response?.status === 401) {
			authStore.logout();
			router.push('/login/redirect');
		}

		return Promise.reject(error);
	});

	// Inactivity auto-logout (e.g. 6–12 hours of no activity)
	startInactivityCheck(router, pinia);
	bindActivityListeners();
}

export function setAuthorization(token) {
	axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}
