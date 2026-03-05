import { defineStore } from 'pinia';
import KodeKegiatanAPI from "../api/kodeKegiatan.js";

export const useKodeKegiatanStore = defineStore('kodeKegiatan', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    dataStat: "",
    dataStatS: "",
    dataStatS2: "",
    updateData: [], //update data
    updateData2: [], //update data
    updateStat: "",
    updateStat2: "",
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  // getters
  getters: {
    getData: (state) => state.data,
    getDataS: (state) => state.dataS,
    getDataS2: (state) => state.dataS2,
    getDataStat: (state) => state.dataStat,
    getDataStatS: (state) => state.dataStatS,
    getDataStatS2: (state) => state.dataStatS2,
    getUpdate: (state) => state.updateData,
    getUpdate2: (state) => state.updateData2,
    getUpdateStat: (state) => state.updateStat,
    getUpdateStat2: (state) => state.updateStat2,
    getRules: (state) => state.rules,
    getOptions: (state) => state.options,
  },

  actions: {
    //load collection with params
    async index(p) {
      this.dataStatS = "loading";
      try {
        const response = await KodeKegiatanAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = "success";
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = "fail";
      }
    },

    //load collection with params
    async get() {
      this.dataStatS2 = "loading";
      try {
        const response = await KodeKegiatanAPI.get();
        this.dataS2 = response.data.model;
        this.dataStatS2 = "success";
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = "fail";
      }
    },

    // create page
    async create() {
      this.dataStat = "loading";

      try {
        const response = await KodeKegiatanAPI.create();
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
        const response = await KodeKegiatanAPI.store(form);
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

    // edit page
    async edit(id) {
      this.dataStat = "loading";

      try {
        const response = await KodeKegiatanAPI.edit(id);
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

    // update data
    async update([id, form]) {
      this.updateStat = "loading";

      try {
        const response = await KodeKegiatanAPI.update(id, form);
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
        const response = await KodeKegiatanAPI.destroy(id);
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
