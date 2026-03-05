import { defineStore } from 'pinia';

/**
 * Store for dokumen penulis (by CU).
 * Backend may not expose getCu yet; getCu is a no-op until API route exists.
 */
export const useDokumenPenulisStore = defineStore('dokumenPenulis', {
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
    async getCu(_id) {
      this.dataStatS = 'loading';
      this.dataS = [];
      this.dataStatS = 'success';
    },
  },
});
