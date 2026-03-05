# Vue 2 → Vue 3 Migration Plan (Admin SPA)

This document summarizes what is already migrated, the patterns to follow, and a checklist to migrate the remaining admin views and components from Vue 2 / Vuex to Vue 3 / Pinia.

---

## 1. What’s Already Done

### 1.1 App shell & routing
- **app.js**: Vue 3 `createApp`, Pinia, Vue Router 4, `createWebHistory('/admins')`, global `$filters`, stub `v-tooltip`, Vuex still registered for backward compatibility.
- **admin.vue**: Uses `useGlobalStore()` for loading state; router views with transitions.
- **routes.js**: All admin routes use lazy-loaded view components; layout uses `header` and `footer` for most routes.

### 1.2 Dashboard (migrated)
- **views/dashboard.vue**
  - Uses **Pinia** only: `useAuthStore()`, `useLaporanCuStore()`.
  - Options API with `data()` returning store instances, `computed` for `currentUser`, `columnData`, `columnDataPearls`.
  - Child widgets: `newsSlider`, `buttonRow`, `kegiatanBkcuWidget`, `pesertaDiklatBkcuWidget`, `grafikLaporanCuWidget`, `tableLaporanCuWidget`, `historyOrganisasiWidget`, `countOrganisasiWidget` (all under `views/dashboard/`).
- No Vuex, no `v-validate` / `$validator`.

### 1.3 Artikel module (migrated)
- **views/artikel/index.vue**
  - Pinia: `useAuthStore()`, `useArtikelStore()`.
  - Structure: `pageHeader`, `message`, `select-cu` (when `id_cu == 0`), `table-data` (artikel/table.vue).
  - Permission in `created`: `checkUser('index_artikel', this.$route.params.cu)`.
- **views/artikel/table.vue**
  - Pinia: `useAuthStore`, `useGlobalStore`, `useCuStore`, `useArtikelStore`, `useArtikelKategoriStore`, `useArtikelPenulisStore`.
  - Uses **DataViewer** (`components/dataviewer2.vue`), **app-modal**, **checkValue**.
  - Filter helpers from `helpers/filterHelpers`; `$filters` via `setup()` return (or global).
  - No Vuex.
- **views/artikel/form.vue**
  - Pinia: `useAuthStore`, `useCuStore`, `useArtikelStore`, `useArtikelKategoriStore`, `useArtikelPenulisStore`.
  - Uses **pageHeader**, **message**, **formButton**, **formInfo**, **formKategori** / **formPenulis** (modals), **appImageUpload**, **app-modal**, **wajibBadge**, RichTextEditor.
  - **Validation**: ✅ VeeValidate 4 – **VeeForm** + **Field** with rules; `handleSubmit(onValid)`, `:on-invalid-submit="onInvalid"`; `form-button` receives `:buttonErrors="errors"`. Modal forms **formKategori.vue** and **formPenulis.vue** also use VeeForm + Field.

**Pattern to copy for other modules:**
- **Index**: Pinia stores in `data()`, `computed` for store state, `pageHeader` + optional `select-cu` + `table-data` (table.vue), permission check in `created`.
- **Table**: Pinia + DataViewer + app-modal + checkValue; `@fetch` calls store action (e.g. `artikelStore.index` / `indexCu`); column config and slot `#item-desktop`.
- **Form**: Pinia; form data from store (e.g. `artikelStore.data`); modals for nested forms (e.g. penulis/kategori); standard components (pageHeader, formButton, formInfo, modal). Replace `v-validate` / `$validator` with a chosen validation approach.

---

## 2. View Modules Overview

Admin “pages” live under **resources/js/views/** (one folder per module). Typical layout:
- `index.vue` – list page (often with selectCu and table)
- `table.vue` – data table (DataViewer2, actions, modal confirm)
- `form.vue` – create/edit form (sometimes also `create.vue` / `edit.vue` or modal forms)

### 2.1 Modules already using Pinia (index/table/form)
These use Pinia (`useXStore`, `mapState`/`mapActions` from `pinia`) and no Vuex in the files checked. Many still use `v-validate` / `$validator` in forms (see section 3).

- artikel (full module migrated; form validation stubbed)
- keahlian
- kegiatanPeserta
- saldo
- monitoringCu (multiple sub-views)
- jalinanLaporan (cu, cair, penyebab, lama, usia, selectKelompok, tableKelompok)
- anggotaCuDraft (index, table, form; edit.vue and formCu.vue migrated to Pinia + VeeForm/Field)
- anggotaProdukCuDraft (index, table, form – Pinia)

### 2.2 View migration status (all listed views now use Pinia)
Previously Vuex; now migrated. None import from `'vuex'`.

| View | Notes |
|------|--------|
| **laporanGerakan/infografis.vue** | ✅ Pinia (useLaporanGerakanStore) |
| **enterpreneur/form.vue** | ✅ Pinia (useEnterpreneurStore, useCuStore, useAnggotaCuStore, useKubnUsahaStore) |
| **fasilitator/form.vue** | ✅ Pinia (useFasilitatorStore, useCuStore, useAnggotaCuStore) |
| **mentor/form.vue** | Pinia in table/index; form.vue uses $validator |
| **mentor/formKeahlian.vue** | ✅ Pinia (useKeahlianStore) |
| **umkm/formDiklat.vue** | ✅ Pinia (useAuthStore) |
| **aktivis/formLokasi.vue** | ✅ Pinia (provinces, regencies, districts, villages stores) |
| **aktivis/formKeluarga.vue** | ✅ Pinia (useUserStore) |
| **surat/select.vue** | ✅ Pinia (useSuratStore, useSuratKodeStore) |
| **suratMasuk/select.vue** | ✅ Pinia (useSuratMasukStore) |
| **jalinanCair/select.vue** | ✅ Pinia (useJalinanKlaimStore, getPencairan) |
| **jalinanCair/table.vue** | mapState (pinia) but also mapState(useJalinanKlaimStore) – verify no Vuex |
| **jalinanKlaim/form.vue** | ✅ Pinia (useJalinanKlaimStore, useAnggotaCuStore, useCuStore + cariDataId, resetData) |
| **jalinanKlaim/table.vue** | ✅ Pinia (useJalinanKlaimStore, useUserStore) |
| **assesmentAccess/form.vue**, **form_p1.vue** | ✅ Pinia (form: direct computed; form_p1: mapState(useLaporanCuStore) only) |
| **surat/form.vue** | ✅ Pinia (cuStore.getHeader) |
| **dokumen/form.vue** | ✅ Pinia (useDokumenPenulisStore) |
| **kegiatanBKCU/form.vue** | ✅ Pinia (mapState/mapActions from pinia) |
| **kegiatanBKCU/tableRekomHasil.vue** | ✅ Pinia (useKegiatanRekomStore) |
| **kegiatanBKCU/detailMading.vue** | ✅ Pinia (useKegiatanBKCUStore) |
| **laporanCu/formKatex.vue** | ✅ Pinia (useLaporanTpStore, useLaporanCuStore) |
| **saran/form.vue** | ✅ Pinia (saranStore.store) |
| **anggotaCuDraft/edit.vue** | ✅ Pinia (useAnggotaCuStore, useCuStore, useTpStore, etc.) |
| **anggotaCuDraft/form.vue** | ✅ Pinia (useAnggotaCuStore, direct state reset) |
| **anggotaCuDraft/formCu.vue** | ✅ Pinia (useCuStore, useTpStore) |
| **anggotaProdukCuDraft/form.vue** | ✅ Pinia (useCuStore, useAnggotaCuStore) |
| **anggotaProdukCuDraft/table.vue** | ✅ Pinia (useAnggotaCuStore) |

---

## 3. Form Validation (v-validate / $validator)

The project does **not** have VeeValidate in `package.json`. It has `@vuelidate/core` and `@vuelidate/validators`, but many views still use the **VeeValidate 2** API:
- `v-validate="'required'"` and `data-vv-as="Field Name"`
- `this.$validator.validateAll('form')` in submit handlers
- `errors.has('form.xxx')`, `errors.first('form.xxx')`

**Files using $validator / v-validate (non-exhaustive):**
- ~~artikel/form.vue, formKategori.vue, formPenulis.vue~~ – ✅ Migrated to VeeForm+Field
- tempat/form.vue (has errors shim comment)
- keahlian/form.vue, kodeKegiatan/form.vue
- laporanGerakan/form.vue
- monitoringCu/form.vue, formRekom.vue, formPencapaian.vue
- cu/form.vue
- enterpreneur/form.vue, fasilitator/form.vue, mentor/form.vue
- anggotaCu (create.vue, formCu.vue, formSimpanan, formPinjaman, formTransaksi, formProduk, formPindahTp, formNik, formKeluar, formCu)
- anggotaCuDraft/edit.vue, formCu.vue
- anggotaProdukCuDraft/form.vue
- jalinanKlaim (form.vue, formNoSurat, formPeriksaKoreksi, formStatus)
- voting (form.vue, formTanggapan, formPilihan, formKodeSuara, formCu)
- pemilihan/formCalon.vue
- asetTetap (form.vue, formKondisi, formLokasi), asetTetapJenis/Kelompok/Golongan/Lokasi form.vue
- mitraLembaga/form.vue
- dokumen/formKategori.vue
- ~~artikel/formPenulis.vue, formKategori.vue~~ – ✅ Migrated

**Chosen approach:** **VeeValidate 4** – `vee-validate` + `@vee-validate/rules`; global rules in **resources/js/helpers/veeValidate.js**.

**Two ways to use it (no schema required if you prefer rules on the tag):**

1. **Rules on the tag (like the old way)** – Use **VeeForm** + **Field**: wrap the form in `<VeeForm :form="form" v-slot="{ errors, handleSubmit }">`, use `<form @submit.prevent="handleSubmit(onValid, onInvalid)">`, and put rules on each field with `<Field name="name" rules="required" v-model="form.name" v-slot="{ field }"><input v-bind="field" class="form-control" ...></Field>`. No schema; add `rules="required"`, `rules="required|min:5"`, `rules="email"`, etc. on each **Field**. Example: **keahlian/form.vue** (VeeForm + Field).

2. **Schema in script** – Use **useFormValidation(formRef, schema)** in `setup()` with a single schema object (e.g. `{ name: 'required', email: 'email' }`). Good when you want all rules in one place. Example: **kodeKegiatan**, **tempat**, **artikel** form.vue.

**Legacy:** **resources/js/helpers/formValidation.js** (manual validation) remains for any forms not yet migrated; can be removed once all use VeeValidate 4.

---

## 4. Shared Components to Migrate or Reuse

### 4.1 Components using Vuex
- **components/hakAkses.vue** – ✅ Migrated to Pinia (`useAuthStore()` for `currentUser`).
- **components/selectCuTp.vue** – ✅ Migrated to Pinia (`useAuthStore()`, `useCuStore()`, `useTpStore()`; `getHeader`/`getCu` via store actions).

Migrate these to Pinia (e.g. `useAuthStore()`, `useCuStore()`, etc.) so that all admin views can rely on Pinia only.

### 4.2 Components used by migrated views (already Vue 3 compatible)
- **components/header.vue**, **footer.vue**
- **components/pageHeader.vue**, **message.vue**, **formButton.vue**, **formInfo.vue**, **wajibBadge.vue**
- **components/selectCu.vue** (used in artikel index; ensure it uses Pinia or no store)
- **components/dataviewer2.vue** – used in artikel/table and many others; no Vuex in pattern.
- **components/modal.vue** (app-modal)
- **components/checkValue.vue**
- **components/ImageUpload.vue** (app-image-upload)
- **views/dashboard/** – buttonRow, newsSlider, widgets (grafikLaporanCuWidget, tableLaporanCuWidget, etc.)

Check **selectCu.vue** and **dataviewer2.vue** for any remaining Vuex or Vue 2-only usage when migrating a new module that uses them.

---

## 5. Suggested Migration Order

1. **Shared components (Vuex → Pinia)** ✅ Done.  
   Migrate **hakAkses.vue** and **selectCuTp.vue** to Pinia so other views don’t depend on Vuex.

2. **Simple CRUD modules (already Pinia, only validation left)** ✅ Done.  
   e.g. **keahlian**, **kodeKegiatan**, **tempat** – replaced `v-validate` / `$validator` with manual validation via **helpers/formValidation.js** (`validateForm`, `errorsApi`); index/table/form use only Pinia (no Vuex).

3. **Artikel form validation** ✅ Done.  
   **artikel/form.vue**, **formKategori.vue**, **formPenulis.vue** use VeeForm + Field (VeeValidate 4); no stub or `$validator`.

4. **Related artikel modules** ✅ Done.  
   **artikelKategori**, **artikelPenulis**, **artikelSimo** – form.vue migrated to VeeValidate 4 (useFormValidation + schema); index/table already use Pinia.

5. **Modules with moderate Vuex usage** ✅ Done.  
   ~~**laporanGerakan** (infografis)~~, ~~**saran/form**~~, ~~**surat/form**~~, ~~**surat/select**~~, ~~**suratMasuk/select**~~, ~~**dokumen/form**~~, ~~**mentor/formKeahlian**~~, ~~**aktivis/formLokasi**~~, ~~**formKeluarga**~~, ~~**umkm/formDiklat**~~, ~~**fasilitator/formJenisDiklat**~~, ~~**enterpreneur/formDiklat**~~, ~~**jalinanCair/select**~~.  
   All migrated to Pinia.

6. **Heavy Vuex modules** ✅ Done.  
   ~~**jalinanKlaim** (table, form)~~, ~~**anggotaCuDraft** (edit, form, formCu)~~, ~~**anggotaProdukCuDraft** (form, table)~~, ~~**assesmentAccess** (form, form_p1)~~, ~~**kegiatanBKCU** (form, detail, tableRekomHasil, detailMading)~~, ~~**laporanCu** (formKatex)~~, ~~**enterpreneur/form**~~, ~~**fasilitator/form**~~.  
   All migrated to Pinia. No views import from `vuex` anymore (only `pinia` and optional `vuex.js` compat shim).

7. **Legacy / old views**
   ~~**laporanGerakan/table_old.vue**, **infografis_old.vue**, **index_old.vue**, **kegiatanBKCU/detail_old.vue**~~ – Removed (no longer used).

### Phase 2d status – Vuex removed from all views

- **No view imports from `vuex`**; the last one (**assesmentAccess/form_p1.vue**) was migrated (removed `mapGetters`, fixed `mapState(useLaporanCuStore)` to use `updateData`).
- **Remaining (optional):**
  - ~~**Artikel form validation**~~ – Done (artikel form, formKategori, formPenulis use VeeForm+Field).
  - **Other forms still using $validator / v-validate** – See Section 3 list; migrate to VeeForm+Field or useFormValidation when touching those modules.
  - **Bug 3 (v-for + v-if)** – Fix in components/views listed in Section 9 when visiting them. **datapanel2.vue**, **aktivis/select**, **kombas/select**, **laporanCu/select**, **selectDetail**, **formKatex**, **detailLaporanCu**, **jalinanCair/select**, **kegiatanPeserta/select**, **formRekomHasil**, **jalinanIuran** (form, detail, tableAnggota), **suratKategori/form**, **saldo/cariData**, **saldo/index** – all fixed. Remaining: dataviewerName, hakAkses, selectCuTp, selectCu_backup, surat/form, and several other forms (see Section 9).
  - **Bug 4 (Pinia update vs updateData)** – Ensure any store still exposing `update` state uses `updateData` and views reference it (e.g. **laporanCu** is already correct; others as needed).
  - **Optional cleanup:** Remove **resources/js/vuex.js** and **resources/js/helpers/vuex-compat.js** (and Vuex from app.js) once you confirm no code paths use them.

---

## 6. Per-Module Migration Checklist

Use this for each view folder under `views/`:

- [ ] **Index.vue**  
  - [ ] Use only Pinia (`useXStore()` in data or computed).  
  - [ ] No `mapGetters`/`mapState` from `'vuex'`.  
  - [ ] No `this.$store`.  
  - [ ] Permission check in `created` (e.g. `checkUser('index_xxx', ...)`).  
  - [ ] Same layout pattern as artikel (pageHeader, optional selectCu, table).

- [ ] **Table.vue**  
  - [ ] Pinia only; fetch via store action (e.g. `artikelStore.index(params)`).  
  - [ ] DataViewer (dataviewer2), app-modal, checkValue.  
  - [ ] Column config and `#item-desktop` slot; buttons (Tambah, Ubah, Hapus) and modal confirm.  
  - [ ] No Vuex.

- [ ] **Form.vue (and create/edit/modal forms)**  
  - [ ] Pinia only; form data from store (e.g. `store.data`).  
  - [ ] No `v-validate` / `$validator`; use chosen validation (VeeValidate 4, Vuelidate, or manual).  
  - [ ] No Vuex.  
  - [ ] Standard components: pageHeader, formButton, formInfo, modal if needed.

- [ ] **Components used by this module**  
  - [ ] If they use Vuex, either migrate component or replace with a Pinia-based alternative.

---

## 7. Store Layer

- **Pinia stores** live in **resources/js/stores/** (e.g. `artikel.js`, `keahlian.js`, `auth.js`, `cu.js`). Each defines `defineStore` with `state`, `getters`, `actions` and uses API modules from **resources/js/api/**.
- **Vuex store** is in **resources/js/store/index.js** and **store/modules/**; still used by many views above. As you migrate a view, use the corresponding Pinia store from `stores/` and stop using Vuex in that view.
- For modules that don’t have a Pinia store yet, create one in `stores/` following the pattern of `stores/artikel.js` and the existing API in `api/`.

---

## 8. Quick Reference: Artikel vs Others

| Aspect | Dashboard | Artikel | Others (to align) |
|--------|-----------|--------|-------------------|
| State | Pinia only | Pinia only | Replace Vuex with Pinia |
| Index | pageHeader + widgets / selectCu + table | pageHeader + selectCu + table | Same pattern |
| Table | N/A (widgets) | DataViewer + modal + checkValue | Same |
| Form | N/A | Pinia + modal sub-forms; validation stubbed | Pinia + real validation |
| Validation | – | Stub + $validator (broken) | Decide approach and apply everywhere |

After you finish migrating a module, run the relevant tests and do a quick manual test (list, create, edit, delete) for that module.

---

## 9. Known Bugs When Migrating to VeeValidate 4

### Bug 1: `<message>` placed outside `<VeeForm>` scoped slot → blank page

**Symptom:** Clicking "Tambah" or "Ubah" shows a blank page (only navigation/header). Console error:
```
Cannot read properties of undefined (reading 'any')
  at Proxy._sfc_render (form.vue:12:28)
```

**Root cause:** In vee-validate 2/3, `errors` was globally injected into every component. In vee-validate 4, `errors` is only available inside a `<VeeForm>` (or `<Form>`) scoped slot via `v-slot="{ errors }"`. When the `<message>` component sits **above/before** the `<VeeForm>` opening tag, its `errors` reference is `undefined`, crashing the render.

**Fix:** Move `<message>` inside the `<VeeForm>` scoped slot, before the `<form>` tag:

```html
<!-- BEFORE (broken) -->
<message v-if="errors.any('form') && submited" ...></message>
<VeeForm :form="form" v-slot="{ errors, handleSubmit }">
  <form @submit.prevent="handleSubmit(onValid, onInvalid)">
    ...
  </form>
</VeeForm>

<!-- AFTER (fixed) -->
<VeeForm :form="form" v-slot="{ errors, handleSubmit }">
  <message v-if="errors.any('form') && submited" ...></message>
  <form @submit.prevent="handleSubmit(onValid, onInvalid)">
    ...
  </form>
</VeeForm>
```

**Files already fixed:**
- `views/artikel/form.vue`
- `views/user/form.vue`
- `views/voting/form.vue`
- `views/pemilihan/form.vue`
- `views/sertifikatKegiatan/form.vue`
- `views/sertifikatKegiatan/formNomorSertifikatKegiatan.vue`
- `views/keahlian/form.vue`
- `views/artikelPenulis/form.vue`

### Bug 2 (potential): Forms NOT yet migrated to VeeForm still using old `errors` API

Many forms still use the old vee-validate 2 API (`errors.has()`, `errors.first()`, `errors.any()`) without VeeForm and without a stub `errors` object. These will crash the same way when the old `$validator` / `v-validate` directives are no longer available.

**When migrating these forms to VeeValidate 4**, remember:
1. Wrap the form content (including `<message>`) inside `<VeeForm :form="form" v-slot="{ errors, handleSubmit }">`.
2. Make sure `<message>` is **inside** the slot, not above it.
3. Replace `v-validate` directives with `<Field>` components with `rules` prop.
4. Replace `this.$validator.validateAll('form')` with `handleSubmit(onValid, onInvalid)`.
5. The `errors` adapter in VeeForm.vue provides `.has()`, `.first()`, `.any()`, `.items` — so existing template code works as-is once inside the slot.

**Forms not yet migrated (still using old API, will need this fix when migrated):**
See the list in Section 3 above. Each one will need the same `<message>` placement fix when wrapped in `<VeeForm>`.

### Bug 3: `v-for` + `v-if` on same element (Vue 3 priority change)

**Symptom:** Select dropdowns, table rows, or list items that use `v-for` with `v-if` on the **same element** — where `v-if` references the loop variable — silently render nothing.

**Cause:** In Vue 2, `v-for` had higher priority than `v-if`, so the loop variable was available to `v-if`. In Vue 3, `v-if` evaluates **first**, before `v-for` creates the loop variable. The variable is `undefined`, the condition is falsy, and the element never renders.

**Fix:** Wrap with `<template v-for>` and move `v-if` to the inner element:

```html
<!-- BEFORE (broken in Vue 3) -->
<option v-for="item in items" v-if="item" :value="item.id">{{ item.name }}</option>

<!-- AFTER (fixed) -->
<template v-for="item in items" :key="item ? item.id : undefined">
  <option v-if="item" :value="item.id">{{ item.name }}</option>
</template>
```

**Files already fixed:**
- `views/artikel/form.vue` (penulis & kategori selects)
- `components/datapanel2.vue` (2 option elements: column filter, order column)
- `views/aktivis/select.vue` (2 option elements)
- `views/kombas/select.vue` (2 option elements)
- `views/laporanCu/select.vue` (4 option elements)
- `views/laporanCu/selectDetail.vue` (3 option elements)
- `views/laporanCu/formKatex.vue` (katex1/katex2 divs + form row)
- `views/laporanCu/detailLaporanCu.vue` (form row)
- `views/jalinanCair/select.vue` (1 option)
- `views/kegiatanPeserta/select.vue` (2 option elements)
- `views/kegiatanBKCU/formRekomHasil.vue` (1 option)
- `views/jalinanIuran/form.vue` (2 tr elements)
- `views/jalinanIuran/detail.vue` (2 tr elements)
- `views/jalinanIuran/tableAnggota.vue` (1 td)
- `views/suratKategori/form.vue` (1 option)
- `views/saldo/cariData.vue` (1 option)
- `views/saldo/index.vue` (1 div)

**Note:** `components/dataviewer.vue` and `components/dataPanel.vue` use `v-for` with `v-show` (not `v-if`) on the same element; Vue 3 does not require the template fix for v-show.

**Files still affected (fix when visiting each module):**
- `components/dataviewerName.vue` (1 instance)
- `components/hakAkses.vue` (2 instances)
- `components/selectCuTp.vue` (2 instances — cu & tp selects)
- `components/selectCu_backup.vue` (2 instances)
- `views/surat/form.vue` (2 instances)
- `views/dokumen/form.vue` (1 instance)
- `views/produkCu/form.vue` (1 instance)
- `views/enterpreneur/form.vue` (1 instance)
- `views/umkm/form.vue` (1 instance)
- `views/mentor/formKeahlian.vue` (1 instance)
- `views/fasilitator/formJenisDiklat.vue` (1 instance)
- `views/asetTetap/formLokasi.vue` (1 instance)
- `views/asetTetapJenis/form.vue` (2 instances)
- `views/asetTetapKelompok/form.vue` (1 instance)
- `views/kubn/form.vue` (1 instance)

### Bug 4: Pinia state/action naming collision (`update`)

**Symptom:** `TypeError: this.someStore.update is not a function` when saving/editing.

**Cause:** Every Pinia store has both `state.update: []` (holds API response) AND `actions.update()` (performs API call) with the same name. In Pinia, the action overwrites the state slot on the store object. Inside any action that does `this.update = response.data`, the assignment replaces the action function with the data object. A subsequent call to `store.update(id, form)` then fails because `update` is now a plain object.

**Fix per store:**
1. Rename the state property: `update: []` → `updateData: []`
2. Replace all `this.update = ...` inside that store's actions with `this.updateData = ...`
3. Update all view/component computed properties that read `store.update` → `store.updateData`

**Stores & files already fixed:**
- `stores/artikel.js` + `views/artikel/form.vue` + `views/artikel/table.vue`

**All other stores have the same collision** — fix each when visiting its module:
- `stores/artikelKategori.js`, `stores/artikelPenulis.js`, `stores/voting.js`, `stores/jalinanKlaim.js`, etc.
