---
description: Migrate a Vuex store module to Pinia store
---

# Vuex to Pinia Store Migration

## What This Does
Converts a Vuex store module from `/resources/js/store/modules/*.js` to a Pinia store in `/resources/js/stores/*.js`.

## The Transformation Rules

### File Location
- **FROM:** `/Users/tony/Code/simo/resources/js/store/modules/{name}.js`
- **TO:** `/Users/tony/Code/simo/resources/js/stores/{name}.js`

### Store Structure Transformation

#### Vuex Structure (OLD):
```javascript
export const storeName = {
    namespaced: true,
    state: {
        data: [],
        dataStat: '',
        update: {},
        updateStat: ''
    },
    getters: {
        data: (state) => state.data,
        dataStat: (state) => state.dataStat,
        // ... more getters
    },
    mutations: {
        SET_DATA(state, payload) {
            state.data = payload;
        },
        SET_DATA_STAT(state, payload) {
            state.dataStat = payload;
        },
        // ... more mutations
    },
    actions: {
        async index({ commit }, params) {
            commit('SET_DATA_STAT', 'loading');
            try {
                const response = await axios.get('/api/storeName', { params });
                commit('SET_DATA', response.data.model);
                commit('SET_DATA_STAT', 'success');
            } catch (error) {
                commit('SET_DATA', error.response);
                commit('SET_DATA_STAT', 'fail');
            }
        },
        // ... more actions
    }
}
```

#### Pinia Structure (NEW):
```javascript
import { defineStore } from 'pinia';

export const useStoreNameStore = defineStore('storeName', {
    state: () => ({
        data: [],
        dataStat: '',
        dataS: [],       // Add 'S' suffix versions for compatibility
        dataStatS: '',
        update: {},
        updateStat: ''
    }),
    
    getters: {
        getData: (state) => state.data,
        getDataStat: (state) => state.dataStat,
        // ... more getters with 'get' prefix
    },
    
    actions: {
        async index(params) {
            this.dataStat = 'loading';
            this.dataStatS = 'loading';
            try {
                const response = await axios.get('/api/storeName', { params });
                this.data = response.data.model;
                this.dataS = response.data.model;
                this.dataStat = 'success';
                this.dataStatS = 'success';
            } catch (error) {
                this.data = error.response;
                this.dataS = error.response;
                this.dataStat = 'fail';
                this.dataStatS = 'fail';
            }
        },
        
        resetUpdateStat() {
            this.updateStat = '';
        },
        
        // ... more actions
    }
});
```

## Key Differences

| Vuex | Pinia |
|------|-------|
| `export const name = {...}` | `export const useNameStore = defineStore('name', {...})` |
| `state: {...}` | `state: () => ({...})` |
| `commit('MUTATION', payload)` | `this.property = payload` |
| `{ commit }, params` in actions | Just `params` in actions |
| Getters access via `state.prop` | Same, but use `get` prefix naming |

## Step-by-Step Process

1. **Create new file** in `/Users/tony/Code/simo/resources/js/stores/{name}.js`

2. **Copy the import and define structure:**
   ```javascript
   import { defineStore } from 'pinia';
   
   export const useNameStore = defineStore('name', {
       state: () => ({
           // Copy state properties here
       }),
       getters: {
           // Convert getters here
       },
       actions: {
           // Convert actions here
       }
   });
   ```

3. **Convert state:** Change from object to arrow function returning object

4. **Convert getters:** Keep the same logic, optionally add `get` prefix

5. **Convert mutations to direct assignments:** Remove mutations entirely, replace `commit('SET_X', value)` with `this.x = value` in actions

6. **Convert actions:**
   - Remove `{ commit, state, dispatch }` parameter destructuring
   - Replace `commit('MUTATION', value)` with `this.property = value`
   - Replace `dispatch('otherAction', params)` with `this.otherAction(params)`
   - Replace `state.property` with `this.property`

7. **Add compatibility properties:** Some views use `dataS` and `dataStatS` naming, so include both

## Reference: Already Migrated Stores

Look at these for examples:
- `/Users/tony/Code/simo/resources/js/stores/artikel.js`
- `/Users/tony/Code/simo/resources/js/stores/auth.js`
- `/Users/tony/Code/simo/resources/js/stores/cu.js`
- `/Users/tony/Code/simo/resources/js/stores/user.js`

## After Migration: Update Component Imports

Components using the store need to be updated:

### OLD (Vuex):
```javascript
import { mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters('storeName', {
            data: 'data',
            dataStat: 'dataStat'
        })
    },
    methods: {
        fetch() {
            this.$store.dispatch('storeName/index', params);
        }
    }
}
```

### NEW (Pinia):
```javascript
import { useStoreNameStore } from '../../stores/storeName';

export default {
    data() {
        return {
            storeNameStore: useStoreNameStore()
        }
    },
    computed: {
        data() {
            return this.storeNameStore.data;
        },
        dataStat() {
            return this.storeNameStore.dataStat;
        }
    },
    methods: {
        fetch() {
            this.storeNameStore.index(params);
        }
    }
}
```

## Stores Already Migrated (DO NOT migrate again)

These exist in `/Users/tony/Code/simo/resources/js/stores/`:
- aktivis.js, artikel.js, artikelKategori.js, artikelPenulis.js
- artikelSimo.js, auth.js, cu.js, districts.js
- dokumen.js, dokumenKategori.js, errorLog.js, fileUpload.js
- global.js, kegiatanBKCU.js, notification.js, pekerjaan.js
- pengumuman.js, provinces.js, regencies.js, role.js
- saran.js, tempat.js, tp.js, user.js, villages.js

## Stores That Still Need Migration

These are in `/Users/tony/Code/simo/resources/js/store/modules/` and need conversion:
- anggotaCu.js, asetTetap*.js, assesmentAccess.js, assesmentCuleg.js
- coa.js, enterpreneur.js, fasilitator.js, jalinan*.js
- jenisDiklat.js, keahlian.js, kegiatanRekom.js, kodeKegiatan.js
- kombas.js, kubn*.js, laporanCu.js, laporanCuDiskusi.js
- laporanGerakan.js, laporanTp.js, mentor.js, mitra*.js
- monitoring*.js, pemilihan.js, produkCu.js, pus.js
- sertifikatKegiatan.js, suku.js, surat*.js, umkm.js, voting.js
