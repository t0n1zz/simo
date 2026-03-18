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
						<form @submit.prevent="handleSubmit(onValid)">

						<!-- main form -->
						<div class="card">
							<div class="card-body">
								<div class="row">

									<div class="col-md-12">
										<div class="form-group mb-0" :class="{'has-error' : errors.has('form.id_surat_kode')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_surat_kode')}">
												<i class="icon-cross2" v-if="errors.has('form.id_surat_kode')"></i>
												Tipe Surat: <wajib-badge></wajib-badge>
											</h5>

											<div class="input-group">

												<!-- select -->
												<Field name="id_surat_kode" rules="required" v-model="form.id_surat_kode"
													v-slot="{ field }">
													<select class="form-control" data-width="100%" v-bind="field"
														@change="changeKode($event.target.value)">
														<option disabled value="">
															<span>
																<span v-if="formStat === 'loading'">Mohon tunggu...</span>
																<span v-else>Silahkan pilih tipe surat</span>
															</span>
														</option>
														<template v-for="kode in modelKode" :key="kode ? kode.id : undefined">
															<option v-if="kode" :value="kode.id">
																{{kode.name}} / {{kode.periode}} / No. {{kode.kode}}
															</option>
														</template>
													</select>
												</Field>

											</div>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_surat_kode')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_surat_kode') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- name -->
									<div class="col-md-12">
										<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.name')}">
												<i class="icon-cross2" v-if="errors.has('form.name')"></i>
												Kode: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="name" rules="required" v-model="form.name" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan kode" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.name')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- deskripsi -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>
												Keterangan:
											</h5>

											<!-- textarea -->
											<textarea rows="5" type="text" name="deskripsi" class="form-control" placeholder="Silahkan masukkan keterangan kategori" v-model="form.deskripsi"></textarea>

										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- form info -->
						<form-info></form-info>
						<br />

						<!-- form button -->
						<div class="panel panel-flat panel-body">
							<form-button :cancelState="'methods'" :formValidation="'form'"
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
	import { useSuratKategoriStore } from '../../stores/suratKategori';
	import { useSuratKodeStore } from '../../stores/suratKode';
	import { useCuStore } from '../../stores/cu';
	import pageHeader from "../../components/pageHeader.vue";
	import { toMulipartedForm } from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import Cleave from 'vue-cleave-component';
	import infoIcon from "../../components/infoIcon.vue";
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
			wajibBadge,
			Cleave,
			infoIcon,
			VeeForm,
			Field,
		},
		setup() {
			return {
				suratKategoriStore: useSuratKategoriStore(),
			suratKodeStore: useSuratKodeStore(),
			cuStore: useCuStore(),
			};
		},
		data() {
			return {title: 'Tambah Kategori Surat',
				titleDesc: 'Menambah kategori surat keluar baru',
				titleIcon: 'icon-plus3',
				kelas: 'suratKategori',
				level2Title: 'Kategori Surat',
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				submited: false,
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
					},
					year:{
            date: true,
            datePattern: ['Y'],
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
			}
		},
		beforeRouteEnter(to, from, next) {
			next(vm => vm.fetch());
		},
		created(){
			if(this.currentUser.id_cu == 0){
				if(this.modelCuStat != 'success'){
					this.cuStore.getHeader();
				}
			}
			this.form.id_cu = this.currentUser.id_cu;
		},
		watch: {
			formStat(value){
				if(value === "success"){
					if(this.$route.meta.mode !== 'edit'){
						this.form.id_cu = this.currentUser.id_cu;
					}else{
						this.checkUser('update_surat',this.form.id_cu);
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
			onValid(values) {
				const payload = {
					...this.form,
					...values,
					id_cu: this.currentUser.id_cu,
				};
				if (this.$route.meta.mode == 'edit') {
					this.suratKategoriStore.update([this.$route.params.id, payload]);
				} else {
					this.suratKategoriStore.store(payload);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			fetch(){
				if(this.$route.meta.mode === 'edit'){
					this.suratKategoriStore.edit(this.$route.params.id);	
					this.title = 'Ubah Kategori Surat Keluar';
					this.titleDesc = 'Mengubah kategori surat keluar';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah Kategori Surat Keluar';
					this.titleDesc = 'Menambah kategori surat keluar';
					this.titleIcon = 'icon-plus3';
					this.suratKategoriStore.create();
					this.suratKodeStore.get();
				}
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
			back(){
				this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu}});
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
			},
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useSuratKategoriStore, {
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'updateData',
				updateStat: 'updateStat'
			}),
			...mapState(useSuratKodeStore, {
				modelKode: 'dataS',
				modelKodeStat: 'dataStatS',
			}),
			...mapState(useCuStore, {
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
			})
		}
	}
</script>