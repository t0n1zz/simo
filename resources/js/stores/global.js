import { defineStore } from 'pinia';

export const useGlobalStore = defineStore('global', {
    state: () => ({
        data: '',
        idCu: '',
        idTp: '',
        message: '',
        messageType: '',
        isLoading: '',
        dataExcel: '',
    }),

    getters: {
        // Getters in Pinia are simpler - they automatically receive state
        getData: (state) => state.data,
        getIdCu: (state) => state.idCu,
        getIdTp: (state) => state.idTp,
        getMessage: (state) => state.message,
        getMessageType: (state) => state.messageType,
        getIsLoading: (state) => state.isLoading,
        getDataExcel: (state) => state.dataExcel,
    },

    actions: {
        // Actions can directly mutate state - no mutations needed
        setDataExcel(data) {
            this.dataExcel = data;
        },

        changeData(data) {
            this.data = data;
        },

        changeIdCu(id) {
            this.idCu = id;
        },

        changeIdTp(id) {
            this.idTp = id;
        },

        resetIdCu() {
            this.idCu = '';
        },

        resetIdTp() {
            this.idTp = '';
        },

        createMessage(message, type) {
            this.message = message;
            this.messageType = type;
        },

        resetMessage() {
            this.message = '';
            this.messageType = '';
        },

        setLoading(type) {
            this.isLoading = type;
        },
    },
});
