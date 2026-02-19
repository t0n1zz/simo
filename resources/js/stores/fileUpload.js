import { defineStore } from 'pinia';
import FILEUPLOAD from '../api/fileUpload.js';

export const useFileUploadStore = defineStore('fileUpload', {
    state: () => ({
        dataS: [],
        dataStatS: '',
        update: [],
        updateStat: '',
    }),

    getters: {
        getDataS: (state) => state.dataS,
        getDataStatS: (state) => state.dataStatS,
        getUpdate: (state) => state.update,
        getUpdateStat: (state) => state.updateStat,
    },

    actions: {
        async index(id_cu, id_user) {
            this.dataStatS = 'loading';

            try {
                const response = await FILEUPLOAD.index(id_cu, id_user);
                this.dataS = response.data.model;
                this.dataStatS = 'success';
            } catch (error) {
                this.dataS = error.response;
                this.dataStatS = 'fail';
            }
        },

        async destroy(id) {
            this.updateStat = 'loading';

            try {
                const response = await FILEUPLOAD.destroy(id);
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

        setDataS(data) {
            this.dataS = data;
        },
    },
});
