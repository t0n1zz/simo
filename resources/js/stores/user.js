import { defineStore } from 'pinia';
import UserAPI from '../api/user.js';

export const useUserStore = defineStore('user', {
    state: () => ({
        notification: {},
        unreadNotification: '',
        notifStat: '',
        markNotifStat: '',
        data: {},
        dataS: [],
        dataS1: [],
        dataS2: [],
        dataS3: [],
        count: {},
        dataStat: '',
        dataStatS: '',
        dataStatS1: '',
        dataStatS2: '',
        dataStatS3: '',
        countStat: '',
        updateData: [],
        updateStat: '',
        rules: [],
        options: [],
    }),

    getters: {
        getNotification: (state) => state.notification,
        getUnreadNotification: (state) => state.unreadNotification,
        getNotifStat: (state) => state.notifStat,
        getMarkNotifStat: (state) => state.markNotifStat,
        getData: (state) => state.data,
        getDataS: (state) => state.dataS,
        getDataS1: (state) => state.dataS1,
        getDataS2: (state) => state.dataS2,
        getDataS3: (state) => state.dataS3,
        getCount: (state) => state.count,
        getDataStat: (state) => state.dataStat,
        getDataStatS: (state) => state.dataStatS,
        getDataStatS1: (state) => state.dataStatS1,
        getDataStatS2: (state) => state.dataStatS2,
        getDataStatS3: (state) => state.dataStatS3,
        getCountStat: (state) => state.countStat,
        getUpdate: (state) => state.updateData,
        getUpdateStat: (state) => state.updateStat,
        getRules: (state) => state.rules,
        getOptions: (state) => state.options,
    },

    actions: {
        async index(p) {
            this.dataStatS = 'loading';
            try {
                const response = await UserAPI.index(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexActivity(page) {
            this.dataStatS = 'loading';
            try {
                const response = await UserAPI.indexActivity(page);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexCu(p, id) {
            this.dataStatS = 'loading';
            try {
                const response = await UserAPI.indexCu(p, id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexCuPermission(id) {
            this.dataStatS1 = 'loading';
            this.dataStatS2 = 'loading';
            this.dataStatS3 = 'loading';
            try {
                const response = await UserAPI.indexCuPermission(id);
                this.dataS1 = response.data.model1;
                this.dataS2 = response.data.model2;
                this.dataS3 = response.data.model3;
                this.dataStatS1 = 'success';
                this.dataStatS2 = 'success';
                this.dataStatS3 = 'success';
            } catch (error) {
                this.dataS1 = error.response;
                this.dataS2 = error.response;
                this.dataS3 = error.response;
                this.dataStatS1 = 'fail';
                this.dataStatS2 = 'fail';
                this.dataStatS3 = 'fail';
            }
        },

        async indexAll() {
            this.dataStatS = 'loading';
            try {
                const response = await UserAPI.indexAll();
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexPus(id) {
            this.dataStatS = 'loading';
            try {
                const response = await UserAPI.indexPus(id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async getActivity(page, id) {
            this.dataStatS = 'loading';
            try {
                const response = await UserAPI.getActivity(page, id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async create() {
            this.dataStat = 'loading';
            try {
                const response = await UserAPI.create();
                this.data = response.data.form;
                this.rules = response.data.rules;
                this.options = response.data.options;
                this.dataStat = 'success';
            } catch (error) {
                this.data = error.response;
                this.rules = [];
                this.options = [];
                this.dataStat = 'fail';
            }
        },

        async store(form) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.store(form);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async edit(id) {
            this.dataStat = 'loading';
            try {
                const response = await UserAPI.edit(id);
                this.data = response.data.form;
                this.rules = response.data.rules;
                this.options = response.data.options;
                this.dataStat = 'success';
            } catch (error) {
                this.data = error.response;
                this.rules = [];
                this.options = [];
                this.dataStat = 'fail';
            }
        },

        async editHakAkses(id) {
            this.dataStat = 'loading';
            try {
                const response = await UserAPI.editHakAkses(id);
                this.data = response.data.model;
                this.dataStat = 'success';
            } catch (error) {
                this.data = error.response;
                this.dataStat = 'fail';
            }
        },

        async update(id, form) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.update(id, form);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async updateFoto(id, form) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.updateFoto(id, form);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async updateIdentitas(id, form) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.updateIdentitas(id, form);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async updatePassword(id, form) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.updatePassword(id, form);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async updateResetPassword(id) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.updateResetPassword(id);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async updateStatus(id) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.updateStatus(id);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async updateHakAkses(id, form) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.updateHakAkses(id, form);
                if (response.data.saved) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async destroy(id) {
            this.updateStat = 'loading';
            try {
                const response = await UserAPI.destroy(id);
                if (response.data.deleted) {
                    this.updateData = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.updateData = error.response;
                this.updateStat = 'fail';
            }
        },

        async getNotif() {
            this.notifStat = 'loading';
            try {
                const response = await UserAPI.getNotif();
                this.notification = response.data.notification;
                this.unreadNotification = response.data.unreadNotification;
                this.notifStat = 'success';
            } catch (error) {
                this.notification = error.response;
                this.notifStat = 'fail';
            }
        },

        async markAllNotifRead() {
            this.markNotifStat = 'loading';
            try {
                await UserAPI.markAllNotifRead();
                this.markNotifStat = 'success';
            } catch (error) {
                this.markNotifStat = 'fail';
            }
        },

        async markNotifRead(id) {
            this.markNotifStat = 'loading';
            try {
                await UserAPI.markNotifRead(id);
                this.markNotifStat = 'success';
            } catch (error) {
                this.markNotifStat = 'fail';
            }
        },

        async count() {
            this.countStat = 'loading';
            try {
                const response = await UserAPI.count();
                this.count = response.data.model;
                this.countStat = 'success';
            } catch (error) {
                this.count = error.response;
                this.countStat = 'fail';
            }
        },

        resetUpdateStat() {
            this.updateStat = '';
        },

        setHakAkses(key, value) {
            this.data[key] = value;
        },
    },
});
