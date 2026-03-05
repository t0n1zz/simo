import { defineStore } from 'pinia';
import CUAPI from '../api/cu.js';

export const useCuStore = defineStore('cu', {
    state: () => ({
        data: {},
        dataS: [],
        dataS2: [],
        dataDeletedS: [],
        count: {},
        headerDataS: [],
        dataStat: '',
        dataStatS: '',
        dataStatS2: '',
        dataDeletedStatS: '',
        countStat: '',
        headerDataStatS: '',
        updateData: [],
        updateStat: '',
        rules: [],
        options: [],
    }),

    getters: {
        getData: (state) => state.data,
        getDataS: (state) => state.dataS,
        getDataS2: (state) => state.dataS2,
        getDataDeletedS: (state) => state.dataDeletedS,
        getCount: (state) => state.count,
        getHeaderDataS: (state) => state.headerDataS,
        getDataStat: (state) => state.dataStat,
        getDataStatS: (state) => state.dataStatS,
        getDataStatS2: (state) => state.dataStatS2,
        getDataDeletedStatS: (state) => state.dataDeletedStatS,
        getCountStat: (state) => state.countStat,
        getHeaderDataStatS: (state) => state.headerDataStatS,
        getUpdate: (state) => state.updateData,
        getUpdateStat: (state) => state.updateStat,
        getRules: (state) => state.rules,
        getOptions: (state) => state.options,
    },

    actions: {
        async index(p) {
            this.dataStatS = 'loading';
            try {
                const response = await CUAPI.index(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexDeleted(p) {
            this.dataDeletedStatS = 'loading';
            try {
                const response = await CUAPI.indexDeleted(p);
                this.dataDeletedS = response.data.model;
                this.dataDeletedStatS = 'success';
            } catch (error) {
                this.dataDeletedS = error.response;
                this.dataDeletedStatS = 'fail';
            }
        },

        async get() {
            this.dataStatS = 'loading';
            try {
                const response = await CUAPI.get();
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async getUpdateESCETE() {
            this.dataStatS2 = 'loading';
            try {
                const response = await CUAPI.getUpdateESCETE();
                this.dataS2 = response.data.model;
                this.dataStatS2 = 'success';
            } catch (error) {
                this.dataS2 = error.response;
                this.dataStatS2 = 'fail';
            }
        },

        async getHeader() {
            this.headerDataStatS = 'loading';
            try {
                const response = await CUAPI.getHeader();
                this.headerDataS = response.data.model;
                this.headerDataStatS = 'success';
            } catch (error) {
                this.headerDataS = error.response;
                this.headerDataStatS = 'fail';
            }
        },

        async getPus(id) {
            this.dataStatS = 'loading';
            try {
                const response = await CUAPI.getPus(id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async escete(id) {
            this.dataStat = 'loading';
            try {
                const response = await CUAPI.escete(id);
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

        async create() {
            this.dataStat = 'loading';
            try {
                const response = await CUAPI.create();
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
                const response = await CUAPI.store(form);
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
                const response = await CUAPI.edit(id);
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
                const response = await CUAPI.update(id, form);
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

        async restore(id) {
            this.updateStat = 'loading';
            try {
                const response = await CUAPI.restore(id);
                if (response.data.restored) {
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
                const response = await CUAPI.destroy(id);
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
                const response = await CUAPI.count();
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
    },
});
