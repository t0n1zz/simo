import { defineStore } from 'pinia';
import KEGIATANBKCUAPI from '../api/kegiatanBKCU.js';

export const useKegiatanBKCUStore = defineStore('kegiatanBKCU', {
    state: () => ({
        // Original Vuex State
        data: {},
        data2: {}, //single data
        data3: {}, //single data
        data4: {}, //single data
        dataS: [], //collection
        dataS2: [], //collection
        dataS3: [], //collection
        dataS4: [], //collection
        dataS5: [], //collection
        dataS6: [], //collection
        dataS7: [], //collection
        dataS8: [], //collection
        dataS9: [], //collection
        dataS10: [], //collection
        dataS11: [], //collection
        dataSertifikat: {},
        dataNilai: [],
        nilai: [],
        dataNoSertifikat: {},
        dataListMateri: [], //collection
        dataPanitia: [], //collection
        dataDibuka: [], //collection
        dataDitutup: [], //collection
        dataBerjalan: [], //collection
        dataTerlaksana: [], //collection
        dataMenunggu: [], //collection
        dataBatal: [], //collection
        periode: [],
        count: {},
        count2: {},
        count3: {},
        count4: {},
        dataNoSertifikatStat: "",
        dataDibukaStat: "",
        dataDitutupStat: "",
        dataBerjalanStat: "",
        dataTerlaksanaStat: "",
        dataMenungguStat: "",
        dataBatalStat: "",
        dataListMateriStat: "",
        dataPanitiaStat: "",
        nilaiStat: '',
        dataStat: '',
        dataStat2: '',
        dataStat3: '',
        dataStat4: '',
        periodeStat: '',
        dataStatS: '',
        dataStatS2: '',
        dataStatS3: '',
        dataStatS4: '',
        dataStatS5: '',
        dataStatS6: '',
        dataStatS7: '',
        dataStatS8: '',
        dataStatS9: '',
        dataStatS10: '',
        dataStatS11: '',
        dataJalanStat: '',
        dataDiikutiStat: '',
        countStat: '',
        countStat2: '',
        countStat3: '',
        countStat4: '',
        update: [], //update data
        updateStat: '',
        updateNilaiStat: '',
        update2: [], //update data
        updateStat2: '',
        rules: [], //laravel rules
        options: [], //laravel options

        // Dashboard Widget State (Renamed to avoid conflict)
        widgetCountJalan: 0,
        widgetCountJalanStat: '',
        widgetCountDiikuti: 0,
        widgetCountDiikutiStat: '',

        // Header specific state from previous Pinia file (merging just in case)
        dataJalan: [],
        // dataJalanStat is already in Vuex state
    }),

    getters: {
        getData: state => state.data,
        getData2: state => state.data2,
        getData3: state => state.data3,
        getData4: state => state.data4,
        getDataS: state => state.dataS,
        getDataS2: state => state.dataS2,
        getDataS3: state => state.dataS3,
        getDataS4: state => state.dataS4,
        getDataS5: state => state.dataS5,
        getDataS6: state => state.dataS6,
        getDataS7: state => state.dataS7,
        getDataS8: state => state.dataS8,
        getDataS9: state => state.dataS9,
        getDataS10: state => state.dataS10,
        getDataS11: state => state.dataS11,
        getDataNoSertifikat: state => state.dataNoSertifikat,
        getDataDibuka: (state) => state.dataDibuka,
        getDataDitutup: (state) => state.dataDitutup,
        getDataBerjalan: (state) => state.dataBerjalan,
        getDataTerlaksana: (state) => state.dataTerlaksana,
        getDataMenunggu: (state) => state.dataMenunggu,
        getDataBatal: (state) => state.dataBatal,
        getDataSertifikat: (state) => state.dataSertifikat,
        getDataNilai: (state) => state.dataNilai,
        getDataListMateri: (state) => state.dataListMateri,
        getDataPanitia: (state) => state.dataPanitia,
        getNilai: state => state.nilai,
        getPeriode: state => state.periode,
        getCount: state => state.count,
        getCount2: state => state.count2,
        getCount3: state => state.count3,
        getCount4: state => state.count4,
        getDataNoSertifikatStat: state => state.dataNoSertifikatStat,
        getDataNilaiStat: state => state.dataNilaiStat,
        getDataListMateriStat: state => state.dataListMateriStat,
        getDataPanitiaStat: state => state.dataPanitiaStat,
        getNilaiStat: state => state.nilaiStat,
        getDataStat: state => state.dataStat,
        getDataStat2: state => state.dataStat2,
        getDataStat3: state => state.dataStat3,
        getDataStat4: state => state.dataStat4,
        getPeriodeStat: state => state.periodeStat,
        getDataStatS: state => state.dataStatS,
        getDataStatS2: state => state.dataStatS2,
        getDataStatS3: state => state.dataStatS3,
        getDataStatS4: state => state.dataStatS4,
        getDataStatS5: state => state.dataStatS5,
        getDataStatS6: state => state.dataStatS6,
        getDataStatS7: state => state.dataStatS7,
        getDataStatS8: state => state.dataStatS8,
        getDataStatS9: state => state.dataStatS9,
        getDataStatS10: state => state.dataStatS10,
        getDataStatS11: state => state.dataStatS11,
        getDataDibukaStat: (state) => state.dataDibukaStat,
        getDataDitutupStat: (state) => state.dataDitutupStat,
        getDataBerjalanStat: (state) => state.dataBerjalanStat,
        getDataTerlaksanaStat: (state) => state.dataTerlaksanaStat,
        getDataMenungguStat: (state) => state.dataMenungguStat,
        getDataBatalStat: (state) => state.dataBatalStat,
        getDataJalanStat: state => state.dataJalanStat,
        getDataDiikutiStat: state => state.dataDiikutiStat,
        getCountStat: state => state.countStat,
        getCountStat2: state => state.countStat2,
        getCountStat3: state => state.countStat3,
        getCountStat4: state => state.countStat4,
        getUpdate: state => state.update,
        getUpdateNilai: state => state.updateNilai,
        getUpdateStat: state => state.updateStat,
        getUpdateNilaiStat: state => state.updateNilaiStat,
        getUpdate2: state => state.update2,
        getUpdateStat2: state => state.updateStat2,
        getRules: state => state.rules,
        getOptions: state => state.options,

        // Header getters
        getDataJalan: (state) => state.dataJalan,

        // Widget Getters
        getWidgetCountJalan: state => state.widgetCountJalan,
        getWidgetCountJalanStat: state => state.widgetCountJalanStat,
        getWidgetCountDiikuti: state => state.widgetCountDiikuti,
        getWidgetCountDiikutiStat: state => state.widgetCountDiikutiStat,
    },

    actions: {
        //load collection with params
        async index([p, tipe]) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.index(p, tipe);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexDibuka([p, tipe, periode]) {
            this.dataDibukaStat = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexPisah(p, tipe, periode, 2);
                this.dataDibuka = response.data.model;
                this.dataDibukaStat = "success";
            } catch (error) {
                this.dataDibuka = error.response;
                this.dataDibukaStat = "fail";
            }
        },

        async indexDitutup([p, tipe, periode]) {
            this.dataDitutupStat = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexPisah(p, tipe, periode, 3);
                this.dataDitutup = response.data.model;
                this.dataDitutupStat = "success";
            } catch (error) {
                this.dataDitutup = error.response;
                this.dataDitutupStat = "fail";
            }
        },

        async indexBerjalan([p, tipe, periode]) {
            this.dataBerjalanStat = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexPisah(p, tipe, periode, 4);
                this.dataBerjalan = response.data.model;
                this.dataBerjalanStat = "success";
            } catch (error) {
                this.dataBerjalan = error.response;
                this.dataBerjalanStat = "fail";
            }
        },

        async indexTerlaksana([p, tipe, periode]) {
            this.dataTerlaksanaStat = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexPisah(p, tipe, periode, 5);
                this.dataTerlaksana = response.data.model;
                this.dataTerlaksanaStat = "success";
            } catch (error) {
                this.dataTerlaksana = error.response;
                this.dataTerlaksanaStat = "fail";
            }
        },

        async indexMenunggu([p, tipe, periode]) {
            this.dataMenungguStat = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexPisah(p, tipe, periode, 1);
                this.dataMenunggu = response.data.model;
                this.dataMenungguStat = "success";
            } catch (error) {
                this.dataMenunggu = error.response;
                this.dataMenungguStat = "fail";
            }
        },

        async indexBatal([p, tipe, periode]) {
            this.dataBatalStat = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexPisah(p, tipe, periode, 6);
                this.dataBatal = response.data.model;
                this.dataBatalStat = "success";
            } catch (error) {
                this.dataBatal = error.response;
                this.dataBatalStat = "fail";
            }
        },

        async indexBuka(p) {
            this.dataStatS = "loading";
            try {
                const response = await KEGIATANBKCUAPI.indexBuka(p);
                this.dataS = response.data.model;
                this.dataStatS = "success";
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = "fail";
            }
        },

        async indexJalan(p) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexJalan(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexDiikuti(p) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexDiikuti(p);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexJalanHeader(p) {
            this.dataJalanStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexJalan(p);
                this.dataJalan = response.data.model;
                this.dataJalanStat = 'success';
            } catch (error) {
                this.dataJalan = error.response;
                this.dataJalanStat = 'fail';
            }
        },

        async indexDiikutiHeader(p) {
            this.dataDiikutiStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexDiikuti(p);
                this.dataDiikuti = response.data.model;
                this.dataDiikutiStat = 'success';
            } catch (error) {
                this.dataDiikuti = error.response;
                this.dataDiikutiStat = 'fail';
            }
        },

        async indexPeriode([p, tipe, periode]) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPeriode(p, tipe, periode);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexSemuaPeserta([p, tipe]) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexSemuaPeserta(p, tipe);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexSemuaPesertaMitra([p, tipe]) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexSemuaPesertaMitra(p, tipe);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexSemuaPesertaCu([p, tipe, cu]) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexSemuaPesertaCu(p, tipe, cu);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexPeserta([p, id]) {
            this.dataStatS = 'loading';
            try {
                const response = await KEGIATANBKCUAPI.indexPeserta(p, id);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexPesertaHadir([p, id]) {
            this.dataStatS2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPesertaHadir(p, id);
                this.dataS2 = response.data.model;
                this.dataStatS2 = 'success';
            } catch (error) {
                this.dataS2 = error.response;
                this.dataStatS2 = 'fail';
            }
        },

        async indexPesertaCu([p, id, cu]) {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPesertaCu(p, id, cu);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async indexPesertaCountCu(id) {
            this.dataStatS6 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPesertaCountCu(id);
                this.dataS6 = response.data.model;
                this.dataStatS6 = 'success';
            } catch (error) {
                this.dataS6 = error.response;
                this.dataStatS6 = 'fail';
            }
        },

        async indexPesertaHadirCountCu(id) {
            this.dataStatS7 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPesertaHadirCountCu(id);
                this.dataS7 = response.data.model;
                this.dataStatS7 = 'success';
            } catch (error) {
                this.dataS7 = error.response;
                this.dataStatS7 = 'fail';
            }
        },

        async indexMateri([p, id]) {
            this.dataStatS3 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexMateri(p, id);
                this.dataS3 = response.data.model;
                this.dataStatS3 = 'success';
            } catch (error) {
                this.dataS3 = error.response;
                this.dataStatS3 = 'fail';
            }
        },

        async getNomorSertifikat(p) {
            this.dataNoSertifikatStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.getNomorSertifikat(p);
                this.dataNoSertifikat = response.data.model;
                this.dataNoSertifikatStat = 'success';
            } catch (error) {
                this.dataNoSertifikat = error.response;
                this.dataNoSertifikatStat = 'fail';
            }
        },

        async indexPanitia(id) {
            this.dataPanitiaStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPanitia(id);
                this.dataPanitia = response.data.model;
                this.dataPanitiaStat = 'success';
            } catch (error) {
                this.dataPanitia = error.response;
                this.dataPanitiaStat = 'fail';
            }
        },

        async indexListMateri(id) {
            this.dataListMateriStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexListMateri(id);
                this.dataListMateri = response.data.model;
                this.dataListMateriStat = 'success';
            } catch (error) {
                this.dataListMateri = error.response;
                this.dataListMateriStat = 'fail';
            }
        },

        async indexNilaiListMateri(id) {
            this.dataNilaiStat = 'loading';
            try {
                const response = await KEGIATANBKCUAPI.indexNilaiListMateri(id);
                this.dataNilai = response.data.model;
                this.dataNilaiStat = 'success';
            } catch (error) {
                this.dataNilai = error.response;
                this.dataNilaiStat = 'fail';
            }
        },

        async indexKeputusan([p, id]) {
            this.dataStatS4 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexKeputusan(p, id);
                this.dataS4 = response.data.model;
                this.dataStatS4 = 'success';
            } catch (error) {
                this.dataS4 = error.response;
                this.dataStatS4 = 'fail';
            }
        },

        async indexKeputusanCount(id) {
            this.dataStatS8 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexKeputusanCount(id);
                this.dataS8 = response.data.model;
                this.dataStatS8 = 'success';
            } catch (error) {
                this.dataS8 = error.response;
                this.dataStatS8 = 'fail';
            }
        },

        async indexKeputusanKomentar([p, id]) {
            this.dataStatS5 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexKeputusanKomentar(p, id);
                this.dataS5 = response.data.model;
                this.dataStatS5 = 'success';
            } catch (error) {
                this.dataS5 = error.response;
                this.dataStatS5 = 'fail';
            }
        },

        async indexPertanyaan([p, id]) {
            this.dataStatS9 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPertanyaan(p, id);
                this.dataS9 = response.data.model;
                this.dataStatS9 = 'success';
            } catch (error) {
                this.dataS9 = error.response;
                this.dataStatS9 = 'fail';
            }
        },

        async indexPertanyaanKomentar([p, id]) {
            this.dataStatS5 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexPertanyaanKomentar(p, id);
                this.dataS5 = response.data.model;
                this.dataStatS5 = 'success';
            } catch (error) {
                this.dataS5 = error.response;
                this.dataStatS5 = 'fail';
            }
        },

        async indexTugas([p, id]) {
            this.dataStatS10 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexTugas(p, id);
                this.dataS10 = response.data.model;
                this.dataStatS10 = 'success';
            } catch (error) {
                this.dataS10 = error.response;
                this.dataStatS10 = 'fail';
            }
        },

        async indexTugasJawaban([p, id]) {
            this.dataStatS11 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexTugasJawaban(p, id);
                this.dataS11 = response.data.model;
                this.dataStatS11 = 'success';
            } catch (error) {
                this.dataS11 = error.response;
                this.dataStatS11 = 'fail';
            }
        },

        async indexKegiatan() {
            this.dataStatS = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.indexKegiatan();
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async checkPeserta([kegiatan_id, aktivis_id]) {
            this.dataStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.checkPeserta(kegiatan_id, aktivis_id);
                this.data2 = response.data.model;
                this.dataStat2 = 'success';
            } catch (error) {
                this.data2 = error.response;
                this.dataStat2 = 'fail';
            }
        },

        async checkPanitia([kegiatan_id, aktivis_id]) {
            this.dataStat3 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.checkPanitia(kegiatan_id, aktivis_id);
                this.data3 = response.data.model;
                this.dataStat3 = 'success';
            } catch (error) {
                this.data3 = error.response;
                this.dataStat3 = 'fail';
            }
        },

        async fetchPeriode(tipe) {
            this.periodeStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.getPeriode(tipe);
                this.periode = response.data.model;
                this.periodeStat = 'success';
            } catch (error) {
                this.periode = error.response;
                this.periodeStat = 'fail';
            }
        },

        // create page
        async create() {
            this.dataStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.create();
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
        async store([tipe, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.store(tipe, form);
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

        async penerimaSertifikat(formData) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.penerimaSertifikat(formData);
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

        async storePeserta([tipe, id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storePeserta(tipe, id, form);
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

        async storeMateri([tipe, id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storeMateri(tipe, id, form);
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

        async storeListMateri([tipe, id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storeListMateri(tipe, id, form);
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

        async saveNilai([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.saveNilai(id, form);
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

        async storeKeputusan([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storeKeputusan(id, form);
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

        async storeKeputusanKomentar([id, form]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storeKeputusanKomentar(id, form);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async storePertanyaan([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storePertanyaan(id, form);
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

        async storePertanyaanKomentar([id, form]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storePertanyaanKomentar(id, form);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async storeTugas([tipe, id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storeTugas(tipe, id, form);
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

        async storeTugasJawaban([tipe, form]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.storeTugasJawaban(tipe, form);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        // edit page
        async edit(id) {
            this.dataStat = 'loading';
            try {
                const response = await KEGIATANBKCUAPI.edit(id);
                this.data = response.data.form;
                this.dataSertifikat = response.data.form1;
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

        async editTugasJawaban(id) {
            this.dataStat4 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.editTugasJawaban(id);
                this.data4 = response.data.form;
                this.rules = response.data.rules;
                this.options = response.data.options;
                this.dataStat4 = 'success';
            } catch (error) {
                this.data4 = error.response;
                this.rules = [];
                this.options = [];
                this.dataStat4 = 'fail';
            }
        },

        // update data
        async update([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.update(id, form);
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

        async updateStatus([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateStatus(id, form);
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

        async updatePeserta([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updatePeserta(id, form);
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

        async updateMateri([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateMateri(id, form);
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

        async updateListMateri([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateListMateri(id, form);
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

        async updateKeputusan([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateKeputusan(id, form);
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

        async updateKeputusanKomentar([id, form]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateKeputusanKomentar(id, form);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async updatePertanyaan([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updatePertanyaan(id, form);
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

        async updatePertanyaanKomentar([id, form]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updatePertanyaanKomentar(id, form);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async updateTugas([id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateTugas(id, form);
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

        async updateTugasJawaban([id, form]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updateTugasJawaban(id, form);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async updatePesertaHadir([kegiatan_id, aktivis_id]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updatePesertaHadir(kegiatan_id, aktivis_id);
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

        async updatePanitiaHadir([kegiatan_id, aktivis_id]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.updatePanitiaHadir(kegiatan_id, aktivis_id);
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

        async editNilai([id, aktivis_id]) {
            this.dataStat4 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.editNilai(id, aktivis_id);
                this.data4 = response.data.model;
                this.dataStat4 = 'success';
            } catch (error) {
                this.data4 = error.response;
                this.dataStat4 = 'fail';
            }
        },

        async jawabanPertanyaan([id, tipe]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.jawabanPertanyaan(id, tipe);
                if (response.data.saved) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        // destroy data
        async destroy(id) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroy(id);
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

        async destroyPeserta(id) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyPeserta(id);
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

        async destroyMateri([tipe, id]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyMateri(tipe, id);
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

        async destroyListMateri([tipe, id]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyListMateri(tipe, id);
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

        async destroyKeputusan(id) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyKeputusan(id);
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

        async destroyKeputusanKomentar(id) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyKeputusanKomentar(id);
                if (response.data.deleted) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async destroyPertanyaan(id) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyPertanyaan(id);
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

        async destroyPertanyaanKomentar(id) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyPertanyaanKomentar(id);
                if (response.data.deleted) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async destroyTugas([tipe, id]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyTugas(tipe, id);
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

        async destroyTugasJawaban([tipe, id]) {
            this.updateStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.destroyTugasJawaban(tipe, id);
                if (response.data.deleted) {
                    this.update2 = response.data;
                    this.updateStat2 = 'success';
                } else {
                    this.updateStat2 = 'fail';
                }
            } catch (error) {
                this.update2 = error.response;
                this.updateStat2 = 'fail';
            }
        },

        async batalPeserta([tipe, id, form]) {
            this.updateStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.batalPeserta(tipe, id, form);
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

        // Counter Actions (Original Vuex names, but might update State called 'count')
        async countJalan() {
            this.countStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.countJalan();
                this.count = response.data.model;
                this.countStat = 'success';
            } catch (error) {
                this.count = error.response;
                this.countStat = 'fail';
            }
        },

        // New Widget Actions (Mapped to widget states)
        async fetchWidgetCountJalan() {
            this.widgetCountJalanStat = 'loading';
            try {
                const response = await KEGIATANBKCUAPI.countJalan();
                this.widgetCountJalan = response.data; // Assuming widget API returns number/string directly, unlike countJalan above which gets model
                this.widgetCountJalanStat = 'success';
            } catch (error) {
                this.widgetCountJalan = 0;
                this.widgetCountJalanStat = 'fail';
            }
        },

        async fetchWidgetCountDiikuti() {
            this.widgetCountDiikutiStat = 'loading';
            try {
                const response = await KEGIATANBKCUAPI.countDiikuti();
                this.widgetCountDiikuti = response.data; // Assuming widget API returns number/string directly
                this.widgetCountDiikutiStat = 'success';
            } catch (error) {
                this.widgetCountDiikuti = 0;
                this.widgetCountDiikutiStat = 'fail';
            }
        },

        async countDiikuti() {
            this.countStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.countDiikuti();
                this.count2 = response.data.model;
                this.countStat2 = 'success';
            } catch (error) {
                this.count2 = error.response;
                this.countStat2 = 'fail';
            }
        },

        async countPeserta(id) {
            this.countStat = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.countPeserta(id);
                this.count = response.data.model;
                this.countStat = 'success';
            } catch (error) {
                this.count = error.response;
                this.countStat = 'fail';
            }
        },

        async countPesertaHadir(id) {
            this.countStat2 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.countPesertaHadir(id);
                this.count2 = response.data.model;
                this.countStat2 = 'success';
            } catch (error) {
                this.count2 = error.response;
                this.countStat2 = 'fail';
            }
        },

        async countKeputusan([id, cu, user]) {
            this.countStat3 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.countKeputusan(id, cu, user);
                this.count3 = response.data.model;
                this.countStat3 = 'success';
            } catch (error) {
                this.count3 = error.response;
                this.countStat3 = 'fail';
            }
        },

        async countPertanyaan([id, cu, user]) {
            this.countStat4 = 'loading';

            try {
                const response = await KEGIATANBKCUAPI.countPertanyaan(id, cu, user);
                this.count4 = response.data.model;
                this.countStat4 = 'success';
            } catch (error) {
                this.count4 = error.response;
                this.countStat4 = 'fail';
            }
        },

        // reset
        resetDataStat() {
            this.dataStat = '';
        },
        resetDataS() {
            this.dataS = [];
            this.dataStatS = 'success';
        },
        resetUpdateStat() {
            this.updateStat = '';
        },
    },
});
