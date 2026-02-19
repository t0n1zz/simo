import { defineStore } from 'pinia';
import JalinanIuranAPI from '../api/jalinanIuran.js';

export const useJalinanIuranStore = defineStore('jalinanIuran', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    count: {},
    dataStat: '',
    dataStatS: '',
    dataStatS2: '',
    countStat: '',
    update: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataS2: state => state.dataS2,
    getCount: state => state.count,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS2: state => state.dataStatS2,
    getCountStat: state => state.countStat,
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
        const response = await JalinanIuranAPI.index(p);
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
        const response = await JalinanIuranAPI.indexCu(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexAnggota([p, id, cu, lokasi]) {
      this.dataStatS2 = 'loading';

      try {
        const response = await JalinanIuranAPI.indexAnggota(p, id, cu, lokasi);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async create([idCu, periodeBulan, periodeTahun]) {
      this.updateStat = 'loading';

      try {
        const response = await JalinanIuranAPI.create(idCu, periodeBulan, periodeTahun);
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
        const response = await JalinanIuranAPI.edit(id);
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
        const response = await JalinanIuranAPI.update(id, form);
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
        const response = await JalinanIuranAPI.destroy(id);
        if (response.data.deleted) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.update = response.data;
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
