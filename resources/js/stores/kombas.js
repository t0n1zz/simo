import { defineStore } from 'pinia';
import KombasAPI from '../api/kombas.js';

export const useKombasStore = defineStore('kombas', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataStat: '',
    dataStatS: '',
    update: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getUpdate: state => state.update,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index([p, tipe]) {
      this.dataStatS = 'loading';

      try {
        const response = await KombasAPI.index(p, tipe);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCu([p, id, tipe]) {
      this.dataStatS = 'loading';

      try {
        const response = await KombasAPI.indexCu(p, id, tipe);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    //load collection without params
    async get() {
      this.dataStatS = 'loading';

      try {
        const response = await KombasAPI.get();
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
        const response = await KombasAPI.create();
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

    //store data
    async store(form) {
      this.updateStat = 'loading';

      try {
        const response = await KombasAPI.store(form);
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
        const response = await KombasAPI.edit(id);
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
        const response = await KombasAPI.update(id, form);
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
        const response = await KombasAPI.destroy(id);
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
  },
});
