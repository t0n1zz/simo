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
  - Uses **pageHeader**, **message**, **formButton**, **formInfo**, **formKategori** / **formPenulis** (modals), **appImageUpload**, **app-modal**, **wajibBadge**, CKEditor.
  - **Validation**: Has a stub `errors` object in `data()` and still calls `this.$validator.validateAll('form')` in `save()`. There is no VeeValidate in `package.json`; validation is effectively incomplete and should be migrated (see section 4).

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
- anggotaCuDraft (index, table, form; form.vue still uses Vuex commit; edit.vue uses Vuex)
- anggotaProdukCuDraft (index, form; table and form use Vuex)

### 2.2 Views still using Vuex
These import from `'vuex'` and/or use `this.$store.dispatch` / `this.$store.commit`:

| View | Notes |
|------|--------|
| **laporanGerakan/infografis.vue** | `mapGetters` from vuex, `this.$store.dispatch(this.kelas + '/index')` |
| **enterpreneur/form.vue** | mapGetters (vuex), $store.dispatch for cu, kelas, kubnUsaha, anggotaCu |
| **fasilitator/form.vue** | mapGetters (vuex), $store.dispatch for cu, kelas, anggotaCu |
| **mentor/form.vue** | Pinia in table/index; form.vue uses $validator |
| **mentor/formKeahlian.vue** | mapGetters (vuex), $store.dispatch('keahlian/get') |
| **umkm/formDiklat.vue** | mapGetters (vuex) |
| **aktivis/formLokasi.vue** | mapGetters (vuex), $store.dispatch provinces/regencies/districts/villages |
| **aktivis/formKeluarga.vue** | mapGetters (vuex) |
| **surat/select.vue** | mapGetters (vuex), $store.dispatch for periode, suratKode |
| **suratMasuk/select.vue** | mapGetters (vuex), $store.dispatch getPeriode |
| **jalinanCair/select.vue** | mapGetters (vuex), $store.dispatch jalinanKlaim/getPencairan |
| **jalinanCair/table.vue** | mapState (pinia) but also mapState(useJalinanKlaimStore) – verify no Vuex |
| **jalinanKlaim/form.vue** | Heavy $store.dispatch/commit (jalinanKlaim, anggotaCu, resetForm, etc.) |
| **jalinanKlaim/table.vue** | $store.dispatch for index, resetUpdateStat, destroy, updateSelesai, user/indexCuPermission |
| **assesmentAccess/form.vue**, **form_p1.vue** | mapGetters (vuex), $store.dispatch laporanCu, kelas |
| **surat/form.vue** | $store.dispatch('cu/getHeader') |
| **dokumen/form.vue** | $store.dispatch('dokumenPenulis/getCu') |
| **kegiatanBKCU/form.vue** | $store.dispatch kodeKegiatan, kelas, provinces, sertifikatKegiatan, cu |
| **kegiatanBKCU/tableRekomHasil.vue** | $store.dispatch resetUpdateStat2, destroyHasil |
| **kegiatanBKCU/detailMading.vue** | $store.dispatch indexPesertaCountCu, indexPesertaHadirCountCu |
| **kegiatanBKCU/detail_old.vue** | Large legacy Vuex usage |
| **laporanCu/formKatex.vue** | $store.dispatch laporanTp/update, laporanCu/update |
| **saran/form.vue** | $store.dispatch(this.kelas + '/store', ...) |
| **anggotaCuDraft/edit.vue** | Heavy Vuex (cu, pekerjaan, suku, provinces, regencies, districts, villages, tp, kelas editDraft/updateDraft/resetUpdateStat) |
| **anggotaCuDraft/form.vue** | $store.commit setData/setDataStat; mapGetters (vuex) |
| **anggotaCuDraft/formCu.vue** | $store.dispatch cu/getHeader, tp/getCu; $validator |
| **anggotaProdukCuDraft/form.vue** | $store.dispatch cu/getHeader, kelas updateProdukCuDraft; mapGetters (vuex) |
| **anggotaProdukCuDraft/table.vue** | Vuex imports, $store.dispatch indexProdukCuDraft, resetUpdateStat, storeProdukCuDraft, destroyProdukCuDraft, etc. |

---

## 3. Form Validation (v-validate / $validator)

The project does **not** have VeeValidate in `package.json`. It has `@vuelidate/core` and `@vuelidate/validators`, but many views still use the **VeeValidate 2** API:
- `v-validate="'required'"` and `data-vv-as="Field Name"`
- `this.$validator.validateAll('form')` in submit handlers
- `errors.has('form.xxx')`, `errors.first('form.xxx')`

**Files using $validator / v-validate (non-exhaustive):**
- artikel/form.vue (has errors stub; $validator still called)
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
- artikel/formPenulis.vue (and likely formKategori)

**Recommendation:** Choose one approach and apply it consistently:
1. **VeeValidate 4** (Vue 3): `useForm`, `useField`, or `<Form>` / `<Field>` components; replace `v-validate` and `$validator.validateAll`.
2. **Vuelidate 2** (already in project): Use `useVuelidate` and validators in script; replace template directives and $validator.
3. **Manual validation**: Keep form data in Pinia/store, validate in submit (e.g. from Laravel rules or a small shared validator), show errors via local state or a small composable.

---

## 4. Shared Components to Migrate or Reuse

### 4.1 Components using Vuex
- **components/hakAkses.vue** – `mapGetters` from vuex.
- **components/selectCuTp.vue** – `mapGetters` from vuex.

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

1. **Shared components (Vuex → Pinia)**  
   Migrate **hakAkses.vue** and **selectCuTp.vue** to Pinia so other views don’t depend on Vuex.

2. **Simple CRUD modules (already Pinia, only validation left)**  
   e.g. **keahlian**, **kodeKegiatan**, **tempat** – replace `v-validate` / `$validator` with the chosen validation approach; ensure index/table/form use only Pinia (no Vuex).

3. **Artikel form validation**  
   Fix **artikel/form.vue** validation (and modal forms formKategori, formPenulis) so create/edit work correctly; use the same approach as in step 2.

4. **Related artikel modules**  
   **artikelKategori**, **artikelPenulis**, **artikelSimo** – same pattern as artikel (index + table + form); use Pinia stores that already exist under `stores/`.

5. **Modules with moderate Vuex usage**  
   **laporanGerakan** (infografis), **saran/form**, **surat/form**, **surat/select**, **suratMasuk/select**, **dokumen/form**, **mentor/formKeahlian**, **aktivis/formLokasi**, **formKeluarga**, **umkm/formDiklat**, **fasilitator/formJenisDiklat**, **enterpreneur/formDiklat**, **jalinanCair/select**.  
   Replace Vuex with Pinia store calls (same API pattern as in stores/*.js).

6. **Heavy Vuex modules**  
   **jalinanKlaim** (form, table), **anggotaCuDraft** (edit, form, formCu), **anggotaProdukCuDraft** (form, table), **assesmentAccess**, **kegiatanBKCU** (form, detail, tableRekomHasil, detailMading), **laporanCu** (formKatex), **enterpreneur/form**, **fasilitator/form**.  
   Migrate store usage to Pinia (and optionally refactor to Composition API later). Do one module at a time; run tests and manual checks after each.

7. **Legacy / old views**  
   **laporanGerakan/table_old.vue**, **infografis_old.vue**, **index_old.vue**, **kegiatanBKCU/detail_old.vue** – migrate only if still in use; otherwise consider removing or archiving.

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
