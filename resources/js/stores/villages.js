import { defineStore } from 'pinia';
import VillagesAPI from '../api/villages.js';

export const useVillagesStore = defineStore('villages', {
    state: () => ({
        data: {}, // single data
        dataS: [], // collection
        dataStat: '',
        dataStatS: '',
        updateData: [], // update data
        updateStat: '',
        rules: [], // laravel rules
        options: [], // laravel options
    }),

    getters: {
        getData: (state) => state.data,
        getDataS: (state) => state.dataS,
        getDataStat: (state) => state.dataStat,
        getDataStatS: (state) => state.dataStatS,
        getUpdate: (state) => state.updateData,
        getUpdateStat: (state) => state.updateStat,
        getRules: (state) => state.rules,
        getOptions: (state) => state.options,
    },

    actions: {
        // load collection with params
        async index(p) {
            this.dataStatS = 'loading';
            try {
                const response = await VillagesAPI.index(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // load collection without params
        async get() {
            this.dataStatS = 'loading';
            try {
                const response = await VillagesAPI.get();
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // Load villages by district id
        // Legacy code expected `indexDistricts`, but the actually
        // working endpoint here is `getDistricts`, so we delegate.
        async indexDistricts(id) {
            this.dataStatS = 'loading';
            try {
                const response = await VillagesAPI.getDistricts(id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // create page
        async create() {
            this.dataStat = 'loading';
            try {
                const response = await VillagesAPI.create();
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

        // store data
        async store(form) {
            this.updateStat = 'loading';
            try {
                const response = await VillagesAPI.store(form);
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

        // edit page
        async edit(id) {
            this.dataStat = 'loading';
            try {
                const response = await VillagesAPI.edit(id);
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

        // update data
        async update([id, form]) {
            this.updateStat = 'loading';
            try {
                const response = await VillagesAPI.update(id, form);
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

        // destroy data
        async destroy(id) {
            this.updateStat = 'loading';
            try {
                const response = await VillagesAPI.destroy(id);
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

        // reset
        resetUpdateStat() {
            this.updateStat = '';
        },
    },
});
