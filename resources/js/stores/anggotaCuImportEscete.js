import { defineStore } from 'pinia';
import ANGGOTAIMPORTESCETEAPI from '../api/anggotaCuImportEscete.js';

export const useAnggotaCuImportEsceteStore = defineStore('anggotaCuImportEscete', {
  state: () => ({
    dataS: [],
    dataStatS: '',
    update: [], //update data
    updateStat: '',
    isDraft: ''
  }),

  getters: {
    getDataS: state => state.dataS,
    getDataStatS: state => state.dataStatS,
    getUpdate: state => state.update,
    getUpdateStat: state => state.updateStat,
    getIsDraft: state => state.isDraft
  },

  actions: {
    async index([id_cu]) {
      this.dataStatS = 'loading';
      try {
        const response = await ANGGOTAIMPORTESCETEAPI.index(id_cu);
        this.dataStatS = 'success';
        this.isDraft = response.data.isDraft;
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async draft([id_cu, id_user]) {
      this.updateStat = 'loading';
      try {
        const response = await ANGGOTAIMPORTESCETEAPI.draft(id_cu, id_user);
        if (response.data.processed) {
          this.updateStat = 'loading';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    //store data
    async simpanDraft(id_cu) {
      this.updateStat = 'loading';
      try {
        const response = await ANGGOTAIMPORTESCETEAPI.simpanDraft(id_cu);
        if (response.data.processed) {
          this.updateStat = 'loading';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    setIsDraft(isDraft) {
      this.isDraft = isDraft
    }
  }
});
