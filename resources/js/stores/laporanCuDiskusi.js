import { defineStore } from 'pinia';
import LaporanCuDiskusiAPI from '../api/laporanCuDiskusi.js';
import LaporanTpDiskusiAPI from '../api/laporanTpDiskusi.js';

export const useLaporanCuDiskusiStore = defineStore('laporanCuDiskusi', {
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
    async index(p) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuDiskusiAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    //load collection without paramsx
    async get(id) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuDiskusiAPI.get(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async getTp(id) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanTpDiskusiAPI.get(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    //store data
    async store(form) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuDiskusiAPI.store(form);
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

    async storeTp(form) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpDiskusiAPI.store(form);
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

    // update data
    async update([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuDiskusiAPI.update(id, form);
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

    async updateTp([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpDiskusiAPI.update(id, form);
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
        const response = await LaporanCuDiskusiAPI.destroy(id);
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

    async destroyTp(id) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpDiskusiAPI.destroy(id);
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
  },
});
