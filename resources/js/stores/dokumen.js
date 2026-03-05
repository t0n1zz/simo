import { defineStore } from 'pinia';
import DokumenAPI from '../api/dokumen.js';

export const useDokumenStore = defineStore('dokumen', {
    state: () => ({
        data: {}, // single data
        dataS: [], // collection
        count: {},
        dataStat: '',
        dataStatS: '',
        countStat: '',
        updateData: [], // update data
        updateStat: '',
        rules: [], // laravel rules
        options: [], // laravel options
    }),

    actions: {
        // load collection with params
        async index(p) {
            this.dataStatS = 'loading';

            try {
                const response = await DokumenAPI.index(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // load by cu
        async indexCu(p, id) {
            this.dataStatS = 'loading';

            try {
                const response = await DokumenAPI.indexCu(p, id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexGerakanPublik(p) {
            this.dataStatS = 'loading';

            try {
                const response = await DokumenAPI.indexGerakanPublik(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // load by cu
        async indexGerakanPublikCu(p, id) {
            this.dataStatS = 'loading';

            try {
                const response = await DokumenAPI.indexGerakanPublikCu(p, id);
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
                const response = await DokumenAPI.create();
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
                const response = await DokumenAPI.store(form);
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
                const response = await DokumenAPI.edit(id);
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
        async update(id, form) {
            this.updateStat = 'loading';

            try {
                const response = await DokumenAPI.update(id, form);
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

        async updateTerbitkan(id) {
            this.updateStat = 'loading';

            try {
                const response = await DokumenAPI.updateTerbitkan(id);
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

        async updateUtamakan(id) {
            this.updateStat = 'loading';

            try {
                const response = await DokumenAPI.updateUtamakan(id);
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
                const response = await DokumenAPI.destroy(id);
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
                const response = await DokumenAPI.count();
                this.count = response.data.model;
                this.countStat = 'success';
            } catch (error) {
                this.count = error.response;
                this.countStat = 'fail';
            }
        },

        // reset
        resetUpdateStat() {
            this.updateStat = '';
        },
        resetData() {
            this.data = '';
            this.dataStat = '';
        },
        resetDataS() {
            this.dataS = '';
            this.dataStatS = '';
        },
    }
});
