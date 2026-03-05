import { defineStore } from 'pinia';
import AsetTetapAPI from '../api/asetTetap';

export const useAsetTetapStore = defineStore('asetTetap', {
  state: () => ({
    data: {}, //single data
    kode: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    dataS3: [], //collection
    dataS4: [], //collection
    dataStat: '',
    kodeStat: '',
    dataStatS: '',
    dataStatS2: '',
    dataStatS3: '',
    dataStatS4: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getKode: state => state.kode,
    getDataS: state => state.dataS,
    getDataS2: state => state.dataS2,
    getDataS3: state => state.dataS3,
    getDataS4: state => state.dataS4,
    getDataStat: state => state.dataStat,
    getKodeStat: state => state.kodeStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS2: state => state.dataStatS2,
    getDataStatS3: state => state.dataStatS3,
    getDataStatS4: state => state.dataStatS4,
    getUpdate: state => state.updateData,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index(p) {
      this.dataStatS = 'loading';

      try {
        const response = await AsetTetapAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexSelesai(p) {
      this.dataStatS3 = 'loading';

      try {
        const response = await AsetTetapAPI.indexSelesai(p);
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    async indexHapus(p) {
      this.dataStatS4 = 'loading';

      try {
        const response = await AsetTetapAPI.indexHapus(p);
        this.dataS4 = response.data.model;
        this.dataStatS4 = 'success';
      } catch (error) {
        this.dataS4 = error.response;
        this.dataStatS4 = 'fail';
      }
    },

    async indexSub([p, id]) {
      this.dataStatS2 = 'loading';

      try {
        const response = await AsetTetapAPI.indexSub(p, id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async cariData(kode) {
      this.dataStat = 'loading';

      try {
        const response = await AsetTetapAPI.cariData(kode);
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

    // create page
    async create() {
      this.dataStat = 'loading';

      try {
        const response = await AsetTetapAPI.create();
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

    async get(kode) {
      this.dataStat = 'loading';

      try {
        const response = await AsetTetapAPI.get(kode);
        this.data = response.data.model;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    async generate(id) {
      this.kodeStat = 'loading';

      try {
        const response = await AsetTetapAPI.generate(id);
        this.kode = response.data.model;
        this.kodeStat = 'success';
      } catch (error) {
        this.kode = error.response;
        this.kodeStat = 'fail';
      }
    },

    //store data
    async store(form) {
      this.updateStat = 'loading';

      try {
        const response = await AsetTetapAPI.store(form);
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
        const response = await AsetTetapAPI.edit(id);
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
        const response = await AsetTetapAPI.update(id, form);
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
    // update data lokasi
    async updateLokasi([id, form]) {
      this.updateStat = 'loading';
      try {
        const response = await AsetTetapAPI.updateLokasi(id, form);
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

    async hapusDariLaporan(id) {
      this.updateStat = 'loading';

      try {
        const response = await AsetTetapAPI.hapusDariLaporan(id);
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
    async updateKondisi([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AsetTetapAPI.updateKondisi(id, form);
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
        const response = await AsetTetapAPI.destroy(id);
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

    // reset
    resetData() {
      this.data = {};
      this.dataStat = '';
    },
    resetDataS2() {
      this.dataS2 = [];
      this.dataStatS2 = '';
    },
    resetDataStat() {
      this.dataStat = '';
    },
    resetUpdateStat() {
      this.updateStat = '';
    }
  }
});
