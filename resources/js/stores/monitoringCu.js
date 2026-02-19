import { defineStore } from 'pinia';
import MonitoringCuAPI from '../api/monitoringCu.js';

export const useMonitoringCuStore = defineStore('monitoringCu', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataSKonsolidasi: [],
    periode: {},
    dataDeletedS: [], //collection
    count: {},
    dataStat: '',
    dataStatS: '',
    dataStatSKonsolidasi: '',
    periodeStat: '',
    dataDeletedStatS: '',
    countStat: '',
    update: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
    summary: [],
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataSKonsolidasi: state => state.dataSKonsolidasi,
    getPeriode: state => state.periode,
    getDataDeletedS: state => state.dataDeletedS,
    getCount: state => state.count,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getDataStatSKonsolidasi: state => state.dataStatSKonsolidasi,
    getPeriodeStat: state => state.periodeStat,
    getDataDeletedStatS: state => state.dataDeletedStatS,
    getCountStat: state => state.countStat,
    getUpdate: state => state.update,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
    getSummary: state => state.summary,
  },

  actions: {
    //load collection with params
    async index([p, status]) {
      this.dataStatS = 'loading';

      try {
        const response = await MonitoringCuAPI.index(p, status);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexKonsolidasi([p, tahun, bulan]) {
      this.dataStatS = 'loading';
      try {
        const response = await MonitoringCuAPI.indexKonsolidasi(p, tahun, bulan);
        this.dataSKonsolidasi = response.data.model;
        this.summary = response.data.summary;
        this.dataStatSKonsolidasi = 'success';
      } catch (error) {
        this.dataSKonsolidasi = error.response;
        this.dataStatSKonsolidasi = 'fail';
      }
    },

    // load by cu
    async indexCu([p, cu, tp, status]) {
      this.dataStatS = 'loading';

      try {
        const response = await MonitoringCuAPI.indexCu(p, cu, tp, status);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async summary(cu) {
      this.dataStatS = 'loading';

      try {
        const response = await MonitoringCuAPI.summary(cu);
        this.summary = response.data.summary;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async get(cu) {
      this.dataStatS = 'loading';

      try {
        const response = await MonitoringCuAPI.get(cu);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async detail(id) {
      this.dataStat = 'loading';

      try {
        const response = await MonitoringCuAPI.detail(id);
        this.data = response.data.model;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    // create page
    async create() {
      this.dataStat = 'loading';

      try {
        const response = await MonitoringCuAPI.create();
        this.data = response.data;
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
        const response = await MonitoringCuAPI.store(form);
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
        const response = await MonitoringCuAPI.edit(id);
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
        const response = await MonitoringCuAPI.update(id, form);
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

    async updateRekom(id) {
      this.updateStat = 'loading';

      try {
        const response = await MonitoringCuAPI.updateRekom(id);
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

    async restore(id) {
      this.updateStat = 'loading';

      try {
        const response = await MonitoringCuAPI.restore(id);
        if (response.data.restored) {
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
        const response = await MonitoringCuAPI.destroy(id);
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
        const response = await MonitoringCuAPI.count();
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
    },

    async fetchPeriode(tipe) {
      this.periodeStat = 'loading';

      try {
        const response = await MonitoringCuAPI.getPeriode(tipe);
        this.periode = response.data.model;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },
  },
});
