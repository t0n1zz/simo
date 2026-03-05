<template>
	<div>
		<VeeForm :form="formTempat" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="handleSubmit(onValid)" enctype="multipart/form-data">
		
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
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('name')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('name')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('name')"></i>
						Nama:</h5>

					<!-- text -->
					<Field name="name" v-slot="{ field }" :rules="'required|min:5'" label="Nama">
						<input type="text" class="form-control" placeholder="Silahkan masukkan nama tempat kegiatan" v-bind="field" v-model="formTempat.name">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('name')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('name') }}
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
						<option v-for="provinces in modelProvinces" :key="provinces.id" :value="provinces.id">{{ provinces.name }}</option>
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
						<option v-for="regencies in modelRegencies" :key="regencies.id" :value="regencies.id">{{ regencies.name }}</option>
					</select>
				</div>
			</div>

			<!-- kecamatan -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('id_districts')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('id_districts')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('id_districts')"></i>
						Kecamatan:
					</h5>

					<!-- select -->
					<Field name="id_districts" v-slot="{ field }" :rules="'required'" label="Kecamatan">
						<select class="form-control" data-width="100%" v-bind="field" v-model="formTempat.id_districts" :disabled="modelDistricts.length === 0" @change="changeDistricts($event.target.value)">
							<option disabled value="">
								<span v-if="modelDistrictsStat === 'loading'">Mohon tunggu...</span>
								<span v-else>Silahkan pilih kecamatan</span>
							</option>
							<option v-for="districts in modelDistricts" :key="districts.id" :value="districts.id">{{ districts.name }}</option>
						</select>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('id_districts')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('id_districts') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kelurahan -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('id_villages')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('id_villages')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('id_villages')"></i>
						Kelurahan:
					</h5>

					<!-- select -->
					<Field name="id_villages" v-slot="{ field }" :rules="'required'" label="Kelurahan">
						<select class="form-control" data-width="100%" v-bind="field" v-model="formTempat.id_villages" :disabled="modelVillages.length === 0">
							<option disabled value="">
								<span v-if="modelVillagesStat === 'loading'">Mohon tunggu... mohon tunggu</span>
								<span v-else>Silahkan pilih kelurahan</span>
							</option>
							<option v-for="villages in modelVillages" :key="villages.id" :value="villages.id">{{ villages.name }}</option>
						</select>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('id_villages')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('id_villages') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- alamat -->
			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('alamat')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('alamat')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('alamat')"></i>
						Alamat:</h5>

					<!-- text -->
					<Field name="alamat" v-slot="{ field }" :rules="'required|min:5'" label="Alamat">
						<input type="text" class="form-control" placeholder="Silahkan masukkan alamat" v-bind="field" v-model="formTempat.alamat">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('alamat')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('alamat') }}
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
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('email')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('email')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('email')"></i>
						E-mail:</h5>

					<!-- text -->
					<Field name="email" v-slot="{ field }" :rules="'email'" label="E-mail">
						<input type="text" class="form-control" placeholder="Silahkan masukkan alamat e-mail" v-bind="field" v-model="formTempat.email">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('email')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('email') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- website -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('website')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('website')}">
						<i class="icon-cross2" v-if="errors && errors.has && errors.has('website')"></i>
						Website:</h5>

					<!-- text -->
					<Field name="website" v-slot="{ field }" :rules="'url'" label="Website">
						<input type="text" class="form-control" placeholder="Silahkan masukkan alamat website" v-bind="field" v-model="formTempat.website">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('website')">
						<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('website') }}
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
		</VeeForm>

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
	import VeeForm from "../../components/VeeForm.vue";
	import { Field } from 'vee-validate';

	export default {
		props: ['id_provinces','id_regencies'],
		components: {
			DataViewer,
			appImageUpload,
			checkValue,
			formInfo,
			Cleave,
			message,
			VeeForm,
			Field
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
			onValid() {
				const formData = toMulipartedForm(this.formTempat, this.$route.meta.mode);
				this.store(formData);
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
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