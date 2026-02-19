import { defineStore } from 'pinia';
import MonitoringAPI from '../api/monitoring.js';

export const useMonitoringStore = defineStore('monitoring', {
  state: () => ({
    data: {}, //single data
    data2: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    dataSKonsolidasi: [],
    periode: {},
    dataDeletedS: [], //collection
    count: {},
    dataStat: '',
    dataStat2: '',
    dataStatS: '',
    dataStatS2: '',
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
        const response = await MonitoringAPI.index(p, status);
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
        const response = await MonitoringAPI.indexKonsolidasi(p, tahun, bulan);
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
        const response = await MonitoringAPI.indexCu(p, cu, tp, status);
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
        const response = await MonitoringAPI.summary(cu);
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
        const response = await MonitoringAPI.get(cu);
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
        const response = await MonitoringAPI.detail(id);
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
        const response = await MonitoringAPI.create();
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
        const response = await MonitoringAPI.store(form);
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
        const response = await MonitoringAPI.edit(id);
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
        const response = await MonitoringAPI.update(id, form);
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
        const response = await MonitoringAPI.updateRekom(id);
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
        const response = await MonitoringAPI.restore(id);
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
        const response = await MonitoringAPI.destroy(id);
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
        const response = await MonitoringAPI.count();
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
        const response = await MonitoringAPI.getPeriode(tipe);
        this.periode = response.data.model;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },
  },
});
