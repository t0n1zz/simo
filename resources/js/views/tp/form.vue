<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>
		
		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">

						<!-- message -->
						<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'"
							:errorItem="errors.items">
						</message>

						<!-- main panel -->
						<form @submit.prevent="handleSubmit(onValid)" enctype="multipart/form-data">

						<!-- informasi umum -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">1. Informasi Umum</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<!-- foto -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Foto TP/KP:</h5>

											<!-- imageupload -->
											<app-image-upload :image_loc="'/images/tp/'" :image_temp="form.gambar" v-model="form.gambar"></app-image-upload>
										</div>
									</div>  

									<!-- CU -->
									<div class="col-md-4" v-if="currentUser.id_cu === 0">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_cu')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_cu')}">
												<i class="icon-cross2" v-if="errors.has('form.id_cu')"></i>
												CU: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="id_cu" rules="required" v-model="form.id_cu" v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field"
													:disabled="modelCU.length === 0">
													<option disabled value="0">Silahkan pilih CU</option>
													<option v-for="(cu, index) in modelCU" :value="cu.id" :key="index">
														{{cu.name}}
													</option>
												</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_cu')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_cu') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- no_ba -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.no_tp')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.no_tp')}">
												<i class="icon-cross2" v-if="errors.has('form.no_tp')"></i>
												No. TP/KP: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="no_tp" rules="required" v-model="form.no_tp" v-slot="{ field }">
												<cleave
													:name="field.name"
													:value="field.value"
													@input="field.onChange"
													@blur="field.onBlur"
													class="form-control"
													:options="cleaveOption.number3"
													placeholder="Silahkan masukkan no TP/KP."
												></cleave>
											</Field>
											

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.no_tp')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.no_tp') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- name -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.name')}">
												<i class="icon-cross2" v-if="errors.has('form.name')"></i>
												Nama: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="name" rules="required|min:5" v-model="form.name" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan nama TP/KP" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.name')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- ultah -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.ultah')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.ultah')}">
												<i class="icon-cross2" v-if="errors.has('form.ultah')"></i>
												Tgl. Berdiri: <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<date-picker @dateSelected="form.ultah = $event" :defaultDate="form.ultah"></date-picker>
											<Field name="ultah" rules="required" v-model="form.ultah" v-slot="{ field }">
												<input v-bind="field" type="text" v-show="false" aria-hidden="true" />
											</Field>


											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.ultah')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.ultah') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- lokasi -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">2. Lokasi</h5>
							</div>
							<div class="card-body">
								<div class="row">
									
									<!-- Provinsi -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_provinces')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_provinces')}">
												<i class="icon-cross2" v-if="errors.has('form.id_provinces')"></i>
												Provinsi: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="id_provinces" rules="required" v-model="form.id_provinces"
												v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field"
													:disabled="modelProvinces.length === 0"
													@change="changeProvinces($event.target.value)">
													<option disabled value="0">
														<span v-if="modelProvincesStat === 'loading'">Mohon tunggu...</span>
														<span v-else>Silahkan pilih provinsi</span>
													</option>
													<option v-for="(provinces, index) in modelProvinces" :value="provinces.id"
														:key="index">{{provinces.name}}</option>
												</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_provinces')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_provinces') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kabupaten -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_regencies')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_regencies')}">
												<i class="icon-cross2" v-if="errors.has('form.id_regencies')"></i>
												Kabupaten: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="id_regencies" rules="required" v-model="form.id_regencies"
												v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field"
													@change="changeRegencies($event.target.value)"
													:disabled="modelRegencies.length === 0">
													<option disabled value="0">
														<span v-if="modelRegenciesStat === 'loading'">Mohon tunggu...</span>
														<span v-else>Silahkan pilih kabupaten</span>
													</option>
													<option v-for="(regencies, index) in modelRegencies" :value="regencies.id"
														:key="index">{{regencies.name}}</option>
												</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_regencies')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_regencies') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kecamatan -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_districts')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_districts')}">
												<i class="icon-cross2" v-if="errors.has('form.id_districts')"></i>
												Kecamatan: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="id_districts" rules="required" v-model="form.id_districts"
												v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field"
													:disabled="modelDistricts.length === 0"
													@change="changeDistricts($event.target.value)">
													<option disabled value="0">
														<span v-if="modelDistrictsStat === 'loading'">Mohon tunggu...</span>
														<span v-else>Silahkan pilih kecamatan</span>
													</option>
													<option v-for="(districts, index) in modelDistricts" :value="districts.id"
														:key="index">{{districts.name}}</option>
												</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_districts')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_districts') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kelurahan -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_villages')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_villages')}">
												<i class="icon-cross2" v-if="errors.has('form.id_villages')"></i>
												Kelurahan: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="id_villages" rules="required" v-model="form.id_villages"
												v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field"
													:disabled="modelVillages.length === 0">
													<option disabled value="0">
														<span v-if="modelVillagesStat === 'loading'">Mohon tunggu...</span>
														<span v-else>Silahkan pilih kelurahan</span>
													</option>
													<option v-for="(villages, index) in modelVillages" :value="villages.id"
														:key="index">{{villages.name}}</option>
												</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_villages')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_villages') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- alamat -->
									<div class="col-md-8">
										<div class="form-group" :class="{'has-error' : errors.has('form.alamat')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.alamat')}">
												<i class="icon-cross2" v-if="errors.has('form.alamat')"></i>
												Alamat: <wajib-badge></wajib-badge>
											</h5>

											<!-- text -->
											<Field name="alamat" rules="required|min:5" v-model="form.alamat"
												v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan alamat" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.alamat')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.alamat') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- lat -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5>Koordinat garis lintang (latitude):</h5>

											<!-- text -->
											<input type="text" name="lat" class="form-control" placeholder="Silahkan masukkan koordinat garis lintang" data-vv-as="Latitude" v-model="form.lat">

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- lng -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5>Koordinat garis bujur (longitude):</h5>

											<!-- text -->
											<input type="text" name="lng" class="form-control" placeholder="Silahkan masukkan koordinat garis bujur" data-vv-as="Longitude" v-model="form.lng">

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- informasi kontak -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">3. Kontak</h5>
							</div>
							<div class="card-body">
								<div class="row">

									<!-- no telp -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.telp')}">
												<i class="icon-cross2" v-if="errors.has('form.telp')"></i>
												No. Telp:</h5>

											<!-- text -->
											<cleave 
												v-model="form.telp" 
												class="form-control" 
												:options="cleaveOption.number12"
												placeholder="Silahkan masukkan no telp"></cleave>

											<!-- error message -->
											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- no hp -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.hp')}">
												<i class="icon-cross2" v-if="errors.has('form.hp')"></i>
												No. Hp:</h5>

											<!-- text -->
											<cleave 
												v-model="form.hp" 
												class="form-control" 
												:options="cleaveOption.number12"
												placeholder="Silahkan masukkan no hp"></cleave>

											<!-- error message -->
											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- kode pos -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.pos')}">
												<i class="icon-cross2" v-if="errors.has('form.pos')"></i>
												Kode Pos:</h5>

											<!-- text -->
											<cleave 
												v-model="form.pos" 
												class="form-control" 
												:options="cleaveOption.number12"
												placeholder="Silahkan masukkan kode pos"></cleave>

											<!-- error message -->
											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- email -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.email')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.email')}">
												<i class="icon-cross2" v-if="errors.has('form.email')"></i>
												E-mail:</h5>

											<!-- text -->
											<Field name="email" rules="email" v-model="form.email" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan alamat e-mail" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.email')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.email') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

								</div>	
							</div>
						</div>

						<!-- informasi tambahan -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">4. Informasi Tambahan</h5>
							</div>
							<div class="card-body">
								<div class="row">

									<!-- deskripsi -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Informasi Tambahan:</h5>

											<!-- textarea -->
											<textarea rows="5" type="text" name="deskripsi" class="form-control" v-model="form.deskripsi" placeholder="Silahkan masukkan informasi tambahan"></textarea>

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- form info -->
						<form-info></form-info>

						<!-- form button -->
						<div class="card card-body">
							<form-button
								:cancelState="'methods'"
								:formValidation="'form'"
								@cancelClick="back"></form-button>
						</div>

					</form>

					</VeeForm>
				</div>
			</div>
		</div>

		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :color="modalColor" @batal="modalTutup" @tutup="modalTutup" @successOk="modalTutup" @failOk="modalTutup"  @backgroundClick="modalBackgroundClick">
		</app-modal>

	</div>
</template>

<script>
	import { mapState } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useTpStore } from '../../stores/tp';
	import { useCuStore } from '../../stores/cu';
	import { useProvincesStore } from '../../stores/provinces';
	import { useRegenciesStore } from '../../stores/regencies';
	import { useDistrictsStore } from '../../stores/districts';
	import { useVillagesStore } from '../../stores/villages';
	import pageHeader from "../../components/pageHeader.vue";
	import { toMulipartedForm } from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import Cleave from 'vue-cleave-component';
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import DatePicker from "../../components/datePicker.vue";
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		components: {
			pageHeader,
			appModal,
			appImageUpload,
			message,
			formButton,
			formInfo,
			Cleave,
			infoIcon,
			wajibBadge,
			DatePicker,
			VeeForm,
			Field,
		},
		data() {
			return {
				tpStore: useTpStore(),
				cuStore: useCuStore(),
				provincesStore: useProvincesStore(),
				regenciesStore: useRegenciesStore(),
				districtsStore: useDistrictsStore(),
				villagesStore: useVillagesStore(),
				title: '',
				titleDesc: '',
				titleIcon: '',
				kelas: 'tp',
				level2Title: 'TP/KP',
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
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				submited: false,
			}
		},
		beforeRouteEnter(to, from, next) {
			next(vm => vm.fetch());
		},
		watch: {
			currentUserStat(value){ //jika refresh halaman maka reload currentUser
				if(value === "success"){
					if(this.currentUser.id_cu === 0){
						if(this.modelCuStat != 'success'){
							this.cuStore.getHeader();
						}
					}
					if(this.$route.meta.mode !== 'edit' && this.form.id_cu == undefined){
						this.form.id_cu = this.currentUser.id_cu;
					}

					// check permission
					if(this.$route.meta.mode === 'edit'){
						if(!this.currentUser.can || !this.currentUser.can['update_' + this.kelas]){
							this.$router.push({name: 'notFound'});
						}
					}else{
						if(!this.currentUser.can || !this.currentUser.can['create_' + this.kelas]){
							this.$router.push({name: 'notFound'});
						}
					}
				}
			},
			formStat(value){
				if(value === "success"){
					if(this.$route.meta.mode === 'edit'){
						this.changeProvinces(this.form.id_provinces);
						this.changeRegencies(this.form.id_regencies);
						this.changeDistricts(this.form.id_districts);
						this.checkUser('update_tp',this.form.id_cu);
					}else{
						this.form.id_cu = this.currentUser.id_cu;
					}
				} 
			},
			updateStat(value){
				this.modalShow = true;
				this.modalState = value;
				this.modalColor = '';

				if(value === "success"){
					this.modalTitle = this.updateResponse.message;
				}else{
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.updateResponse;
				}
			}
    },
		methods: {
			fetch(){
				if(this.$route.meta.mode === 'edit'){
					this.tpStore.edit(this.$route.params.id);	
					this.title = 'Ubah ' + this.level2Title;
					this.titleDesc = 'Mengubah ' + this.level2Title;
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah ' + this.level2Title;
					this.titleDesc = 'Menambah ' + this.level2Title;
					this.titleIcon = 'icon-plus3';
					this.tpStore.create();
				}

				this.provincesStore.get();
			},
			checkUser(permission,id_cu){
				if(this.currentUser){
					if(!this.currentUser.can || !this.currentUser.can[permission]){
						this.$router.push('/notFound');
					}
					if(!id_cu || this.currentUser.id_cu){
						if(this.currentUser.id_cu != 0 && this.currentUser.id_cu != id_cu){
							this.$router.push('/notFound');
						}
					}
				}
			},
			onValid(values) {
				const payload = { ...this.form, ...values };
				const formData = toMulipartedForm(payload, this.$route.meta.mode);
				if (this.$route.meta.mode === 'edit') {
					this.tpStore.update([this.$route.params.id, formData]);
				} else {
					this.tpStore.store(formData);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			back(){
				if(this.$route.meta.mode === 'edit' && this.currentUser.id_cu == 0){
						this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
				}else{
					if(this.form.id_cu == '0'){
						this.$router.push({name: this.kelas + 'Cu', params:{cu: 'semua'}});
					}else{
						this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu}});
					}
				}
			},
			changeProvinces(id){
				this.regenciesStore.getProvinces(id);
			},
			changeRegencies(id){
				this.districtsStore.getRegencies(id);
			},
			changeDistricts(id){
				this.villagesStore.getDistricts(id);
			},
			modalTutup() {
 				if(this.updateStat === 'success'){
					this.back();
				}

				this.modalShow = false;
				this.submitedKategori = false;
				this.submitedPenulis = false;
			},
			modalBackgroundClick(){
				if(this.modalState === 'success'){
					this.modalTutup;
				}else if(this.modalState === 'loading'){
					// do nothing
				}else{
					this.modalShow = false
				}
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useTpStore, {
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'updateData',
				updateStat: 'updateStat'
			}),
			...mapState(useCuStore, {
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
			}),
			...mapState(useProvincesStore, {
				modelProvinces: 'dataS',
				modelProvincesStat: 'dataStatS'
			}),
			...mapState(useRegenciesStore, {
				modelRegencies: 'dataS',
				modelRegenciesStat: 'dataStatS'
			}),
			...mapState(useDistrictsStore, {
				modelDistricts: 'dataS',
				modelDistrictsStat: 'dataStatS'
			}),
			...mapState(useVillagesStore, {
				modelVillages: 'dataS',
				modelVillagesStat: 'dataStatS'
			}),
		}
	}
</script>