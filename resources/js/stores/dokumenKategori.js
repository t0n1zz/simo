import { defineStore } from 'pinia';
import DokumenKategoriAPI from '../api/dokumenKategori.js';

export const useDokumenKategoriStore = defineStore('dokumenKategori', {
    state: () => ({
        data: {}, // single data
        dataS: [], // collection
        dataStat: '',
        dataStatS: '',
        update: [], // update data
        updateStat: '',
        rules: [], // laravel rules
        options: [], // laravel options
    }),

    actions: {
        // load collection with params
        async index(p) {
            this.dataStatS = 'loading';

            try {
                const response = await DokumenKategoriAPI.index(p);
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
                const response = await DokumenKategoriAPI.indexCu(p, id);
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
                const response = await DokumenKategoriAPI.get();
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async getCu(id) {
            this.dataStatS = 'loading';

            try {
                const response = await DokumenKategoriAPI.getCu(id);
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
                const response = await DokumenKategoriAPI.create();
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
                const response = await DokumenKategoriAPI.store(form);
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

        // edit page
        async edit(id) {
            this.dataStat = 'loading';

            try {
                const response = await DokumenKategoriAPI.edit(id);
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
                const response = await DokumenKategoriAPI.update(id, form);
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

        // destroy data
        async destroy(id) {
            this.updateStat = 'loading';

            try {
                const response = await DokumenKategoriAPI.destroy(id);
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

        // reset
        resetDataStat() {
            this.dataStat = '';
        },
        resetUpdateStat() {
            this.updateStat = '';
        }
    }
});
