---
description: Update Vue component to use Pinia instead of Vuex mapGetters
---

# Migrate Component from Vuex to Pinia

## What This Does
Updates a Vue component that uses Vuex `mapGetters`, `mapActions`, or `$store.dispatch` to use Pinia stores directly.

## Step-by-Step Process

### Step 1: Identify What Stores Are Used

Look for these patterns in the component:
```javascript
import { mapGetters } from 'vuex';
// or
...mapGetters('storeName', {...})
// or
this.$store.dispatch('storeName/action', params)
```

### Step 2: Replace Imports

**REMOVE:**
```javascript
import { mapGetters } from 'vuex';
```

**ADD:**
```javascript
import { useAuthStore } from '../../stores/auth';
import { useArtikelStore } from '../../stores/artikel';
// Add one import for each store used
```

Note: Adjust the path (`../../stores/`) based on file location.

### Step 3: Initialize Stores in data()

Add the stores to the `data()` function:

```javascript
data() {
    return {
        authStore: useAuthStore(),
        artikelStore: useArtikelStore(),
        // ... other component data
    }
},
```

### Step 4: Replace mapGetters in computed

**BEFORE:**
```javascript
computed: {
    ...mapGetters('auth', {
        currentUser: 'currentUser'
    }),
    ...mapGetters('artikel', {
        itemData: 'dataS',
        itemDataStat: 'dataStatS'
    }),
}
```

**AFTER:**
```javascript
computed: {
    currentUser() {
        return this.authStore.currentUser;
    },
    itemData() {
        return this.artikelStore.dataS;
    },
    itemDataStat() {
        return this.artikelStore.dataStatS;
    },
}
```

### Step 5: Replace $store.dispatch in methods

**BEFORE:**
```javascript
methods: {
    fetch(params) {
        this.$store.dispatch('artikel/index', params);
    },
    destroy(id) {
        this.$store.dispatch('artikel/destroy', id);
    }
}
```

**AFTER:**
```javascript
methods: {
    fetch(params) {
        this.artikelStore.index(params);
    },
    destroy(id) {
        this.artikelStore.destroy(id);
    }
}
```

### Step 6: Replace $store.state Access

**BEFORE:**
```javascript
this.$store.state.artikel.data
```

**AFTER:**
```javascript
this.artikelStore.data
```

## Complete Example

### BEFORE (Vuex):
```javascript
<script>
import { mapGetters } from 'vuex';
import pageHeader from "../../components/pageHeader.vue";

export default {
    components: { pageHeader },
    data() {
        return {
            title: 'User',
            kelas: 'user',
        }
    },
    created() {
        this.$store.dispatch('user/index', this.query);
    },
    methods: {
        fetch(params) {
            this.$store.dispatch('user/index', params);
        }
    },
    computed: {
        ...mapGetters('auth', {
            currentUser: 'currentUser'
        }),
        ...mapGetters('user', {
            itemData: 'dataS',
            itemDataStat: 'dataStatS',
        }),
    },
}
</script>
```

### AFTER (Pinia):
```javascript
<script>
import { useAuthStore } from '../../stores/auth';
import { useUserStore } from '../../stores/user';
import pageHeader from "../../components/pageHeader.vue";

export default {
    components: { pageHeader },
    data() {
        return {
            authStore: useAuthStore(),
            userStore: useUserStore(),
            title: 'User',
            kelas: 'user',
        }
    },
    created() {
        this.userStore.index(this.query);
    },
    methods: {
        fetch(params) {
            this.userStore.index(params);
        }
    },
    computed: {
        currentUser() {
            return this.authStore.currentUser;
        },
        itemData() {
            return this.userStore.dataS;
        },
        itemDataStat() {
            return this.userStore.dataStatS;
        },
    },
}
</script>
```

## Store Import Paths Reference

From files in `/resources/js/views/{module}/`:
```javascript
import { useAuthStore } from '../../stores/auth';
import { useArtikelStore } from '../../stores/artikel';
```

From files in `/resources/js/components/`:
```javascript
import { useAuthStore } from '../stores/auth';
```

## Available Pinia Stores

Located in `/Users/tony/Code/simo/resources/js/stores/`:

| Store File | Import Name |
|------------|-------------|
| auth.js | useAuthStore |
| global.js | useGlobalStore |
| artikel.js | useArtikelStore |
| artikelKategori.js | useArtikelKategoriStore |
| artikelPenulis.js | useArtikelPenulisStore |
| artikelSimo.js | useArtikelSimoStore |
| cu.js | useCuStore |
| districts.js | useDistrictsStore |
| dokumen.js | useDokumenStore |
| dokumenKategori.js | useDokumenKategoriStore |
| errorLog.js | useErrorLogStore |
| fileUpload.js | useFileUploadStore |
| kegiatanBKCU.js | useKegiatanBKCUStore |
| notification.js | useNotificationStore |
| pekerjaan.js | usePekerjaanStore |
| pengumuman.js | usePengumumanStore |
| provinces.js | useProvincesStore |
| regencies.js | useRegenciesStore |
| role.js | useRoleStore |
| saran.js | useSaranStore |
| tempat.js | useTempatStore |
| tp.js | useTpStore |
| user.js | useUserStore |
| villages.js | useVillagesStore |

## If Store Doesn't Exist in Pinia Yet

If the component uses a store that hasn't been migrated to Pinia yet:
1. First migrate the store using `/slot-syntax-migration` workflow
2. Then update the component

OR use the Vuex compatibility layer (temporary):
```javascript
// This still works due to vuex-compat.js shim
import { mapGetters } from 'vuex';
```

But prefer migrating to Pinia when possible.
