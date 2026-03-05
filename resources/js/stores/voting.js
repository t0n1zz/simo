import { defineStore } from 'pinia';
import VotingAPI from '../api/voting.js';
import KEGIATANBKCUAPI from '../api/kegiatanBKCU.js';

export const useVotingStore = defineStore('voting', {
  state: () => ({
    data: {}, //single data
    data2: {}, //single data
    dataS: [], //collection
    dataS2: [], //collection
    dataS3: [], //collection
    dataS4: [], //collection
    count: {},
    dataStat: '',
    dataStat2: '',
    dataStatS: '',
    dataStatS2: '',
    dataStatS3: '',
    dataStatS4: '',
    countStat: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getData2: state => state.data2,
    getDataS: state => state.dataS,
    getDataS2: state => state.dataS2,
    getDataS3: state => state.dataS3,
    getDataS4: state => state.dataS4,
    getCount: state => state.count,
    getDataStat: state => state.dataStat,
    getDataStat2: state => state.dataStat2,
    getDataStatS: state => state.dataStatS,
    getDataStatS2: state => state.dataStatS2,
    getDataStatS3: state => state.dataStatS3,
    getDataStatS4: state => state.dataStatS4,
    getCountStat: state => state.countStat,
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
        const response = await VotingAPI.index(p);
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
        const response = await VotingAPI.indexCu(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexVoting() {
      this.dataStatS2 = 'loading';

      try {
        const response = await VotingAPI.indexVoting();
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async indexVotingCu(id) {
      this.dataStatS2 = 'loading';

      try {
        const response = await VotingAPI.indexVotingCu(id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async indexPilihan(name) {
      this.dataStatS = 'loading';
      this.dataStat = 'loading';

      try {
        const response = await VotingAPI.indexPilihan(name);
        this.dataS = response.data.model;
        this.data = response.data.form;
        this.dataStatS = 'success';
        this.dataStat = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.data = error.response;
        this.dataStatS = 'fail';
        this.dataStat = 'fail';
      }
    },

    async indexSuara(id) {
      this.dataStatS2 = 'loading';

      try {
        const response = await VotingAPI.indexSuara(id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async indexDataSuara([p, id]) {
      this.dataStatS3 = 'loading';

      try {
        const response = await VotingAPI.indexDataSuara(p, id);
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    async indexDataTanggapan([p, id]) {
      this.dataStatS4 = 'loading';

      try {
        const response = await VotingAPI.indexDataTanggapan(p, id);
        this.dataS4 = response.data.model;
        this.dataStatS4 = 'success';
      } catch (error) {
        this.dataS4 = error.response;
        this.dataStatS4 = 'fail';
      }
    },

    async create() {
      this.dataStat = 'loading';

      try {
        const response = await VotingAPI.create();
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
        const response = await VotingAPI.store(form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = 'success';
        } else {
          this.updateData = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeSuara(form) {
      this.updateStat = 'loading';
      try {
        const response = await VotingAPI.storeSuara(form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = 'success';
        } else {
          this.updateData = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storePilihan(form) {
      this.updateStat = 'loading';

      try {
        const response = await VotingAPI.storePilihan(form);
        if (response.data.saved) {
          this.updateData = response.data;
          this.updateStat = 'success';
        } else {
          this.updateData = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async checkUser(id) {
      this.dataStat2 = 'loading';

      try {
        const response = await KEGIATANBKCUAPI.checkUser(id);
        this.data2 = response.data.model;
        this.dataStat2 = 'success';
      } catch (error) {
        this.data2 = error.response;
        this.dataStat2 = 'fail';
      }
    },

    // edit page
    async edit(id){
          this.dataStat = 'loading';

          try {
            const response = await VotingAPI.edit(id);
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
    async updateStatus([id, cu]){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.updateStatus(id, cu);
            if (response.data.saved) {
              this.updateData = response.data;
              this.updateStat = 'success';
            } else {
              this.updateData = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.updateData = error.response;
            this.updateStat = 'fail';
          }
        },

    async updateSuara([id, form]){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.updateSuara(id, form);
            if (response.data.saved) {
              this.updateData = response.data;
              this.updateStat = 'success';
            } else {
              this.updateData = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.updateData = error.response;
            this.updateStat = 'fail';
          }
        },

    async updateSuaraCu(form){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.updateSuaraCu(form);
            if (response.data.saved) {
              this.updateData = response.data;
              this.updateStat = 'success';
            } else {
              this.updateData = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.updateData = error.response;
            this.updateStat = 'fail';
          }
        },

    // destroy data
    async destroy(id){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.destroy(id);
            if (response.data.deleted) {
              this.updateData = response.data;
              this.updateStat = 'success';
            } else {
              this.updateData = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.updateData = error.response;
            this.updateStat = 'fail';
          }
        },

    async destroySuara(id){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.destroySuara(id);
            if (response.data.deleted) {
              this.updateData = response.data;
              this.updateStat = 'success';
            } else {
              this.updateData = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.updateData = error.response;
            this.updateStat = 'fail';
          }
        },

    async countCalon(id){
          this.countStat = 'loading';

          try {
            const response = await VotingAPI.countCalon(id);
            this.count = response.data.model;
            this.countStat = 'success';
          } catch (error) {
            this.count = error.response;
            this.countStat = 'fail';
          }
        },

    async countSuara(id){
          this.countStat = 'loading';

          try {
            const response = await VotingAPI.countSuara(id);
            this.count = response.data.model;
            this.countStat = 'success';
          } catch (error) {
            this.count = error.response;
            this.countStat = 'fail';
          }
        },

        // reset
        resetUpdateStat(){
          this.updateStat = '';
        },
        resetData(){
          this.data = {};
          this.dataStat = '';
        },
        resetDataS(){
          this.dataS = [];
          this.dataStatS = '';
        },

      },
    });
