import { defineStore } from 'pinia';
import tempatAPI from '../api/tempat.js';

export const useTempatStore = defineStore('tempat', {
    state: () => ({
        data: {}, // single data
        dataS: [], // collection
        dataSForm: [], // collection for diklat form
        dataStat: '',
        dataStatS: '',
        dataStatSForm: '',
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
                const response = await tempatAPI.index(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        // load collection without params
        async get(id) {
            this.dataStatSForm = 'loading';

            try {
                const response = await tempatAPI.get(id);
                this.dataSForm = response.data.model;
                this.dataStatSForm = 'success';
            } catch (error) {
                this.dataSForm = error.response;
                this.dataStatSForm = 'fail';
            }
        },

        // create page
        async create() {
            this.dataStat = 'loading';

            try {
                const response = await tempatAPI.create();
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
                const response = await tempatAPI.store(form);
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
                const response = await tempatAPI.edit(id);
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
                const response = await tempatAPI.update(id, form);
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
                const response = await tempatAPI.destroy(id);
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
        resetUpdateStat() {
            this.updateStat = '';
        }
    }
});
