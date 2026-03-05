import { defineStore } from 'pinia';
import MonitoringPencapaianAPI from '../api/monitoringPencapaian.js';

export const useMonitoringPencapaianStore = defineStore('monitoringPencapaian', {
  state: () => ({
    data: {}, //single data
    data2: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    periode: {},
    dataDeletedS: [], //collection
    count: {},
    dataStat: '',
    dataStat2: '',
    dataStatS: '',
    dataStatS2: '',
    periodeStat: '',
    dataDeletedStatS: '',
    countStat: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getPeriode: state => state.periode,
    getDataDeletedS: state => state.dataDeletedS,
    getCount: state => state.count,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getPeriodeStat: state => state.periodeStat,
    getDataDeletedStatS: state => state.dataDeletedStatS,
    getCountStat: state => state.countStat,
    getUpdate: state => state.updateData,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {

    async get(id) {
      this.dataStatS = 'loading';

      try {
        const response = await MonitoringPencapaianAPI.get(id);
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
        const response = await MonitoringPencapaianAPI.detail(id);
        this.data = response.data.model;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    //store data
    async store(form) {
      this.updateStat = 'loading';

      try {
        const response = await MonitoringPencapaianAPI.store(form);
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

    // update data
    async update([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await MonitoringPencapaianAPI.update(id, form);
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

    async restore(id) {
      this.updateStat = 'loading';

      try {
        const response = await MonitoringPencapaianAPI.restore(id);
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
        const response = await MonitoringPencapaianAPI.destroy(id);
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
        const response = await MonitoringPencapaianAPI.count();
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
