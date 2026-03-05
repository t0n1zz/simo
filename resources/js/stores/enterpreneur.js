import { defineStore } from 'pinia';
import EnterpreneurAPI from '../api/enterpreneur.js';

export const useEnterpreneurStore = defineStore('enterpreneur', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    dataS3: [], //collection
    dataStat: '',
    dataStatS: '',
    dataStatS2: '',
    dataStatS3: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataS2: state => state.dataS2,
    getDataS3: state => state.dataS3,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS2: state => state.dataStatS2,
    getDataStatS3: state => state.dataStatS3,
    getUpdate: state => state.updateData,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index(p) {
      this.dataStatS = 'loading';

      try {
        const response = await EnterpreneurAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCu([p, id]) {
      this.dataStatS = 'loading';

      try {
        const response = await EnterpreneurAPI.indexCu(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexDiklat(id) {
      this.dataStatS3 = 'loading';

      try {
        const response = await EnterpreneurAPI.indexDiklat(id);
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    //load collection without params
    async get() {
      this.dataStatS = 'loading';

      try {
        const response = await EnterpreneurAPI.get();
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
        const response = await EnterpreneurAPI.getCu(id);
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
        const response = await EnterpreneurAPI.create();
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
        const response = await EnterpreneurAPI.store(form);
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
        const response = await EnterpreneurAPI.edit(id);
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
        const response = await EnterpreneurAPI.update(id, form);
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
        const response = await EnterpreneurAPI.destroy(id);
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
    resetDataStat() {
      this.dataStat = '';
    },
    resetUpdateStat() {
      this.updateStat = '';
    }
  },
});
