import { defineStore } from 'pinia';
import AnggotaCuAPI from '../api/anggotaCu.js';
import AnggotaCuDraftAPI from '../api/anggotaCuDraft.js';
import AnggotaProdukCuDraftAPI from '../api/anggotaProdukCuDraft.js';

export const useAnggotaCuStore = defineStore('anggotaCu', {
  state: () => ({
    data: {}, //single data //single data
    dataS: [],
    dataS2: [],
    dataS3: [],
    dataProduk: [],//collection
    dataProdukSaldo: [],//collection
    dataDeletedS: [], //collection
    count: {},
    headerDataS: [],
    dataStat: '',
    dataProdukStat: '',
    dataProdukSaldoStat: '',
    dataStatS: '',
    dataStatS2: '',
    dataStatS3: '',
    dataDeletedStatS: '',
    countStat: '',
    headerDataStatS: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getDataS2: state => state.dataS2,
    getDataS3: state => state.dataS3,
    getDataProduk: state => state.dataProduk,
    getDataProdukSaldo: state => state.dataProdukSaldo,
    getDataDeletedS: state => state.dataDeletedS,
    getCount: state => state.count,
    getHeaderDataS: state => state.headerDataS,
    getDataStat: state => state.dataStat,
    getDataProdukStat: state => state.dataProdukStat,
    getDataProdukSaldoStat: state => state.dataProdukSaldoStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS2: state => state.dataStatS2,
    getDataStatS3: state => state.dataStatS3,
    getDataDeletedStatS: state => state.dataDeletedStatS,
    getCountStat: state => state.countStat,
    getHeaderDataStatS: state => state.headerDataStatS,
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
        const response = await AnggotaCuAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexKeluar(p) {
      this.dataStatS2 = 'loading';

      try {
        const response = await AnggotaCuAPI.indexKeluar(p);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async indexMeninggal(p) {
      this.dataStatS3 = 'loading';

      try {
        const response = await AnggotaCuAPI.indexMeninggal(p);
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    async indexCu([p, cu, tp]) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaCuAPI.indexCu(p, cu, tp);
        if (response.data.model) {
          this.dataS = response.data.model;
          this.dataStatS = 'success';
        } else {
          this.dataS = response;
          this.dataStatS = 'fail';
        }
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCuFasilitator([p, cu, tp]) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaCuAPI.indexCuFasilitator(p, cu, tp);
        if (response.data.model) {
          this.dataS = response.data.model;
          this.dataStatS = 'success';
        } else {
          this.dataS = response;
          this.dataStatS = 'fail';
        }
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCuMentor([p, cu, tp]) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaCuAPI.indexCuMentor(p, cu, tp);
        if (response.data.model) {
          this.dataS = response.data.model;
          this.dataStatS = 'success';
        } else {
          this.dataS = response;
          this.dataStatS = 'fail';
        }
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCuKeluar([p, cu, tp]) {
      this.dataStatS2 = 'loading';

      try {
        const response = await AnggotaCuAPI.indexCuKeluar(p, cu, tp);
        if (response.data.model) {
          this.dataS2 = response.data.model;
          this.dataStatS2 = 'success';
        } else {
          this.dataS2 = response;
          this.dataStatS2 = 'fail';
        }
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async indexCuMeninggal([p, cu, tp]) {
      this.dataStatS3 = 'loading';

      try {
        const response = await AnggotaCuAPI.indexCuMeninggal(p, cu, tp);
        if (response.data.model) {
          this.dataS3 = response.data.model;
          this.dataStatS3 = 'success';
        } else {
          this.dataS3 = response;
          this.dataStatS3 = 'fail';
        }
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    async indexCuDraft([p, cu, tp]) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.index(p, cu, tp);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexProdukCuDraft([p, cu]) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.index(p, cu);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexProduk([p, id, cu]) {
      this.dataProdukStat = 'loading';

      try {
        const response = await AnggotaCuAPI.indexProduk(p, id, cu);
        this.dataProduk = response.data.model;
        this.dataProdukStat = 'success';
      } catch (error) {
        this.dataProduk = error.response;
        this.dataProdukStat = 'fail';
      }
    },

    async indexProdukSaldo([p, id]) {
      this.dataProdukSaldoStat = 'loading';

      try {
        const response = await AnggotaCuAPI.indexProdukSaldo(p, id);
        this.dataProdukSaldo = response.data.model;
        this.dataProdukSaldoStat = 'success';
      } catch (error) {
        this.dataProdukSaldo = error.response;
        this.dataProdukSaldoStat = 'fail';
      }
    },

    async getCu(id) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaCuAPI.getCu(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async getCuKeluar(id) {
      this.dataStatS2 = 'loading';

      try {
        const response = await AnggotaCuAPI.getCuKeluar(id);
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async getCuJalinan([id, bulan, tahun]) {
      this.dataStatS = 'loading';

      try {
        const response = await AnggotaCuAPI.getCuJalinan(id, bulan, tahun);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async cariDataInformasi(nik) {
      this.dataStat = 'loading';

      try {
        const response = await AnggotaCuAPI.cariDataInformasi(nik);
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

    async cariDataKTP(nik) {
      this.dataStat = 'loading';

      try {
        const response = await AnggotaCuAPI.cariDataKTP(nik);
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

    async cariDataBA([id, ba]) {
      this.dataStat = 'loading';

      try {
        const response = await AnggotaCuAPI.cariDataBA(id, ba);
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
        const response = await AnggotaCuAPI.create();
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
        const response = await AnggotaCuAPI.store(form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeProduk([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.storeProduk(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.store(id);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeDraftAll(cu) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.storeAll(cu);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeProdukCuDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.store(id);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async storeProdukCuDraftAll(cu) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.storeAll(cu);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },


    // edit page
    async edit(id) {
      this.dataStat = 'loading';

      try {
        const response = await AnggotaCuAPI.edit(id);
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

    async editDraft(id) {
      this.dataStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.edit(id);
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

    async editProdukCuDraft(id) {
      this.dataStat = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.edit(id);
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
        const response = await AnggotaCuAPI.update(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateProduk([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.updateProduk(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updatePindahTp([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.updatePindahTp(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateKeluar([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.updateKeluar(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateBatalKeluar(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.updateBatalKeluar(id);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateNik([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.updateNik(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateDraft([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.update(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateProdukCuDraft([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.update(id, form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async restore(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.restore(id);
        if (response.data.restored) {
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
    async destroy([id, cu]) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.destroy(id, cu);
        if (response.data.deleted) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async destroyProduk(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.destroyProduk(id);
        if (response.data.deleted) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async destroyDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.destroy(id);
        if (response.data.deleted) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async destroyDraftAll(cu) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.destroyAll(cu);
        if (response.data.deleted) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async destroyProdukCuDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.destroy(id);
        if (response.data.deleted) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async destroyProdukCuDraftAll(cu) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaProdukCuDraftAPI.destroyAll(cu);
        if (response.data.deleted) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async uploadExcel(form) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.uploadExcel(form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async uploadExcelNew(form) {
      this.updateStat = 'loading';

      try {
        const response = await AnggotaCuAPI.uploadExcelNew(form);
        if (response.data.saved) {
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
        this.updateData = response.data;
      } catch (error) {
        this.updateData = error.response;
        this.updateStat = 'fail';
      }
    },

    async count() {
      this.countStat = 'loading';

      try {
        const response = await AnggotaCuAPI.count();
        this.count = response.data.model;
        this.countStat = 'success';
      } catch (error) {
        this.count = error.response;
        this.countStat = 'fail';
      }
    },

    async countDraft() {
      this.countStat = 'loading';

      try {
        const response = await AnggotaCuDraftAPI.count();
        this.count = response.data.model;
        this.countStat = 'success';
      } catch (error) {
        this.count = error.response;
        this.countStat = 'fail';
      }
    },

    // reset
    resetData() {
      this.data = {};
      this.dataStat = '';
    },
    resetUpdateStat() {
      this.updateStat = '';
    },
    resetDataProduk() {
      this.dataProduk = [];
      this.dataProdukStat = '';
    },
    resetDataProdukSaldo() {
      this.dataProdukSaldo = [];
      this.dataProdukSaldoStat = '';
    }
  },
});
