import { defineStore } from 'pinia';
import PusAPI from '../api/pus.js';

export const usePusStore = defineStore('pus', {
  state: () => ({
    pusS: [],
    pusLoadStatS: '',
    pus: {},
    pusLoadStat: '',
    pusUpdate: [],
    pusUpdateStat: '',
  }),

  getters: {
    getPusS: state => state.pusS,
    getPusLoadStatS: state => state.pusLoadStatS,
    getPus: state => state.pus,
    getPusLoadStat: state => state.pusLoadStat,
    getPusUpdateStat: state => state.pusUpdateStat,
    getPusUpdate: state => state.pusUpdate,
  },

  actions: {
    async loadPusS(p) {
      this.pusLoadStatS = 'loading';

      try {
        const response = await PusAPI.getPusS(p);
        this.pusS = response.data.model;
        this.pusLoadStatS = 'success';
      } catch (error) {
        this.pusS = [];
        this.pusLoadStatS = 'fail';
      }
    },

    async loadPusAll() {
      this.pusLoadStatS = 'loading';

      try {
        const response = await PusAPI.getPusAll();
        this.pusS = response.data.model;
        this.pusLoadStatS = 'success';
      } catch (error) {
        this.pusS = [];
        this.pusLoadStatS = 'fail';
      }
    },

    async loadPus(id) {
      this.pusLoadStat = 'loading';

      try {
        const response = await PusAPI.getPus(id);
        this.pus = response.data;
        this.pusLoadStat = 'success';
      } catch (error) {
        this.pus = {}; // Was [] in Vuex, but object seems more appropriate for single item
        this.pusLoadStat = 'fail';
      }
    },

    async storePus(form) {
      this.pusUpdateStat = 'loading';

      try {
        const response = await PusAPI.storePus(form);
        this.pusUpdate = response.data;
        this.pusUpdateStat = 'success';
      } catch (error) {
        this.pusUpdate = error.response;
        this.pusUpdateStat = 'fail';
      }
    },

    async updatePus(form) {
      this.pusUpdateStat = 'loading';

      try {
        const response = await PusAPI.updatePus(form);
        this.pusUpdate = response.data;
        this.pusUpdateStat = 'success';
      } catch (error) {
        this.pusUpdate = error.response;
        this.pusUpdateStat = 'fail';
      }
    },

    async deletePus(id) {
      this.pusUpdateStat = 'loading';

      try {
        const response = await PusAPI.deletePus(id);
        this.pusUpdate = response.data;
        this.pusUpdateStat = 'success';
      } catch (error) {
        this.pusUpdate = error.response;
        this.pusUpdateStat = 'fail';
      }
    },

    resetPusUpdateStat() {
      this.pusUpdateStat = '';
    }
  },
});
