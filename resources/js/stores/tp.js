import { defineStore } from 'pinia';
import TpAPI from '../api/tp.js';

export const useTpStore = defineStore('tp', {
    state: () => ({
        data: {},
        dataS: [],
        count: {},
        headerDataS: [],
        dataStat: '',
        dataStatS: '',
        headerDataStatS: '',
        countStat: '',
        updateData: [],
        updateStat: '',
        rules: [],
        options: [],
    }),

    getters: {
        getData: (state) => state.data,
        getDataS: (state) => state.dataS,
        getCount: (state) => state.count,
        getHeaderDataS: (state) => state.headerDataS,
        getDataStat: (state) => state.dataStat,
        getDataStatS: (state) => state.dataStatS,
        getHeaderDataStatS: (state) => state.headerDataStatS,
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
                const response = await TpAPI.index(p);
                if (response.data.model) {
                    this.dataS = response.data.model;
                    this.dataStatS = 'success';
                } else {
                    this.dataS = response;
                    this.dataStatS = 'fail';
                }
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexCu(p, id) {
            this.dataStatS = 'loading';
            try {
                const response = await TpAPI.indexCu(p, id);
                if (response.data.model) {
                    this.dataS = response.data.model;
                    this.dataStatS = 'success';
                } else {
                    this.dataS = response;
                    this.dataStatS = 'fail';
                }
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async get() {
            this.dataStatS = 'loading';
            try {
                const response = await TpAPI.get();
                if (response.data.model) {
                    this.dataS = response.data.model;
                    this.dataStatS = 'success';
                } else {
                    this.dataS = response;
                    this.dataStatS = 'fail';
                }
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async getCu(id) {
            this.dataStatS = 'loading';
            try {
                const response = await TpAPI.getCu(id);
                if (response.data.model) {
                    this.dataS = response.data.model;
                    this.dataStatS = 'success';
                } else {
                    this.dataS = response;
                    this.dataStatS = 'fail';
                }
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async getCuHeader(id) {
            this.headerDataStatS = 'loading';
            try {
                const response = await TpAPI.getCu(id);
                this.headerDataS = response.data.model;
                this.headerDataStatS = 'success';
            } catch (error) {
                this.headerDataS = error.response;
                this.headerDataStatS = 'fail';
            }
        },

        async create() {
            this.dataStat = 'loading';
            try {
                const response = await TpAPI.create();
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
                const response = await TpAPI.store(form);
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
                const response = await TpAPI.edit(id);
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

        async update(id, form) {
            this.updateStat = 'loading';
            try {
                const response = await TpAPI.update(id, form);
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
                const response = await TpAPI.destroy(id);
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

        async count() {
            this.countStat = 'loading';
            try {
                const response = await TpAPI.count();
                if (response.data.model) {
                    this.count = response.data.model;
                    this.countStat = 'success';
                } else {
                    this.count = response;
                    this.countStat = 'fail';
                }
            } catch (error) {
                this.count = error.response;
                this.countStat = 'fail';
            }
        },

        resetUpdateStat() {
            this.updateStat = '';
        },
    },
});
