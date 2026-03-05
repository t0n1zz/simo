import { defineStore } from 'pinia';
import ArtikelAPI from '../api/artikel.js';

export const useArtikelStore = defineStore('artikel', {
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

    getters: {
        // State is automatically available in getters
    },

    actions: {
        // load collection with params
        async index(p) {
            this.dataStatS = 'loading';

            try {
                const response = await ArtikelAPI.index(p);
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
                const response = await ArtikelAPI.indexCu(p, id);
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
                const response = await ArtikelAPI.create();
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
                const response = await ArtikelAPI.store(form);
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
                const response = await ArtikelAPI.edit(id);
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
                const response = await ArtikelAPI.update(id, form);
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
                const response = await ArtikelAPI.updateTerbitkan(id);
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
                const response = await ArtikelAPI.updateUtamakan(id);
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
                const response = await ArtikelAPI.destroy(id);
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
                const response = await ArtikelAPI.count();
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
