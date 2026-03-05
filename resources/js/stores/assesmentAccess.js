import { defineStore } from 'pinia';
import AssesmentAccessAPI from '../api/assesmentAccess.js';

export const useAssesmentAccessStore = defineStore('assesmentAccess', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    periode: {},
    dataDeletedS: [], //collection
    count: {},
    headerDataS: [],
    dataStat: '',
    dataStatS: '',
    periodeStat: '',
    dataDeletedStatS: '',
    countStat: '',
    headerDataStatS: '',
    updateData: [], //update data
    updateStat: '',
    updateSingle: [], //update data
    updateSingleStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getPeriode: state => state.periode,
    getDataDeletedS: state => state.dataDeletedS,
    getCount: state => state.count,
    getHeaderDataS: state => state.headerDataS,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getPeriodeStat: state => state.periodeStat,
    getDataDeletedStatS: state => state.dataDeletedStatS,
    getCountStat: state => state.countStat,
    getHeaderDataStatS: state => state.headerDataStatS,
    getUpdate: state => state.updateData,
    getUpdateStat: state => state.updateStat,
    getUpdateSingle: state => state.updateSingle,
    getUpdateSingleStat: state => state.updateSingleStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index(p) {
      this.dataStatS = 'loading';

      try {
        const response = await AssesmentAccessAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load by cu
    async indexCu([p, id]) {
      this.dataStatS = 'loading';

      try {
        const response = await AssesmentAccessAPI.indexCu(p, id);
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
        const response = await AssesmentAccessAPI.create();
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
        const response = await AssesmentAccessAPI.store(form);
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
        const response = await AssesmentAccessAPI.edit(id);
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

    async editPenilaian(id) {
      this.dataStat = 'loading';

      try {
        const response = await AssesmentAccessAPI.editPenilaian(id);
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
        const response = await AssesmentAccessAPI.update(id, form);
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

    async updateSingle([id, perspektif, form]) {
      this.updateSingleStat = 'loading';

      try {
        const response = await AssesmentAccessAPI.updateSingle(id, perspektif, form);
        if (response.data.saved) {
          this.updateSingle = response.data;
          this.updateSingleStat = 'success';
        } else {
          this.updateSingleStat = 'fail';
        }
      } catch (error) {
        this.updateSingle = error.response;
        this.updateSingleStat = 'fail';
      }
    },

    async restore(id) {
      this.updateStat = 'loading';

      try {
        const response = await AssesmentAccessAPI.restore(id);
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

    // destroy data
    async destroy(id) {
      this.updateStat = 'loading';

      try {
        const response = await AssesmentAccessAPI.destroy(id);
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

    // cari data
    async cariData([cu, periode]) {
      this.periodeStat = 'loading';

      try {
        const response = await AssesmentAccessAPI.cariData(cu, periode);
        this.periode = response.data.periode;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },

    async count() {
      this.countStat = 'loading';

      try {
        const response = await AssesmentAccessAPI.count();
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

    resetPeriode() {
      this.periode = {};
      this.periodeStat = '';
    }
  },
});
