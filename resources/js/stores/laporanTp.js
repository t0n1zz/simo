import { defineStore } from 'pinia';
import laporanTpAPI from '../api/laporanTp.js';
import laporanTpDraftAPI from '../api/laporanTpDraft.js';

export const useLaporanTpStore = defineStore('laporanTp', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    data2S: [],
    grafik: [],
    pearls: [],
    periode: [],
    columnData: [],
    dataStat: '',
    dataStatS: '',
    dataStat2S: '',
    grafikStat: '',
    pearlsStat: '',
    periodeStat: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getData2S: state => state.data2S,
    getGrafik: state => state.grafik,
    getPearls: state => state.pearls,
    getPeriode: state => state.periode,
    getColumnData: state => state.columnData,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getDataStat2S: state => state.dataStat2S,
    getPearlsStat: state => state.pearlsStat,
    getGrafikStat: state => state.grafikStat,
    getPeriodeStat: state => state.periodeStat,
    getIdCU: state => state.idCU,
    getUpdate: state => state.updateData,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index([p, id]) {
      this.dataStatS = 'loading';

      try {
        const response = await laporanTpAPI.index(p, id);
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
        const response = await laporanTpAPI.indexCu(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load by periode
    async indexPeriode([p, periode]) {
      this.dataStatS = 'loading';

      try {
        const response = await laporanTpAPI.indexPeriode(p, periode);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    //load collection with params
    async indexPearls(p) {
      this.pearlsStat = 'loading';

      try {
        const response = await laporanTpAPI.indexPearls(p);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // load by cu
    async indexPearlsCu([p, id]) {
      this.pearlsStat = 'loading';

      try {
        const response = await laporanTpAPI.indexPearlsCu(p, id);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // load by periode
    async indexPearlsPeriode([p, periode]) {
      this.pearlsStat = 'loading';

      try {
        const response = await laporanTpAPI.indexPearlsPeriode(p, periode);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // get list of laporan tp for laporan cu
    async listLaporanTp([cu, periode]) {
      this.dataStat2S = 'loading';

      try {
        const response = await laporanTpAPI.listLaporanTp(cu, periode);
        this.data2S = response.data.model;
        this.dataStat2S = 'success';
      } catch (error) {
        this.data2S = error.response;
        this.dataStat2S = 'fail';
      }
    },

    // load collection of periode
    async fetchPeriode() {
      this.periodeStat = 'loading';

      try {
        const response = await laporanTpAPI.getPeriode();
        this.periode = response.data.model;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },

    async fetchPeriodeTp([id, periode]) {
      this.dataStatS = 'loading';

      try {
        const response = await laporanTpAPI.getPeriodeTp(id, periode);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load by periode
    async grafikPeriode([p, periode]) {
      this.grafikStat = 'loading';

      try {
        const response = await laporanTpAPI.indexPeriode(p, periode);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },

    // load by cu
    async grafikTp([p, id]) {
      this.grafikStat = 'loading';

      try {
        const response = await laporanTpAPI.indexTp(p, id);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },



    async create() {
      this.dataStat = 'loading';

      try {
        const response = await laporanTpAPI.create();
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
        const response = await laporanTpAPI.store(form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },


    // edit page
    async edit(id) {
      this.dataStat = 'loading';

      try {
        const response = await laporanTpAPI.edit(id);
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
        const response = await laporanTpAPI.update(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateTerbitkan(id) {
      this.updateStat = 'loading';

      try {
        const response = await laporanTpAPI.updateTerbitkan(id);
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

    async updateUtamakan(id) {
      this.updateStat = 'loading';

      try {
        const response = await laporanTpAPI.updateUtamakan(id);
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
        const response = await laporanTpAPI.destroy(id);
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

    addColumnData(data) {
      this.columnData = data;
    },

    // reset
    resetUpdateStat() {
      this.updateStat = '';
    },
    resetData() {
      this.data = '';
      this.dataStat = '';
    },
    resetDataS() {
      this.dataS = '';
      this.dataStatS = '';
    },

    // index draft
    async indexTpDraft() {
      this.dataStatS = 'loading';

      try {
        const response = await laporanTpDraftAPI.index();
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // destroy draft
    async destroyDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await laporanTpDraftAPI.destroy(id);
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

    // destroy draft all
    async destroyDraftAll() {
      this.updateStat = 'loading';

      try {
        const response = await laporanTpDraftAPI.destroyAll();
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

    // store draft all
    async storeDraftAll() {
      this.updateStat = 'loading';

      try {
        const response = await laporanTpDraftAPI.storeAll();
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

  },
});
