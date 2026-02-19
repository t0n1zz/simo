import { defineStore } from 'pinia';
import SuratAPI from '../api/surat.js';

export const useSuratStore = defineStore('surat', {
  state: () => ({
    data: {}, //single data
    data2: {}, //single data
    dataS: [],
    periode: [], //collection
    count: {},
    dataStat: '',
    dataStat2: '',
    dataStatS: '',
    countStat: '',
    periodeStat: '',
    update: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getData2: state => state.data2,
    getDataS: state => state.dataS,
    getCount: state => state.count,
    getPeriode: state => state.periode,
    getDataStat: state => state.dataStat,
    getDataStat2: state => state.dataStat2,
    getDataStatS: state => state.dataStatS,
    getCountStat: state => state.countStat,
    getPeriodeStat: state => state.periodeStat,
    getUpdate: state => state.update,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    // load by cu
    async indexCu([p, cu, tipe, periode]) {
      this.dataStatS = 'loading';

      try {
        const response = await SuratAPI.indexCu(p, cu, tipe, periode);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async fetchPeriode(cu) {
      this.periodeStat = 'loading';

      try {
        const response = await SuratAPI.getPeriode(cu);
        this.periode = response.data.model;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },

    async getKode(id) {
      this.dataStat2 = 'loading';

      try {
        const response = await SuratAPI.getKode(id);
        this.data2 = response.data.model;
        this.dataStat2 = 'success';
      } catch (error) {
        this.data2 = error.response;
        this.dataStat2 = 'fail';
      }
    },

    // create page
    async create() {
      this.dataStat = 'loading';

      try {
        const response = await SuratAPI.create();
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
        const response = await SuratAPI.store(form);
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
      this.dataStat2 = 'loading';

      try {
        const response = await SuratAPI.edit(id);
        this.data = response.data.form;
        this.rules = response.data.rules;
        this.options = response.data.options;
        this.dataStat = 'success';
        this.data2 = response.data.model;
        this.dataStat2 = 'success';
      } catch (error) {
        this.data = error.response;
        this.rules = [];
        this.options = [];
        this.dataStat = 'fail';
        this.dataStat2 = 'fail';
      }
    },

    // update data
    async update([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await SuratAPI.update(id, form);
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

    async updateTerbitkan(id) {
      this.updateStat = 'loading';

      try {
        const response = await SuratAPI.updateTerbitkan(id);
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

    async updateUtamakan(id) {
      this.updateStat = 'loading';

      try {
        const response = await SuratAPI.updateUtamakan(id);
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
        const response = await SuratAPI.destroy(id);
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

    async count() {
      this.countStat = 'loading';

      try {
        const response = await SuratAPI.count();
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
      this.data = {};
      this.dataStat = '';
    },
    resetDataS() {
      this.dataS = [];
      this.dataStatS = '';
    },

  },
});
