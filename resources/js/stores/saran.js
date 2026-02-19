import { defineStore } from 'pinia';
import SaranAPI from '../api/saran.js';

export const useSaranStore = defineStore('saran', {
    state: () => ({
        data: {},
        dataS: [],
        count: {},
        dataStat: '',
        dataStatS: '',
        countStat: '',
        update: [],
        updateStat: '',
        rules: [],
        options: [],
    }),

    getters: {
        getData: (state) => state.data,
        getDataS: (state) => state.dataS,
        getCount: (state) => state.count,
        getDataStat: (state) => state.dataStat,
        getDataStatS: (state) => state.dataStatS,
        getCountStat: (state) => state.countStat,
        getUpdate: (state) => state.update,
        getUpdateStat: (state) => state.updateStat,
        getRules: (state) => state.rules,
        getOptions: (state) => state.options,
    },

    actions: {
        async index(p) {
            this.dataStatS = 'loading';
            try {
                const response = await SaranAPI.index(p);
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
                const response = await SaranAPI.create();
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
                const response = await SaranAPI.store(form);
                if (response.data.saved) {
                    this.update = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.update = error.response;
                this.updateStat = 'fail';
            }
        },

        async destroy(id) {
            this.updateStat = 'loading';
            try {
                const response = await SaranAPI.destroy(id);
                if (response.data.deleted) {
                    this.update = response.data;
                    this.updateStat = 'success';
                } else {
                    this.updateStat = 'fail';
                }
            } catch (error) {
                this.update = error.response;
                this.updateStat = 'fail';
            }
        },

        async count() {
            this.countStat = 'loading';
            try {
                const response = await SaranAPI.count();
                this.count = response.data.model;
                this.countStat = 'success';
            } catch (error) {
                this.count = error.response;
                this.countStat = 'fail';
            }
        },

        resetData() {
            this.data = '';
            this.dataStat = '';
        },

        resetDataS() {
            this.dataS = '';
            this.dataStatS = '';
        },
    },
});
