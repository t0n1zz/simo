import { defineStore } from 'pinia';
import KegiatanRekomAPI from '../api/kegiatanRekom.js';

export const useKegiatanRekomStore = defineStore('kegiatanRekom', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    dataStat: '',
    dataStatS: '',
    dataStatS2: '',
    updateData: [], //update data
    updateData2: [], //update data
    updateStat: '',
    updateStat2: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataS2: state => state.dataS2,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS2: state => state.dataStatS2,
    getUpdate: state => state.updateData,
    getUpdate2: state => state.updateData2,
    getUpdateStat: state => state.updateStat,
    getUpdateStat2: state => state.updateStat2,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index(p) {
      this.dataStatS = 'loading';

      try {
        const response = await KegiatanRekomAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexKegiatan([p, id]) {
      this.dataStatS = 'loading';

      try {
        const response = await KegiatanRekomAPI.indexKegiatan(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexHasil([p, id]) {
      this.dataStatS2 = 'loading';

      try {
        const response = await KegiatanRekomAPI.indexHasil(p, id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    //load collection without params
    async get() {
      this.dataStatS = 'loading';

      try {
        const response = await KegiatanRekomAPI.get();
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
        const response = await KegiatanRekomAPI.create();
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
        const response = await KegiatanRekomAPI.store(form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = 'success';
        } else {
          this.updateData = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeHasil(form) {
      this.updateStat2 = 'loading';

      try {
        const response = await KegiatanRekomAPI.storeHasil(form);
        if (response.data.saved) {
          this.updateData2 = response.data;
          this.updateStat2 = 'success';
        } else {
          this.updateData2 = response.data;
          this.updateStat2 = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat2 = 'fail';
      }
    },

    // update data
    async update([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await KegiatanRekomAPI.update(id, form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = 'success';
        } else {
          this.updateData = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateHasil([id, form]) {
      this.updateStat2 = 'loading';

      try {
        const response = await KegiatanRekomAPI.updateHasil(id, form);
        if (response.data.saved) {
          this.updateData2 = response.data;
          this.updateStat2 = 'success';
        } else {
          this.updateData2 = response.data;
          this.updateStat2 = 'fail';
        }
      } catch (error) {
        this.updateData2 = error.response;
        this.updateStat2 = 'fail';
      }
    },

    // destroy data
    async destroy(id) {
      this.updateStat = 'loading';

      try {
        const response = await KegiatanRekomAPI.destroy(id);
        if (response.data.deleted) {
          this.updateData = response.data;
          this.updateStat = 'success';
        } else {
          this.updateData = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    // destroy data
    async destroyHasil(id) {
      this.updateStat2 = 'loading';

      try {
        const response = await KegiatanRekomAPI.destroyHasil(id);
        if (response.data.deleted) {
          this.updateData2 = response.data;
          this.updateStat2 = 'success';
        } else {
          this.updateData2 = response.data;
          this.updateStat2 = 'fail';
        }
      } catch (error) {
        this.updateData2 = error.response;
        this.updateStat2 = 'fail';
      }
    },

    // reset
    resetDataStat() {
      this.dataStat = '';
    },
    resetUpdateStat() {
      this.updateStat = '';
    },
    resetUpdateStat2() {
      this.updateStat2 = '';
    }
  },
});
