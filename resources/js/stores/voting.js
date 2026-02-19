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
    update: [], //update data
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
    getUpdate: state => state.update,
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
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.update = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeSuara(form) {
      this.updateStat = 'loading';
      try {
        const response = await VotingAPI.storeSuara(form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.update = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async storePilihan(form) {
      this.updateStat = 'loading';

      try {
        const response = await VotingAPI.storePilihan(form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.update = response.data;
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async checkUser(id) {
      this.dataStat2 = 'loading';

      try {
        const response = await KEGIATANBKCUAPI.checkUser(id);
        this.data2 = response.data.model; // Note: data2 was not in state declaration in Vuex file but set in mutation? No wait, Vuex state didn't list data2. Wait indexPilihan sets data (form) and dataS (model).
        // The Vuex code has: commit('setData2', response.data.model );
        // But state doesn't have data2.
        // Let's look at Vuex file again.
        // state: { ... dataS2 ... }
        // mutations: { setData2 ( state, data ){ state.dataS2 = data; }, ... } Wait
        // Mutation setData2 sets dataS2? No wait.
        /*
          setDataS2 ( state, data ){
            state.dataS2 = data;
          },
        */
        // But checkUser action calls `commit('setData2', ...)`
        // Is there a setData2 mutation?
        // Please check the Vuex file content I read.
        /*
        425:     setDataS3 ( state, data ){
        426:       state.dataS3 = data;
        427:     },
        ...
        Inside checkUser:
        248:           commit('setData2', response.data.model );
        
        Available mutations:
        setData, setDataS, setDataS2, setDataS3, setDataS4, setCount...
        There is NO setData2 mutation in the Vuex file I read!
        Ah, wait. Let me re-read carefully.
        Step 1281 output.
        Line 248: commit('setData2', response.data.model );
        Line 394 and onwards (mutations):
        setData, setDataS, setDataS2, setDataS3, setDataS4, setCount, setDataStat...
        There is indeed NO `setData2` mutation! This code `commit('setData2')` in Vuex would have failed or done nothing if not defined? OR maybe it was a typo in my reading?
        Actually, looking at `surat.js`, it had `data2`.
        But `voting.js` content from Step 1281:
        ...
        248:           commit('setData2', response.data.model );
        ...
        416:   // mutations
        417:   mutations: {
        418:     setData ( state, data ){ ...
        419:     setDataS ( state, data ){ ...
        424:     setDataS2 ( state, data ){ ...
        
        So `setData2` does not exist. It likely meant `setDataS2` or it is a bug in the old code.
        However, `checkUser` is used for checking if user has voted?
        If I look at `pemilihan.js`, `checkUser` also called `setData2`. And `pemilihan.js` DID NOT have `data2` in state either!
        Wait, `pemilihan.js` (Step 1244):
        state: { ... data: {}, dataS: [], dataS2: [] ... }
        action checkUser: commit('setData2', ...)
        mutations: setData, setDataS, setDataS2...
        So `setData2` is missing there too.
        
        If the mutation doesn't exist, the commit would throw an error in Vuex strict mode, or do nothing?
        In any case, for Pinia, I should probably adhere to what *makes sense* or what the intention was.
        If it's fetching a user check result, maybe it should be stored in `data2` if `dataS2` is used for something else (like collection).
        In `voting.js`, `indexVoting` uses `dataS2`.
        `indexVotingCu` uses `dataS2`.
        `indexSuara` uses `dataS2`.
        `checkUser` is likely checking a single user status.
        And `surat.js` had `data2`.
        
        I will add `data2` to state and `dataStat2` (which is used in `checkUser` commit `setDataStat2`) to state to be safe and support this "hidden" feature if it was intended, or fix the bug.
        `setDataStat2` DOES exist in methods like `indexVoting`? No, `indexVoting` uses `commit('setDataStatS2', ...)`
        BUT `checkUser` calls `commit('setDataStat2', ...)`
        And `setDataStat2` mutation DOES exist?
        Step 1281:
        442:     setDataStatS2( state, status ){
        
        There is `setDataStatS2`, but is there `setDataStat2`?
        Scanning mutations...
        `setDataStat`, `setDataStatS`, `setDataStatS2`, `setDataStatS3`, `setDataStatS4`.
        There is NO `setDataStat2`.
        
        So `checkUser` in `voting.js` (and `pemilihan.js`) seems to be calling non-existent mutations (`setData2`, `setDataStat2`).
        This implies the code might be broken or dead code.
        However, I should probably fix it or support it.
        I'll add `data2` and `dataStat2` to the Pinia state to be safe, just in case.
        or maybe it was `setDataS2` and `setDataStatS2`?
        But `checkUser` returns a single model. `dataS2` is usually a collection.
        I'll add `data2` and `dataStat2`.
    
    */
    async checkUser(id) {
          this.dataStat2 = 'loading'; // I'll add this to state
          try {
            const response = await KEGIATANBKCUAPI.checkUser(id);
            this.data2 = response.data.model; // I'll add this to state
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
              this.update = response.data;
              this.updateStat = 'success';
            } else {
              this.update = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.update = error.response;
            this.updateStat = 'fail';
          }
        },

    async updateSuara([id, form]){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.updateSuara(id, form);
            if (response.data.saved) {
              this.update = response.data;
              this.updateStat = 'success';
            } else {
              this.update = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.update = error.response;
            this.updateStat = 'fail';
          }
        },

    async updateSuaraCu(form){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.updateSuaraCu(form);
            if (response.data.saved) {
              this.update = response.data;
              this.updateStat = 'success';
            } else {
              this.update = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.update = error.response;
            this.updateStat = 'fail';
          }
        },

    // destroy data
    async destroy(id){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.destroy(id);
            if (response.data.deleted) {
              this.update = response.data;
              this.updateStat = 'success';
            } else {
              this.update = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.update = error.response;
            this.updateStat = 'fail';
          }
        },

    async destroySuara(id){
          this.updateStat = 'loading';

          try {
            const response = await VotingAPI.destroySuara(id);
            if (response.data.deleted) {
              this.update = response.data;
              this.updateStat = 'success';
            } else {
              this.update = response.data;
              this.updateStat = 'fail';
            }
          } catch (error) {
            this.update = error.response;
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
