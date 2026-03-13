import { defineStore } from 'pinia';
import DistrictsAPI from '../api/districts.js';

export const useDistrictsStore = defineStore('districts', {
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
                const response = await DistrictsAPI.index(p);
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
                const response = await DistrictsAPI.get();
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // Load districts by kabupaten (regency) id
        // Legacy code used `indexRegencies`, but the actual backend
        // endpoint here is `getRegencies`, so we delegate to that.
        async indexRegencies(id) {
            this.dataStatS = 'loading';
            try {
                const response = await DistrictsAPI.getRegencies(id);
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
                const response = await DistrictsAPI.create();
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
                const response = await DistrictsAPI.store(form);
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
                const response = await DistrictsAPI.edit(id);
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
                const response = await DistrictsAPI.update(id, form);
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
                const response = await DistrictsAPI.destroy(id);
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
