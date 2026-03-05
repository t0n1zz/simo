import { defineStore } from 'pinia';
import LaporanCuAPI from '../api/laporanCu.js';
import LaporanCuDraftAPI from '../api/laporanCuDraft.js';
import LaporanTpAPI from '../api/laporanTp.js';
import LaporanTpDraftAPI from '../api/laporanTpDraft.js';

export const useLaporanCuStore = defineStore('laporanCu', {
  state: () => ({
    data: {}, //single data
    dataS: [], //collection
    history: [],
    grafik: [],
    grafikPearls: [],
    pearls: [],
    periode: [],
    idCU: null,
    columnData: [
      {//0
        title: "No.",
      },
      {//1
        title: "Nama CU",
        name: "cu.name",
        excelName: "cu_name",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      },
      {//2
        title: "Nama TP/KP",
        name: "tp.name",
        excelName: "tp_name",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      },
      {//3
        title: "No. BA",
        name: "laporan_cu.no_ba",
        excelName: "no_ba",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true
      },
      {//4
        title: "Provinsi",
        name: "provinces.name",
        excelName: "provinces_name",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true
      },
      {//5
        title: "Periode",
        name: "periode",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      },
      {//6
        title: "Jmlh. TP/KP",
        name: "tp",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true
      },
      {//7
        title: "Lelaki Biasa",
        name: "l_biasa",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//8
        title: "Lelaki L.Biasa",
        name: "l_lbiasa",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//9
        title: "Perempuan Biasa",
        name: "p_biasa",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//10
        title: "Perempuan L.Biasa",
        name: "p_lbiasa",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//11
        title: "Total Anggota",
        name: "total_anggota",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: true
      },
      {//12
        title: "Total Anggota Lalu",
        name: "total_anggota_lalu",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//13
        title: "Aset",
        name: "aset",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true,
        filterDefault: true
      },
      {//14
        title: "Aset Lalu",
        name: "aset_lalu",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//15
        title: "Aset Masalah",
        name: "aset_masalah",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//16
        title: "Aset Tdk Menghasilkan",
        name: "aset_tidak_menghasilkan",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//17
        title: "Aset Likuid Tdk Menghasilkan",
        name: "aset_likuid_tidak_menghasilkan",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//18
        title: "Aktiva Lancar",
        name: "aktiva_lancar",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//19
        title: "Simp. Saham",
        name: "simpanan_saham",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//20
        title: "Simp. Saham Lalu",
        name: "simpanan_saham_lalu",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//21
        title: "Simp. Saham Des",
        name: "simpanan_saham_des",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//22
        title: "Simp. Nonsaham Unggulan",
        name: "nonsaham_unggulan",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//23
        title: "Simp. Nonsaham Harian",
        name: "nonsaham_harian",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//24
        title: "Hutang SPD",
        name: "hutang_spd",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//25
        title: "Hutang Tdk Berbiaya",
        name: "hutang_tidak_berbiaya_30hari",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//26
        title: "Total Hutang Pihak Ke-3",
        name: "total_hutang_pihak3",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//27
        title: "Piutang Beredar",
        name: "piutang_beredar",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//28
        title: "Piutang Bersih",
        name: "piutang_bersih",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false
      },
      {//29
        title: "Piutang Anggota",
        name: "piutang_anggota",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//30
        title: "Piutang Lalai 1-12 Bulan",
        name: "piutang_lalai_1bulan",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//31
        title: "Piutang Lalai > 12 Bulan",
        name: "piutang_lalai_12bulan",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//32
        title: "Rasio Piutang Beredar",
        name: "rasio_beredar",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false
      },
      {//33
        title: "Rasio Piutang Lalai",
        name: "rasio_lalai",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false
      },
      {//34
        title: "DCR",
        name: "dcr",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//35
        title: "DCU",
        name: "dcu",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//36
        title: "Dana Gedung",
        name: "dana_gedung",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//37
        title: "Donasi",
        name: "donasi",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//38
        title: "BJS Saham",
        name: "bjs_saham",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//39
        title: "Beban Penyisihan DCR",
        name: "beban_penyisihan_dcr",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//40
        title: "Investasi Likuid",
        name: "investasi_likuid",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//41
        title: "Total Pendapatan",
        name: "total_pendapatan",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//42
        title: "Total Biaya",
        name: "total_biaya",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//43
        title: "SHU",
        name: "shu",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//44
        title: "SHU Lalu",
        name: "shu_lalu",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//45
        title: "Rata-rata Aset",
        name: "rata_aset",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//46
        title: "Laju Inflasi",
        name: "laju_inflasi",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//47
        title: "Harga Pasar",
        name: "harga_pasar",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: true,
        isChartSelect: false,
        filter: true
      },
      {//48
        title: "Tgl. Buat",
        name: "created_at",
        tipe: "datetime",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true
      },
      {//49
        title: "Tgl. Ubah",
        name: "updated_at",
        tipe: "datetime",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true
      },
    ],
    columnDataPearls: [
      {//0
        title: "No.",
        name: "No.",
      },
      {//1
        title: "CU",
        name: "cu.name",
        excelName: "cu_name",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
        filterDefault: true
      },
      {//2
        title: "TP",
        name: "tp.name",
        excelName: "tp_name",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
        filterDefault: false
      },
      {//3
        title: "No. BA",
        name: "laporan_cu.no_ba",
        excelName: "no_ba",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      },
      {//4
        title: "Provinsi",
        name: "provinces.name",
        excelName: "provinces_name",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false
      },
      {//5
        title: "Periode",
        name: "periode",
        tipe: "datetime",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
        filterDefault: false
      },
      {//6
        title: "Jmlh TP/KP",
        name: "tp",
        tipe: "string",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      },
      {//7
        title: "Ideal",
        name: "tot_ideal",
        tipe: "numeric",
        sort: false,
        hide: false,
        disable: false,
        isChart: false,
        filter: false,
        filterDefault: false
      },
      {//8
        title: "P1 (= 100%)",
        name: "p1",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//9
        title: "P2 (> 35%)",
        name: "p2",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//10
        title: "E1 (70% - 80%)",
        name: "e1",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//11
        title: "E5 (70% - 80%)",
        name: "e5",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//12
        title: "E6 (<= 5%)",
        name: "e6",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//13
        title: "E7 (10% - 20%)",
        name: "e7",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//14
        title: "E9 (>= 10%)",
        name: "e9",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//15
        title: "A1 (<= 5%)",
        name: "a1",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//16
        title: "A2 (< 5%)",
        name: "a2",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//17
        title: "R7 (= harga pasar)",
        name: "r7_1",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//18
        title: "R9 (<= 5%)",
        name: "r9",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//19
        title: "L1 (15% - 20%)",
        name: "l1",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//20
        title: "L2 (15% - 20%)",
        name: "l2",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//21
        title: "S10 (> 12%)",
        name: "s10",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//22
        title: "S11 (> 10% + Laju Inflasi)",
        name: "s11",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
        isChart: true,
      },
      {//23
        title: "Harga Pasar",
        name: "harga_pasar",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
      },
      {//24
        title: "Laju Inflasi",
        name: "laju_inflasi",
        tipe: "numeric",
        sort: true,
        hide: false,
        disable: false,
        filter: true,
      },
      {//25
        title: "Tgl. Buat",
        name: "created_at",
        tipe: "datetime",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      },
      {//26
        title: "Tgl. Ubah",
        name: "updated_at",
        tipe: "datetime",
        sort: true,
        hide: false,
        disable: false,
        isChart: false,
        filter: true,
      }
    ],
    dataStat: '',
    dataStatS: '',
    grafikStat: '',
    grafikPearlsStat: '',
    pearlsStat: '',
    periodeStat: '',
    updateData: [], //update data
    updateStat: '',
    rules: [], //laravel rules
    options: [], //laravel options
  }),

  getters: {
    getData: state => state.data,
    getDataS: state => state.dataS,
    getHistory: state => state.history,
    getGrafik: state => state.grafik,
    getGrafikPearls: state => state.grafikPearls,
    getPearls: state => state.pearls,
    getPeriode: state => state.periode,
    getColumnData: state => state.columnData,
    getColumnDataPearls: state => state.columnDataPearls,
    getDataStat: state => state.dataStat,
    getDataStatS: state => state.dataStatS,
    getPearlsStat: state => state.pearlsStat,
    getGrafikStat: state => state.grafikStat,
    getGrafikPearlsStat: state => state.grafikPearlsStat,
    getPeriodeStat: state => state.periodeStat,
    getIdCU: state => state.idCU,
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
        const response = await LaporanCuAPI.index(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexTotal() {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuAPI.indexTotal();
        this.data = response.data.model;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.dataStat = 'fail';
      }
    },

    //gerakan
    async indexGerakan(p) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuAPI.indexGerakan(p);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load by cu
    async indexCu([p, id]) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuAPI.indexCu(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    // load cu draft
    async indexCuDraft(id) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuDraftAPI.index(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexTpDraft(id) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanTpDraftAPI.index(id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },


    // load by tp
    async indexTpPeriode([p, id, periode]) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanTpAPI.indexPeriode(p, id, periode);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    async indexTp([p, id]) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanTpAPI.indexTp(p, id);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },


    // load by periode
    async indexPeriode([p, periode]) {
      this.dataStatS = 'loading';

      try {
        const response = await LaporanCuAPI.indexPeriode(p, periode);
        this.dataS = response.data.model;
        this.dataStatS = 'success';
      } catch (error) {
        this.dataS = error.response;
        this.dataStatS = 'fail';
      }
    },

    //load collection with params
    async indexPearls(p) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexPearls(p);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // load by cu
    async indexPearlsCu([p, id]) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexPearlsCu(p, id);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // load by tp
    async indexPearlsTp([p, id]) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanTpAPI.indexPearlsTp(p, id);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },
    async indexPearlsTpPeriode([p, id, periode]) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanTpAPI.indexPearlsPeriode(p, id, periode);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // load by periode
    async indexPearlsPeriode([p, periode]) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexPearlsPeriode(p, periode);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    // load collection of periode
    async fetchPeriode() {
      this.periodeStat = 'loading';

      try {
        const response = await LaporanCuAPI.getPeriode();
        this.periode = response.data.model;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },

    // load collection of periode
    async fetchPeriodeCu(id) {
      this.periodeStat = 'loading';

      try {
        const response = await LaporanCuAPI.getPeriodeCu(id);
        this.periode = response.data.model;
        this.periodeStat = 'success';
      } catch (error) {
        this.periode = error.response;
        this.periodeStat = 'fail';
      }
    },


    // load by periode
    async grafikGerakan(p) {
      this.grafikStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexGerakan(p);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },

    // load by periode
    async grafikPeriode([p, periode]) {
      this.grafikStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexPeriode(p, periode);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },

    // load by cu
    async grafikCu([p, id]) {
      this.grafikStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexCu(p, id);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },

    async grafikTpPeriode([p, id, periode]) {
      this.grafikStat = 'loading';

      try {
        const response = await LaporanTpAPI.indexPeriode(p, id, periode);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },

    // load by tp
    async grafikTp([p, id]) {
      this.grafikStat = 'loading';

      try {
        const response = await LaporanTpAPI.indexTp(p, id);
        this.grafik = response.data.model;
        this.grafikStat = 'success';
      } catch (error) {
        this.grafik = error.response;
        this.grafikStat = 'fail';
      }
    },

    // load by periode
    async grafikPearlsPeriode([p, periode]) {
      this.grafikPearlsStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexPearlsPeriode(p, periode);
        this.grafikPearls = response.data.model;
        this.grafikPearlsStat = 'success';
      } catch (error) {
        this.grafikPearls = error.response;
        this.grafikPearlsStat = 'fail';
      }
    },

    // load by cu
    async grafikPearlsCu([p, id]) {
      this.grafikPearlsStat = 'loading';

      try {
        const response = await LaporanCuAPI.indexPearlsCu(p, id);
        this.grafikPearls = response.data.model;
        this.grafikPearlsStat = 'success';
      } catch (error) {
        this.grafikPearls = error.response;
        this.grafikPearlsStat = 'fail';
      }
    },

    async grafikPearlsTpPeriode([p, id, periode]) {
      this.grafikPearlsStat = 'loading';

      try {
        const response = await LaporanTpAPI.indexPearlsPeriode(p, id, periode);
        this.grafikPearls = response.data.model;
        this.grafikPearlsStat = 'success';
      } catch (error) {
        this.grafikPearls = error.response;
        this.grafikPearlsStat = 'fail';
      }
    },

    // load by tp
    async grafikPearlsTp([p, id]) {
      this.grafikPearlsStat = 'loading';

      try {
        const response = await LaporanTpAPI.indexPearlsTp(p, id);
        this.grafikPearls = response.data.model;
        this.grafikPearlsStat = 'success';
      } catch (error) {
        this.grafikPearls = error.response;
        this.grafikPearlsStat = 'fail';
      }
    },

    async create() {
      this.dataStat = 'loading';

      try {
        const response = await LaporanCuAPI.create();
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

    // detail
    async detail(id) {
      this.dataStat = 'loading';

      try {
        const response = await LaporanCuAPI.detail(id);
        this.data = response.data.model;
        this.history = response.data.history;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.history = '';
        this.dataStat = 'fail';
      }
    },
    async detailPearls(id) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanCuAPI.detailPearls(id);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },
    async detailTp(id) {
      this.dataStat = 'loading';

      try {
        const response = await LaporanTpAPI.detail(id);
        this.data = response.data.model;
        this.history = response.data.history;
        this.dataStat = 'success';
      } catch (error) {
        this.data = error.response;
        this.history = '';
        this.dataStat = 'fail';
      }
    },
    async detailPearlsTp(id) {
      this.pearlsStat = 'loading';

      try {
        const response = await LaporanTpAPI.detailPearls(id);
        this.pearls = response.data.model;
        this.pearlsStat = 'success';
      } catch (error) {
        this.pearls = error.response;
        this.pearlsStat = 'fail';
      }
    },

    //store data
    async store(form) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuAPI.store(form);
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
    async storeTp(form) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpAPI.store(form);
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
        const response = await LaporanCuDraftAPI.store(id);
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
    async storeDraftAll() {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuDraftAPI.storeAll();
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
    async storeTpDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpDraftAPI.store(id);
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
    async storeTpDraftAll() {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpDraftAPI.storeAll();
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
        const response = await LaporanCuAPI.edit(id);
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
    //edit tp
    async editTp(id) {
      this.dataStat = 'loading';

      try {
        const response = await LaporanTpAPI.edit(id);
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
        const response = await LaporanCuDraftAPI.edit(id);
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
    async editTpDraft(id) {
      this.dataStat = 'loading';

      try {
        const response = await LaporanTpDraftAPI.edit(id);
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
        const response = await LaporanCuAPI.update(id, form);
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
    async updateTp([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpAPI.update(id, form);
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
        const response = await LaporanCuDraftAPI.update(id, form);
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
    async updateTpDraft([id, form]) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpDraftAPI.update(id, form);
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

    // destroy data
    async destroy(id) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuAPI.destroy(id);
        if (response.data.deleted) {
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
    async destroyTp(id) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanTpAPI.destroy(id);
        if (response.data.deleted) {
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
    async destroyDraft(id) {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuDraftAPI.destroy(id);
        if (response.data.deleted) {
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
    async destroyDraftAll() {
      this.updateStat = 'loading';

      try {
        const response = await LaporanCuDraftAPI.destroyAll();
        if (response.data.deleted) {
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

    // reset
    resetUpdateStat() {
      this.updateStat = '';
    },
    resetData() {
      this.data = '';
      this.dataStat = '';
    },
    resetDataS() {
      this.dataS = '';
      this.dataStatS = '';
    },
    resetHistory() {
      this.history = '';
    }
  },
});
