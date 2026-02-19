import { defineStore } from 'pinia';
import NotificationAPI from '../api/notification.js';

export const useNotificationStore = defineStore('notification', {
    state: () => ({
        notification: {},
        unreadNotification: '',
        notifStat: '',
        markNotifStat: '',
        dataS: [],
        count: {},
        dataStatS: '',
        countStat: '',
    }),

    getters: {
        getNotification: (state) => state.notification,
        getUnreadNotification: (state) => state.unreadNotification,
        getNotifStat: (state) => state.notifStat,
        getMarkNotifStat: (state) => state.markNotifStat,
        getDataS: (state) => state.dataS,
        getCount: (state) => state.count,
        getDataStatS: (state) => state.dataStatS,
        getCountStat: (state) => state.countStat,
    },

    actions: {
        async get() {
            this.notifStat = 'loading';

            try {
                const response = await NotificationAPI.get();
                this.notification = response.data.notification;
                this.unreadNotification = response.data.unreadNotification;
                this.notifStat = 'success';
            } catch (error) {
                this.notification = error.response;
                this.notifStat = 'fail';
            }
        },

        async getAll() {
            this.dataStatS = 'loading';

            try {
                const response = await NotificationAPI.getAll();
                this.dataS = response.data.notification;
                this.unreadNotification = response.data.unreadNotification;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async markAllRead() {
            this.markNotifStat = 'loading';

            try {
                await NotificationAPI.markAllRead();
                this.markNotifStat = 'success';
            } catch (error) {
                this.markNotifStat = 'fail';
            }
        },

        async markRead(id) {
            this.markNotifStat = 'loading';

            try {
                await NotificationAPI.markRead(id);
                this.markNotifStat = 'success';
            } catch (error) {
                this.markNotifStat = 'fail';
            }
        },

        pushNotif(data) {
            this.notification.unshift(data);
        },
    },
});
