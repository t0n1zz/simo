import { defineStore } from 'pinia';
import aktivisAPI from '../api/aktivis.js';

export const useAktivisStore = defineStore('aktivis', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataS1: [], //collection
    dataS2: [], //collection
    dataS3: [], //collection
    dataS4: [], //collection
    dataS5: [], //collection
    dataS6: [], //collection added based on logic in actions
    count: {},
    dataStat: '',
    dataStatS: '',
    dataStatS1: '',
    dataStatS2: '',
    dataStatS3: '',
    dataStatS4: '',
    dataStatS5: '',
    dataStatS6: '',
    countStat: '',
    update: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataS1: state => state.dataS1,
    getDataS2: state => state.dataS2,
    getDataS3: state => state.dataS3,
    getDataS4: state => state.dataS4,
    getDataS5: state => state.dataS5,
    getDataS6: state => state.dataS6,
    getCount: state => state.count,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS1: state => state.dataStatS1,
    getDataStatS2: state => state.dataStatS2,
    getDataStatS3: state => state.dataStatS3,
    getDataStatS4: state => state.dataStatS4,
    getDataStatS5: state => state.dataStatS5,
    getDataStatS6: state => state.dataStatS6,
    getCountStat: state => state.countStat,
    getUpdate: state => state.update,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index([p, tingkat, status]) {
      if (status == 'aktif') {
        this.dataStatS = 'loading';
        try {
          const response = await aktivisAPI.index(p, tingkat, status);
          this.dataS = response.data.model;
          this.dataStatS = 'success';
        } catch (error) {
          this.dataS = error.response;
          this.dataStatS = 'fail';
        }
      } else {
        this.dataStatS2 = 'loading';
        try {
          const response = await aktivisAPI.index(p, tingkat, status);
          this.dataS2 = response.data.model;
          this.dataStatS2 = 'success';
        } catch (error) {
          this.dataS2 = error.response;
          this.dataStatS2 = 'fail';
        }
      }
    },

    // load by cu
    async indexCu([p, id, tingkat, status]) {
      if (status == 'aktif') {
        this.dataStatS = 'loading';
        try {
          const response = await aktivisAPI.indexCu(p, id, tingkat, status);
          this.dataS = response.data.model;
          this.dataStatS = 'success';
        } catch (error) {
          this.dataS = error.response;
          this.dataStatS = 'fail';
        }
      } else {
        this.dataStatS2 = 'loading';
        try {
          const response = await aktivisAPI.indexCu(p, id, tingkat, status);
          this.dataS2 = response.data.model;
          this.dataStatS2 = 'success';
        } catch (error) {
          this.dataS2 = error.response;
          this.dataStatS2 = 'fail';
        }
      }
    },

    async indexTingkatArr([p, kegiatan_id, tingkat]) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.indexTingkatArr(p, kegiatan_id, tingkat);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCuTingkatArr([p, kegiatan_id, id, tingkat]) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.indexCuTingkatArr(p, kegiatan_id, id, tingkat);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexTingkat([p, tingkat]) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.indexTingkat(p, tingkat);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexLembaga(p) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.indexLembaga(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load by pekerjaan
    async indexPekerjaan(id) {
      this.dataStatS1 = 'loading';

      try {
        const response = await aktivisAPI.indexPekerjaan(id);
        this.dataS1 = response.data.model;
        this.dataStatS1 = 'success';
      } catch (error) {
        this.dataS1 = error.response;
        this.dataStatS1 = 'fail';
      }
    },

    // load by pendidikan
    async indexPendidikan(id) {
      this.dataStatS2 = 'loading';

      try {
        const response = await aktivisAPI.indexPendidikan(id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    // load by organisasi
    async indexOrganisasi(id) {
      this.dataStatS3 = 'loading';

      try {
        const response = await aktivisAPI.indexOrganisasi(id);
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    // load by diklat
    async indexDiklat(id) {
      this.dataStatS4 = 'loading';

      try {
        const response = await aktivisAPI.indexDiklat(id);
        this.dataS4 = response.data.model;
        this.dataStatS4 = 'success';
      } catch (error) {
        this.dataS4 = error.response;
        this.dataStatS4 = 'fail';
      }
    },

    async indexPertemuan(id) {
      this.dataStatS6 = 'loading';

      try {
        const response = await aktivisAPI.indexPertemuan(id);
        this.dataS6 = response.data.model;
        this.dataStatS6 = 'success';
      } catch (error) {
        this.dataS6 = error.response;
        this.dataStatS6 = 'fail';
      }
    },

    // load by keterangan
    async indexKeterangan(id) {
      this.dataStatS5 = 'loading';

      try {
        const response = await aktivisAPI.indexKeterangan(id);
        this.dataS5 = response.data.model;
        this.dataStatS5 = 'success';
      } catch (error) {
        this.dataS5 = error.response;
        this.dataStatS5 = 'fail';
      }
    },

    // load by keluarga
    async indexKeluarga(id) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.indexKeluarga(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load by keluarga
    async indexAnggotaCu(id) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.indexAnggotaCu(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async get(id) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.get(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async get2(id) {
      this.dataStatS2 = 'loading';

      try {
        const response = await aktivisAPI.get(id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async getMonitoringCu(id) {
      this.dataStatS = 'loading';

      try {
        const response = await aktivisAPI.getMonitoringCu(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async cariData(nik) {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.cariData(nik);
        if (response.data.model) {
          this.data = response.data.model;
          this.dataStat = 'success';
        } else {
          this.data = response.data.form;
          this.rules = response.data.rules;
          this.options = response.data.options;
          this.dataStat = 'fail';
        }
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    async create() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.create();
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

    async createPekerjaan() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.createPekerjaan();
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

    async createPendidikan() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.createPendidikan();
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

    async createOrganisasi() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.createOrganisasi();
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

    async createDiklat() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.createDiklat();
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

    async createKeluarga() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.createKeluarga();
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

    async createAnggotaCu() {
      this.dataStat = 'loading';

      try {
        const response = await aktivisAPI.createAnggotaCu();
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
        const response = await aktivisAPI.store(form);
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

    async savePekerjaan([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.savePekerjaan(id, form);
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

    async savePendidikan([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.savePendidikan(id, form);
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

    async saveOrganisasi([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.saveOrganisasi(id, form);
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

    async saveDiklat([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.saveDiklat(id, form);
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

    async saveKeluarga([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.saveKeluarga(id, form);
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

    async saveAnggotaCu([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.saveAnggotaCu(id, form);
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

    async saveKeterangan([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.saveKeterangan(id, form);
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
        const response = await aktivisAPI.edit(id);
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
        const response = await aktivisAPI.update(id, form);
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
        const response = await aktivisAPI.destroy(id);
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

    async destroyPekerjaan(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyPekerjaan(id);
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

    async destroyPendidikan(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyPendidikan(id);
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

    async destroyOrganisasi(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyOrganisasi(id);
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

    async destroyDiklat(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyDiklat(id);
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

    async destroyKeluarga(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyKeluarga(id);
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

    async destroyAnggotaCu(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyAnggotaCu(id);
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

    async destroyKeterangan(id) {
      this.updateStat = 'loading';

      try {
        const response = await aktivisAPI.destroyKeterangan(id);
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
        const response = await aktivisAPI.count();
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
    resetDataS2() {
      this.dataS2 = [];
      this.dataStatS2 = '';
    },

  },
});
