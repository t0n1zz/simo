import { defineStore } from 'pinia';
import sertifikatKegiatanAPI from "../api/sertifikatKegiatan.js";

export const useSertifikatKegiatanStore = defineStore('sertifikatKegiatan', {
  state: () => ({
    data: {},
    dataS: [], //collection
    dataSS: [],
    dataNomor: [], //collection
    count: {},
    dataNomorStat: "",
    dataStatSS: "",
    dataStatS: "",
    dataStat: "",
    countStat: "",
    updateData: [], //update data
    updateStat: "",
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: (state) => state.data,
    getDataSS: (state) => state.dataSS,
    getDataNomor: (state) => state.dataNomor,
    getDataS: (state) => state.dataS,
    // periode: (state) => state.periode, // Not in state definition, likely typo in Vuex
    getCount: (state) => state.count,
    getDataNomorStat: (state) => state.dataNomorStat,
    getDataStatSS: (state) => state.dataStatSS,
    getDataStat: (state) => state.dataStat,
    getDataStatS: (state) => state.dataStatS,
    getCountStat: (state) => state.countStat,
    getUpdate: (state) => state.updateData,
    getUpdateStat: (state) => state.updateStat,
    getRules: (state) => state.rules,
    getOptions: (state) => state.options,
  },

  actions: {
    //load collection with params
    async index(p) {
      this.dataStatS = "loading";
      try {
        const response = await sertifikatKegiatanAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = "success";
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = "fail";
      }
    },

    async indexNomorSertifikat(p) {
      this.dataNomorStat = "loading";
      try {
        const response = await sertifikatKegiatanAPI.indexNomorSertifikat(p);
        this.dataNomor = response.data.model;
        this.dataNomorStat = "success";
      } catch (error) {
        this.dataNomor = error.response;
        this.dataNomorStat = "fail";
      }
    },

    // create page
    async create() {
      this.dataStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.create();
        this.data = response.data.form;
        this.rules = response.data.rules;
        this.options = response.data.options;
        this.dataStat = "success";
      } catch (error) {
        this.data = error.response;
        this.rules = [];
        this.options = [];
        this.dataStat = "fail";
      }
    },

    //store data
    async store(form) {
      this.updateStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.store(form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = "success";
        } else {
          this.updateStat = "fail";
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = "fail";
      }
    },

    async storeNomorSertifikatKegiatan([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await sertifikatKegiatanAPI.storeNomorSertifikatKegiatan(id, form);
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
      this.dataStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.edit(id);
        this.data = response.data.form;
        this.rules = response.data.rules;
        this.options = response.data.options;
        this.dataStat = "success";
      } catch (error) {
        this.data = error.response;
        this.rules = [];
        this.options = [];
        this.dataStat = "fail";
      }
    },

    // edit page
    async editFormNomor(id) {
      this.dataStatSS = "loading";

      try {
        const response = await sertifikatKegiatanAPI.editFormNomor(id);
        this.dataSS = response.data.form;
        this.rules = response.data.rules;
        this.options = response.data.options;
        this.dataStatSS = "success";
      } catch (error) {
        this.data = error.response; // Should this be dataSS? Kept consistent with Vuex
        this.rules = [];
        this.options = [];
        this.dataStat = "fail"; // Should this be dataStatSS?
      }
    },

    // update data
    async update([id, form]) {
      this.updateStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.update(id, form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = "success";
        } else {
          this.updateStat = "fail";
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = "fail";
      }
    },

    async uploadExcelPeserta(form) {
      this.updateStat = 'loading';

      try {
        const response = await sertifikatKegiatanAPI.uploadExcelPeserta(form);
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

    async updateNomorSertifikatKegiatan([id, form]) {
      this.updateStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.updateNomorSertifikatKegiatan(id, form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = "success";
        } else {
          this.updateStat = "fail";
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = "fail";
      }
    },

    // destroy data
    async destroy(id) {
      this.updateStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.destroy(id);
        if (response.data.deleted) {
          this.updateData = response.data;
          this.updateStat = "success";
        } else {
          this.updateStat = "fail";
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = "fail";
      }
    },

    async destroyNomorSertifikatKegiatan(id) {
      this.updateStat = "loading";

      try {
        const response = await sertifikatKegiatanAPI.destroyNomorSertifikatKegiatan(id);
        if (response.data.deleted) {
          this.updateData = response.data;
          this.updateStat = "success";
        } else {
          this.updateStat = "fail";
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = "fail";
      }
    },

    // reset
    resetDataS() {
      this.dataS = [];
      this.dataStatS = "success";
    },
    resetUpdateStat() {
      this.updateStat = "";
    },
  },
});
