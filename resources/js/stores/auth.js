import { defineStore } from 'pinia';
import { getLocalUser } from '../helpers/auth';

const user = getLocalUser();

export const useAuthStore = defineStore('auth', {
    state: () => ({
        currentUser: user,
        isLoggedIn: !!user,
        isLoading: false,
        isTokenExpired: false,
        authError: null,
        notification: {},
        unreadNotification: '',
        markNotifStat: '',
        tokenExp: null,
        redirect: '/',
        isFromLogin: false,
    }),

    getters: {
        getIsLoading: (state) => state.isLoading,
        getIsLoggedIn: (state) => state.isLoggedIn,
        getIsTokenExpired: (state) => state.isTokenExpired,
        getCurrentUser: (state) => state.currentUser,
        getAuthError: (state) => state.authError,
        getNotification: (state) => state.notification,
        getUnreadNotification: (state) => state.unreadNotification,
        getMarkNotifStat: (state) => state.markNotifStat,
        getTokenExp: (state) => state.tokenExp,
        getRedirect: (state) => state.redirect,
        getIsFromLogin: (state) => state.isFromLogin,
    },

    actions: {
        login() {
            this.isLoading = true;
            this.authError = null;
        },

        loginSuccess(payload) {
            this.authError = null;
            this.isLoggedIn = true;
            this.isLoading = false;
            this.currentUser = Object.assign({}, payload.user, { token: payload.access_token });
            localStorage.setItem('user', JSON.stringify(this.currentUser));
            this.isTokenExpired = false;
            this.isFromLogin = true;
        },

        loginFailed(payload) {
            this.isLoading = false;
            this.authError = payload.error;
        },

        logoutTokenExpired() {
            this.isTokenExpired = true;
        },

        logout() {
            localStorage.removeItem('user');
            this.isLoggedIn = false;
            this.currentUser = null;
        },

        setNotification(data) {
            this.notification = data;
        },

        setUnreadNotification(data) {
            this.unreadNotification = data;
        },

        setMarkNotifStat(status) {
            this.markNotifStat = status;
        },

        setTokenExp(data) {
            this.tokenExp = data;
        },

        setRedirect(data) {
            this.redirect = data;
        },
    },
});
