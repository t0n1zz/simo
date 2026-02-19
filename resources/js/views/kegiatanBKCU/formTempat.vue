<template>
	<div>
		<!-- message -->
		<message v-if="errors && errors.any && errors.any('formTempat') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="save" enctype="multipart/form-data" data-vv-scope="formTempat">
		
		<div class="row">

			<!-- gambar utama -->
			<div class="col-md-12">
				<div class="formTempat-group">

					<!-- title -->
					<h5>Foto:</h5>

					<!-- imageupload -->
					<app-image-upload :image_loc="'/images/tempat/'" :image_temp="formTempat.gambar" v-model="formTempat.gambar"></app-image-upload>
				</div>
			</div>

			<!-- name -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formTempat.name')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.name')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.name')"></i>
						Nama:</h5>

					<!-- text -->
					<input type="text" name="name" class="form-control" placeholder="Silahkan masukkan nama tempat kegiatan"
					 v-validate="'required|min:5'" data-vv-as="Nama" v-model="formTempat.name">

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formTempat.name')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formTempat.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- Provinsi -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h5>
						Provinsi:
					</h5>

					<!-- select -->
					<select class="form-control" name="id_provinces" v-model="formTempat.id_provinces" data-width="100%" disabled>
						<option disabled value="">
							<span v-if="modelProvincesStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih provinsi</span>
						</option>
						<option v-for="provinces in modelProvinces" :value="provinces.id">{{provinces.name}}</option>
					</select>
				</div>
			</div>

			<!-- kabupaten -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h5>
						Kabupaten:
					</h5>

					<!-- select -->
					<select class="form-control" name="id_regencies" v-model="formTempat.id_regencies" data-width="100%" disabled>
						<option disabled value="">
							<span v-if="modelRegenciesStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih kabupaten</span>
						</option>
						<option v-for="regencies in modelRegencies" :value="regencies.id">{{regencies.name}}</option>
					</select>
				</div>
			</div>

			<!-- kecamatan -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formTempat.id_districts')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.id_districts')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.id_districts')"></i>
						Kecamatan:
					</h5>

					<!-- select -->
					<select class="form-control" name="id_districts" v-model="formTempat.id_districts" data-width="100%" v-validate="'required'"
					 data-vv-as="Kabupaten" :disabled="modelDistricts.length === 0" @change="changeDistricts($event.target.value)">
						<option disabled value="">
							<span v-if="modelDistrictsStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih kecamatan</span>
						</option>
						<option v-for="districts in modelDistricts" :value="districts.id">{{districts.name}}</option>
					</select>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formTempat.id_regency')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formTempat.id_regency') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kelurahan -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formTempat.id_villages')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.id_villages')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.id_villages')"></i>
						Kelurahan:
					</h5>

					<!-- select -->
					<select class="form-control" name="id_villages" v-model="formTempat.id_villages" data-width="100%" v-validate="'required'"
					 data-vv-as="Desa" :disabled="modelVillages.length === 0">
						<option disabled value="">
							<span v-if="modelVillagesStat === 'loading'">Mohon tunggu... mohon tunggu</span>
							<span v-else>Silahkan pilih kelurahan</span>
						</option>
						<option v-for="villages in modelVillages" :value="villages.id">{{villages.name}}</option>
					</select>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formTempat.id_villages')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formTempat.id_villages') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- alamat -->
			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formTempat.alamat')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.alamat')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.alamat')"></i>
						Alamat:</h5>

					<!-- text -->
					<input type="text" name="alamat" class="form-control" placeholder="Silahkan masukkan alamat" v-validate="'required|min:5'"
					 data-vv-as="Alamat" v-model="formTempat.alamat">

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formTempat.alamat')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formTempat.alamat') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- no telp -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.telp')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.telp')"></i>
						No. Telp:</h5>

					<!-- text -->
					<cleave v-model="formTempat.telp" class="form-control" :options="cleaveOption.number12" placeholder="Silahkan masukkan no telp"></cleave>

					<!-- error message -->
					<small class="text-muted">&nbsp;</small>
				</div>
			</div>

			<!-- no hp -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.hp')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.hp')"></i>
						No. Hp:</h5>

					<!-- text -->
					<cleave v-model="formTempat.hp" class="form-control" :options="cleaveOption.number12" placeholder="Silahkan masukkan no hp"></cleave>

					<!-- error message -->
					<small class="text-muted">&nbsp;</small>
				</div>
			</div>

			<!-- kode pos -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.pos')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.pos')"></i>
						Kode Pos:</h5>

					<!-- text -->
					<cleave v-model="formTempat.pos" class="form-control" :options="cleaveOption.number12" placeholder="Silahkan masukkan kode pos"></cleave>

					<!-- error message -->
					<small class="text-muted">&nbsp;</small>
				</div>
			</div>

			<!-- email -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formTempat.email')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.email')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.email')"></i>
						E-mail:</h5>

					<!-- text -->
					<input type="text" name="email" class="form-control" placeholder="Silahkan masukkan alamat e-mail" v-validate="'email'"
					 data-vv-as="E-mail" v-model="formTempat.email">

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formTempat.email')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formTempat.email') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- website -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formTempat.website')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formTempat.website')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('formTempat.website')"></i>
						Website:</h5>

					<!-- text -->
					<input type="text" name="website" class="form-control" placeholder="Silahkan masukkan alamat website" v-model="formTempat.website"
					 v-validate="'url'" data-vv-as="Website">

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formTempat.website')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formTempat.website') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

		</div>

		<!-- form info -->
		<form-info></form-info>	

		<!-- divider -->
		<hr>

		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" >
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div>

		</form>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useTempatStore } from '../../stores/tempat';
	import { useProvincesStore } from '../../stores/provinces';
	import { useRegenciesStore } from '../../stores/regencies';
	import { useDistrictsStore } from '../../stores/districts';
	import { useVillagesStore } from '../../stores/villages';
	import checkValue from '../../components/checkValue.vue';
	import { toMulipartedForm } from '../../helpers/form';
	import DataViewer from '../../components/dataviewerName.vue';
	import message from "../../components/message.vue";
	import appImageUpload from '../../components/ImageUpload.vue';
	import Cleave from 'vue-cleave-component';
	import formInfo from "../../components/formInfo.vue";

	export default {
		props: ['id_provinces','id_regencies'],
		components: {
			DataViewer,
			appImageUpload,
			checkValue,
			formInfo,
			Cleave,
			message
		},
		data() {
			return {
				title: '',
				kelas: 'tempat',
				query: {
					order_column: "name",
					order_direction: "asc",
					filter_match: "and",
					limit: 10,
					page: 1
				},
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
          },
          number12: {
            numeral: true,
            numeralIntegerScale: 12,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
					number3: {
            numeral: true,
            numeralIntegerScale: 3,
            numeralDecimalScale: 0,
            stripLeadingZeroes: false
          },
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
          }
				},
				submited: false,
        // SHIM: Add dummy errors object for VeeValidate 2 compatibility in Vue 3
        errors: {
          any: () => false,
          has: () => false,
          first: () => '',
          collect: () => [],
          items: []
        },
			}
		},
		created() {
			this.fetch();
		},
		watch: {
			modelProvincesStat(value){
				if(value == 'success'){
					this.changeProvinces(this.id_provinces);
				}
			},
			modelRegenciesStat(value){
				if(value == 'success'){
					this.changeRegencies(this.id_regencies);
				}
				this.formTempat.id_provinces = this.id_provinces;
				this.formTempat.id_regencies = this.id_regencies;
			},

		},
		methods: {
			...mapActions(useTempatStore, {
				create: 'create',
				store: 'store',
			}),
			...mapActions(useProvincesStore, {
				getProvinces: 'get',
			}),
			...mapActions(useRegenciesStore, {
				getRegencies: 'getProvinces',
			}),
			...mapActions(useDistrictsStore, {
				getDistricts: 'getRegencies',
			}),
			...mapActions(useVillagesStore, {
				getVillages: 'getDistricts',
			}),
			fetch(){
				this.title = 'Tambah Tempat Kegiatan';
				this.titleDesc = 'Menambah Tempat Kegiatan';
				this.titleIcon = 'icon-plus3';
				this.create();

				this.getProvinces();
			},
			changeProvinces(id){
				this.getRegencies(id);
			},
			changeRegencies(id){
				this.getDistricts(id);
			},
			changeDistricts(id){
				this.getVillages(id);
			},
			save() {
				const formData = toMulipartedForm(this.formTempat, this.$route.meta.mode);
				this.$validator.validateAll('formTempat').then((result) => {
					if (result) {
						this.store(formData);
						this.submited = false;
					}else{
						this.submited = true;
					}
				});
			},
			tutup() {
				this.$emit('tutup');
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useTempatStore,{
				formTempat: 'data',
				formTempatStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'update',
				updateStat: 'updateStat'
			}),
			...mapState(useProvincesStore,{
				modelProvinces: 'dataS',
				modelProvincesStat: 'dataStatS'
			}),
			...mapState(useRegenciesStore,{
				modelRegencies: 'dataS',
				modelRegenciesStat: 'dataStatS'
			}),
			...mapState(useDistrictsStore,{
				modelDistricts: 'dataS',
				modelDistrictsStat: 'dataStatS'
			}),
			...mapState(useVillagesStore,{
				modelVillages: 'dataS',
				modelVillagesStat: 'dataStatS'
			})
		}
	}
</script>