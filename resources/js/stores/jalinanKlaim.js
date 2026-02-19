import { defineStore } from 'pinia';
import JalinanKlaimAPI from '../api/jalinanKlaim';

export const useJalinanKlaimStore = defineStore('jalinanKlaim', {
  state: () => ({
    data: {}, //single data
    data2: {}, //single data
    message: {}, //single data
    message2: {}, //single data
    periode: {}, //single data
    history: [],
    dataS: [], //collection
    dataS1: [], //collection
    dataS2: [], //collection
    dataS3: [], //collection
    dataS4: [], //collection
    dataS5: [], //collection
    dataS6: [], //collection
    dataS7: [], //collection
    dataVeri1: [], //collection
    dataVeri2: [], //collection
    dataVeri3: [], //collection
    dataDeletedS: [], //collection
    count: {},
    headerDataS: [],
    historyStat: '',
    dataStat: '',
    dataStat2: '',
    messageStat: '',
    messageStat2: '',
    periodeStat: '',
    dataStatS: '',
    dataStatS1: '',
    dataStatS2: '',
    dataStatS3: '',
    dataStatS4: '',
    dataStatS5: '',
    dataStatS6: '',
    dataStatS7: '',
    dataStatVeri: '',
    dataDeletedStatS: '',
    countStat: '',
    headerDataStatS: '',
    update: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getData2: state => state.data2,
    getMessage: state => state.message,
    getMessage2: state => state.message2,
    getPeriode: state => state.periode,
    getHistory: state => state.history,
    getDataS: state => state.dataS,
    getDataS1: state => state.dataS1,
    getDataS2: state => state.dataS2,
    getDataS3: state => state.dataS3,
    getDataS4: state => state.dataS4,
    getDataS5: state => state.dataS5,
    getDataS6: state => state.dataS6,
    getDataS7: state => state.dataS7,
    getDataVeri1: state => state.dataVeri1,
    getDataVeri2: state => state.dataVeri2,
    getDataVeri3: state => state.dataVeri3,
    getDataDeletedS: state => state.dataDeletedS,
    getCount: state => state.count,
    getHeaderDataS: state => state.headerDataS,
    getHistoryStat: state => state.historyStat,
    getDataStat: state => state.dataStat,
    getDataStat2: state => state.dataStat2,
    getMessageStat: state => state.messageStat,
    getMessageStat2: state => state.messageStat2,
    getPeriodeStat: state => state.periodeStat,
    getDataStatS: state => state.dataStatS,
    getDataStatS1: state => state.dataStatS1,
    getDataStatS2: state => state.dataStatS2,
    getDataStatS3: state => state.dataStatS3,
    getDataStatS4: state => state.dataStatS4,
    getDataStatS5: state => state.dataStatS5,
    getDataStatS6: state => state.dataStatS6,
    getDataStatS7: state => state.dataStatS7,
    getDataStatVeri: state => state.dataStatVeri,
    getDataDeletedStatS: state => state.dataDeletedStatS,
    getCountStat: state => state.countStat,
    getHeaderDataStatS: state => state.headerDataStatS,
    getUpdate: state => state.update,
    getUpdateStat: state => state.updateStat,
    getRules: state => state.rules,
    getOptions: state => state.options,
  },

  actions: {
    //load collection with params
    async index([p, jenis, kategori, awal, akhir]) {
      this.dataStatS = 'loading';

      try {
        const response = await JalinanKlaimAPI.index(p, 0, awal, akhir);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async index1([p, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS1 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, 'semua', 1, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, 'semua', 1, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, 'semua', 1, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, 'semua', 1, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.index(p, 1, awal, akhir);
        }
        this.dataS1 = response.data.model;
        this.dataStatS1 = 'success';
      } catch (error) {
        this.dataS1 = error.response;
        this.dataStatS1 = 'fail';
      }
    },

    async index2([p, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS2 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, 'semua', 2, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, 'semua', 2, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, 'semua', 2, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, 'semua', 2, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.index(p, 2, awal, akhir);
        }
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async index3([p, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS3 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, 'semua', 3, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, 'semua', 3, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, 'semua', 3, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, 'semua', 3, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.index(p, 3, awal, akhir);
        }
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    async index4([p, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS4 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, 'semua', 4, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, 'semua', 4, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, 'semua', 4, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, 'semua', 4, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.index(p, 4, awal, akhir);
        }
        this.dataS4 = response.data.model;
        this.dataStatS4 = 'success';
      } catch (error) {
        this.dataS4 = error.response;
        this.dataStatS4 = 'fail';
      }
    },

    async index5([p, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS5 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, 'semua', 5, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, 'semua', 5, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, 'semua', 5, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, 'semua', 5, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.index(p, 5, awal, akhir);
        }
        this.dataS5 = response.data.model;
        this.dataStatS5 = 'success';
      } catch (error) {
        this.dataS5 = error.response;
        this.dataStatS5 = 'fail';
      }
    },

    async index6([p, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS6 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, 'semua', 6, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, 'semua', 6, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, 'semua', 6, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, 'semua', 6, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.index(p, 6, awal, akhir);
        }
        this.dataS6 = response.data.model;
        this.dataStatS6 = 'success';
      } catch (error) {
        this.dataS6 = error.response;
        this.dataStatS6 = 'fail';
      }
    },

    async index7([p, awal, akhir]) {
      this.dataStatS7 = 'loading';

      try {
        const response = await JalinanKlaimAPI.index(p, 7, awal, akhir);
        this.dataS7 = response.data.model;
        this.dataStatS7 = 'success';
      } catch (error) {
        this.dataS7 = error.response;
        this.dataStatS7 = 'fail';
      }
    },

    // load by cu
    async indexCu([p, cu, tp, awal, akhir]) {
      this.dataStatS = 'loading';

      try {
        const response = await JalinanKlaimAPI.indexCu(p, cu, tp, 0, awal, akhir);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexCu1([p, cu, tp, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS1 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, cu, 1, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, cu, 1, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, cu, 1, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, cu, 1, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.indexCu(p, cu, tp, 1, awal, akhir);
        }
        this.dataS1 = response.data.model;
        this.dataStatS1 = 'success';
      } catch (error) {
        this.dataS1 = error.response;
        this.dataStatS1 = 'fail';
      }
    },

    async indexCu2([p, cu, tp, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS2 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, cu, 2, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, cu, 2, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, cu, 2, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, cu, 2, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.indexCu(p, cu, tp, 2, awal, akhir);
        }
        this.dataS2 = response.data.model;
        this.dataStatS2 = 'success';
      } catch (error) {
        this.dataS2 = error.response;
        this.dataStatS2 = 'fail';
      }
    },

    async indexCu3([p, cu, tp, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS3 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, cu, 3, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, cu, 3, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, cu, 3, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, cu, 3, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.indexCu(p, cu, tp, 3, awal, akhir);
        }
        this.dataS3 = response.data.model;
        this.dataStatS3 = 'success';
      } catch (error) {
        this.dataS3 = error.response;
        this.dataStatS3 = 'fail';
      }
    },

    async indexCu4([p, cu, tp, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS4 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, cu, 4, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, cu, 4, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, cu, 4, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, cu, 4, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.indexCu(p, cu, tp, 4, awal, akhir);
        }
        this.dataS4 = response.data.model;
        this.dataStatS4 = 'success';
      } catch (error) {
        this.dataS4 = error.response;
        this.dataStatS4 = 'fail';
      }
    },

    async indexCu5([p, cu, tp, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS5 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, cu, 5, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, cu, 5, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, cu, 5, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, cu, 5, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.indexCu(p, cu, tp, 5, awal, akhir);
        }
        this.dataS5 = response.data.model;
        this.dataStatS5 = 'success';
      } catch (error) {
        this.dataS5 = error.response;
        this.dataStatS5 = 'fail';
      }
    },

    async indexCu6([p, cu, tp, jenis, kategori, dari, ke, awal, akhir]) {
      this.dataStatS6 = 'loading';

      try {
        let response;
        if (jenis == 'lama') {
          response = await JalinanKlaimAPI.indexLaporanLamaDetail(p, cu, 6, dari, ke, awal, akhir);
        } else if (jenis == 'usia') {
          response = await JalinanKlaimAPI.indexLaporanUsiaDetail(p, cu, 6, dari, ke, awal, akhir);
        } else if (jenis == 'penyebab') {
          response = await JalinanKlaimAPI.indexLaporanPenyebabDetail(p, cu, 6, kategori, awal, akhir);
        } else if (jenis == 'cu') {
          response = await JalinanKlaimAPI.indexLaporanCuDetail(p, cu, 6, awal, akhir);
        } else {
          response = await JalinanKlaimAPI.indexCu(p, cu, tp, 6, awal, akhir);
        }
        this.dataS6 = response.data.model;
        this.dataStatS6 = 'success';
      } catch (error) {
        this.dataS6 = error.response;
        this.dataStatS6 = 'fail';
      }
    },

    async create() {
      this.dataStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.create();
        this.data = response.data.form;
        this.rules = response.data.rules;
        this.options = response.data.options;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    async store(form) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.store(form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async edit(params) {
      this.dataStat = 'loading';
      try {
        let response;
        if (Array.isArray(params)) {
          response = await JalinanKlaimAPI.edit(params[0], params[1], params[2]);
        } else {
          response = await JalinanKlaimAPI.getKlaim(params);
        }
        this.data = response.data.form;
        this.rules = response.data.rules;
        this.options = response.data.options;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    async update([id, form]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.update(id, form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async destroy(id) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.destroy(id);
        if (response.data.deleted) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async cariData(params) {
      this.dataStat2 = 'loading';
      try {
        let response;
        if (Array.isArray(params) && params.length > 1) {
          // If 3 params, maybe it logic similar to edit but for data2? 
          // But cariData in form.vue only calls [nik] or [nik, cu, tipe]. 
          // API cariData takes nik.
          // If we pass [nik, cu, tipe], it might be for 'cariData' in API context?
          // Actually JalinanKlaimAPI.cariData takes nik. 
          // If I assume array means use array logic or just first element?
          // In form.vue it seems to want to search member data.
          // Let's assume params[0] is nik.
          let nik = params[0] || params;
          response = await JalinanKlaimAPI.cariData(nik);
        } else {
          let nik = Array.isArray(params) ? params[0] : params;
          response = await JalinanKlaimAPI.cariData(nik);
        }
        this.data2 = response.data.model;
        this.dataStat2 = 'success';
      } catch (error) {
        this.data2 = error.response;
        this.dataStat2 = 'fail';
      }
    },

    resetForm() {
      this.data = {};
      this.dataStat = '';
      this.rules = [];
      this.options = [];
    },

    setData2(data) {
      this.data2 = data;
    },

    setDataStat2(stat) {
      this.dataStat2 = stat;
    },

    async updateStatus([id, form]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateStatus(id, form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateNoSurat([id, form]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateNoSurat(id, form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateSelesai(id) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateSelesai(id);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async periksaKoreksi([id, form]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.periksaKoreksi(id, form);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async getDuplicate([name, tanggal, tipe]) {
      this.dataStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.getDuplicate(name, tanggal, tipe);
        this.data = response.data.model; // messageData mapped to data
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    async getKlaimLama([nik, cu]) {
      this.messageStat2 = 'loading';
      try {
        const response = await JalinanKlaimAPI.getKlaimLama(nik, cu);
        this.message2 = response.data.message;
        this.messageStat2 = 'success';
      } catch (error) {
        this.message2 = error.response;
        this.messageStat2 = 'fail';
      }
    },

    async getHistory(id) {
      this.historyStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.getHistory(id);
        this.history = response.data.model;
        this.historyStat = 'success';
      } catch (error) {
        this.history = error.response;
        this.historyStat = 'fail';
      }
    },

    async getVerifikator([pengurus, pengawas, manajemen]) {
      this.dataStatVeri = 'loading';
      try {
        const response = await JalinanKlaimAPI.getVerifikator(pengurus, pengawas, manajemen);
        this.dataVeri1 = response.data.pengurus;
        this.dataVeri2 = response.data.pengawas;
        this.dataVeri3 = response.data.manajemen;
        this.dataStatVeri = 'success';
      } catch (error) {
        this.dataStatVeri = 'fail';
      }
    },

    async updateVerifikasi([id, user]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateVerifikasi(id, user);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async indexCair([p, cu, awal, akhir]) {
      this.dataStatS = 'loading';
      try {
        const response = await JalinanKlaimAPI.indexCair(p, cu || 'semua', awal, akhir);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async updateCair([cu_id, awal, akhir]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateCair(cu_id, awal, akhir);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateCairAll([awal, akhir]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateCairAll(awal, akhir);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    async updateCairBatal([cu_id, awal, akhir]) {
      this.updateStat = 'loading';
      try {
        const response = await JalinanKlaimAPI.updateCairBatal(cu_id, awal, akhir);
        if (response.data.saved) {
          this.update = response.data;
          this.updateStat = 'success';
        } else {
          this.updateStat = 'fail';
        }
      } catch (error) {
        this.update = error.response;
        this.updateStat = 'fail';
      }
    },

    resetUpdateStat() {
      this.update = [];
      this.updateStat = '';
    }
  }
});
