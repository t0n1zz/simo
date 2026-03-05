import { defineStore } from 'pinia';
import ProdukCuAPI from '../api/produkCu.js';

export const useProdukCuStore = defineStore('produkCu', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    headerDataS: [], //collection
    count: {},
    dataStat: '',
    dataStatS: '',
    headerDataStatS: '',
    countStat: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getCount: state => state.count,
    getHeaderDataS: state => state.headerDataS,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getHeaderDataStatS: state => state.headerDataStatS,
    getCountStat: state => state.countStat,
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
        const response = await ProdukCuAPI.index(p);
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
        const response = await ProdukCuAPI.indexCu(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async getCuJalinan(id) {
      this.dataStatS = 'loading';

      try {
        const response = await ProdukCuAPI.getCuJalinan(id);
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
        const response = await ProdukCuAPI.create();
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
        const response = await ProdukCuAPI.store(form);
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
        const response = await ProdukCuAPI.edit(id);
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
        const response = await ProdukCuAPI.update(id, form);
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
        const response = await ProdukCuAPI.destroy(id);
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
        const response = await ProdukCuAPI.count();
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
    }
  },
});
