import { refreshToken } from "./auth.js";
import Token from "./token";
import { getLocalUser } from "./auth";
import { useGlobalStore } from "../stores/global";
import { useAuthStore } from "../stores/auth";

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

	axios.interceptors.response.use(response => {
		const authStore = useAuthStore(pinia);

		if (authStore.isLoggedIn) {
			const currentTime = new Date().getTime() / 1000;
			const user = getLocalUser();
			const token = Token.payload(user.token);

			if (currentTime > token.exp - 600 && !authStore.isLoading) {
				authStore.login();

				refreshToken()
					.then((res) => {
						if (Token.isValid(res.access_token)) {
							authStore.loginSuccess(res);
							return response;
						} else {
							authStore.loginFailed();
							authStore.logout();
							router.push('/login/redirect');
							return Promise.reject(error);
						}
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

		if (error.response.status == 401) {
			authStore.logout();
			router.push('/login/redirect');
		}

		return Promise.reject(error);
	});
}

export function setAuthorization(token) {
	axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}
