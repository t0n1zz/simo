import { defineStore } from 'pinia';
import RoleAPI from '../api/role.js';

export const useRoleStore = defineStore('role', {
    state: () => ({
        roleData: [],
        roleDataLoad: '',
        roleS: [],
        roleLoadStatS: '',
        role: {},
        roleLoadStat: '',
        roleUpdate: '',
        roleUpdateStat: '',
        roleRules: [],
        roleOption: [],
    }),

    getters: {
        getRoleData: (state) => state.roleData,
        getRoleDataLoadStat: (state) => state.roleDataLoad,
        getRoleS: (state) => state.roleS,
        getRoleLoadStatS: (state) => state.roleLoadStatS,
        getRole: (state) => state.role,
        getRoleLoadStat: (state) => state.roleLoadStat,
        getRoleUpdateStat: (state) => state.roleUpdateStat,
        getRoleUpdate: (state) => state.roleUpdate,
        getRoleRules: (state) => state.roleRules,
        getRoleOption: (state) => state.roleOption,
    },

    actions: {
        async loadRoleS(p) {
            this.roleLoadStatS = 'loading';
            try {
                const response = await RoleAPI.getRoleS(p);
                this.roleS = response.data.model;
                this.roleLoadStatS = 'success';
            } catch (error) {
                this.roleS = error.response;
                this.roleLoadStatS = 'fail';
            }
        },

        async loadRoleAll() {
            this.roleLoadStatS = 'loading';
            try {
                const response = await RoleAPI.getRoleAll();
                this.roleS = response.data.model;
                this.roleLoadStatS = 'success';
            } catch (error) {
                this.roleS = [];
                this.roleLoadStatS = 'fail';
            }
        },

        async loadRoleTipe(tipe) {
            this.roleLoadStatS = 'loading';
            try {
                const response = await RoleAPI.getRoleTipe(tipe);
                this.roleS = response.data.model;
                this.roleLoadStatS = 'success';
            } catch (error) {
                this.roleS = [];
                this.roleLoadStatS = 'fail';
            }
        },

        async loadRolePermission(id) {
            this.roleLoadStat = 'loading';
            try {
                const response = await RoleAPI.getRolePermission(id);
                this.roleData = response.data.model;
                this.roleDataLoad = 'success';
            } catch (error) {
                this.roleData = error.response;
                this.roleDataLoad = 'fail';
            }
        },

        async loadRole(id) {
            this.roleLoadStat = 'loading';
            try {
                const response = await RoleAPI.getRole(id);
                this.role = response.data;
                this.roleLoadStat = 'success';
            } catch (error) {
                this.roleS = error.response;
                this.roleLoadStatS = 'fail';
            }
        },

        async createRole() {
            this.roleLoadStat = 'loading';
            try {
                const response = await RoleAPI.createRole();
                this.role = response.data.form;
                this.roleRules = response.data.rules;
                this.roleOption = response.data.option;
                this.roleLoadStat = 'success';
            } catch (error) {
                this.role = [];
                this.roleRules = [];
                this.roleOption = [];
                this.roleLoadStat = 'fail';
            }
        },

        async storeRole(form) {
            this.roleUpdateStat = 'loading';
            try {
                const response = await RoleAPI.storeRole(form);
                if (response.data.saved) {
                    this.roleUpdate = response.data;
                    this.roleUpdateStat = 'success';
                } else {
                    this.roleUpdateStat = 'fail';
                }
            } catch (error) {
                if (error.response?.status) {
                    this.roleUpdate = error.response.data;
                } else {
                    this.roleUpdate = 'Oops terjadi kesalahan :(';
                }
                this.roleUpdateStat = 'fail';
            }
        },

        async editRole(id) {
            this.roleLoadStat = 'loading';
            try {
                const response = await RoleAPI.editRole(id);
                this.role = response.data.form;
                this.roleRules = response.data.rules;
                this.roleOption = response.data.option;
                this.roleLoadStat = 'success';
            } catch (error) {
                this.role = [];
                this.roleRules = [];
                this.roleOption = [];
                this.roleLoadStat = 'fail';
            }
        },

        async updateRole(id, form) {
            this.roleUpdateStat = 'loading';
            try {
                const response = await RoleAPI.updateRole(id, form);
                if (response.data.saved) {
                    this.roleUpdate = response.data;
                    this.roleUpdateStat = 'success';
                } else {
                    this.roleUpdateStat = 'fail';
                }
            } catch (error) {
                if (error.response?.status) {
                    this.roleUpdate = error.response.data;
                } else {
                    this.roleUpdate = 'Oops terjadi kesalahan :(';
                }
                this.roleUpdateStat = 'fail';
            }
        },

        async deleteRole(id) {
            this.roleUpdateStat = 'loading';
            try {
                const response = await RoleAPI.deleteRole(id);
                this.roleUpdate = response.data;
                this.roleUpdateStat = 'success';
            } catch (error) {
                this.roleS = error.response;
                this.roleLoadStatS = 'fail';
            }
        },

        resetRoleUpdateStat() {
            this.roleUpdateStat = '';
        },
    },
});
