import { defineStore } from 'pinia';

/**
 * Minimal store for aset tetap kondisi.
 * Form uses static options (Baik, Diperbaiki, Rusak, etc.); no backend API.
 * Exists so formKondisi.vue can call resetDataS() and get() without errors.
 */
export const useAsetTetapKondisiStore = defineStore('asetTetapKondisi', {
  state: () => ({
    dataS: [],
    dataStatS: '',
    updateData: [],
    updateStat: '',
  }),

  getters: {
    getDataS: (state) => state.dataS,
    getDataStatS: (state) => state.dataStatS,
    getUpdate: (state) => state.updateData,
    getUpdateStat: (state) => state.updateStat,
  },

  actions: {
    resetDataS() {
      this.dataS = [];
      this.dataStatS = '';
    },

    async get() {
      this.dataStatS = 'loading';
      this.dataS = [];
      this.dataStatS = 'success';
    },
  },
});
