<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<!-- main panel: VeeForm + Field rules (no schema) -->
					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">

						<!-- message -->
						<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
						</message>

						<form @submit.prevent="setValues(form) || handleSubmit(onValid)">

							<!-- main form -->
							<div class="card">
								<div class="card-body">
									<div class="row">

										<!-- name -->
										<div class="col-md-12">
											<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

												<!-- title -->
												<h5 :class="{ 'text-danger' : errors.has('form.name')}">
													<i class="icon-cross2" v-if="errors.has('form.name')"></i>
													Nama: <wajib-badge></wajib-badge></h5>

												<!-- text (rules on the tag) -->
												<Field
													name="name"
													rules="required|min:5"
													v-model="form.name"
													v-slot="{ field }"
												>
													<input
														type="text"
														class="form-control"
														placeholder="Silahkan masukkan nama kategori artikel"
														v-bind="field"
													>
												</Field>

												<!-- error message -->
												<small class="text-muted text-danger" v-if="errors.has('form.name')">
													<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
												</small>
												<small class="text-muted" v-else>&nbsp;</small>
											</div>
										</div>

										<!-- CU -->
										<div class="col-md-12" v-if="currentUser.id_cu == 0">
											<div class="form-group" :class="{'has-error' : errors.has('form.id_cu')}">

												<!-- title -->
												<h5 :class="{ 'text-danger' : errors.has('form.id_cu')}">
													<i class="icon-cross2" v-if="errors.has('form.id_cu')"></i>
													CU: <wajib-badge></wajib-badge>
												</h5>

												<!-- select -->
												<Field
													as="select"
													name="id_cu"
													rules="required"
													v-model="form.id_cu"
													class="form-control"
													data-width="100%"
													:disabled="modelCU.length === 0"
												>
													<option disabled value="">Silahkan pilih CU</option>
													<option value="0"><span v-if="currentUser.pus">{{currentUser.pus.name}}</span> <span v-else>PUSKOPCUINA</span></option>
													<option disabled value="">----------------</option>
													<option v-for="cu in modelCU" :key="cu.id" :value="cu.id">{{cu.name}}</option>
												</Field>

												<!-- error message -->
												<small class="text-muted text-danger" v-if="errors.has('form.id_cu')">
													<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_cu') }}
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
							<br/>

							<!-- form button -->
							<div class="panel panel-flat panel-body">
								<form-button
									:cancelState="'methods'"
									:formValidation="'form'"
									:buttonErrors="errors"
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
	import { useAuthStore } from '../../stores/auth';
	import { useArtikelKategoriStore } from '../../stores/artikelKategori';
	import { useCuStore } from '../../stores/cu';
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';
	import pageHeader from '../../components/pageHeader.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from '../../components/wajibBadge.vue';

	export default {
		components: {
			pageHeader,
			appModal,
			message,
			formButton,
			formInfo,
			wajibBadge,
			VeeForm,
			Field,
		},
		data() {
			return {
				authStore: useAuthStore(),
				artikelKategoriStore: useArtikelKategoriStore(),
				cuStore: useCuStore(),
				title: 'Tambah Kategori Artikel',
				titleDesc: 'Menambah kategori artikel baru',
				titleIcon: 'icon-plus3',
				kelas: 'artikelKategori',
				level2Title: 'Kategori Artikel',
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
		created(){
			if(this.currentUser.id_cu == 0){
				if(this.modelCUStat != 'success'){
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
						this.checkUser('update_artikel_kategori',this.form.id_cu);
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
					this.artikelKategoriStore.edit(this.$route.params.id);	
					this.title = 'Ubah Kategori Artikel';
					this.titleDesc = 'Mengubah kategori artikel';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah Kategori Artikel';
					this.titleDesc = 'Menambah kategori artikel';
					this.titleIcon = 'icon-plus3';
					this.artikelKategoriStore.create();
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
			onValid() {
				if (this.$route.meta.mode === 'edit') {
					this.artikelKategoriStore.update(this.$route.params.id, this.form);
				} else {
					this.artikelKategoriStore.store(this.form);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			back(){
				if(this.$route.meta.mode == 'edit' && this.currentUser.id_cu == 0){
					this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
				}else{
					if(this.currentUser.id_cu == 0){
						if(this.form.id_cu == 0){
							this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
						}else{
							this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
						}
					}else{
						this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu}});
					}
				}
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

			currentUser() {
				return this.authStore.currentUser;
			},
			form() {
				return this.artikelKategoriStore.data;
			},
			formStat() {
				return this.artikelKategoriStore.dataStat;
			},
			rules() {
				return this.artikelKategoriStore.rules;
			},
			options() {
				return this.artikelKategoriStore.options;
			},
			updateResponse() {
				return this.artikelKategoriStore.updateData;
			},
			updateStat() {
				return this.artikelKategoriStore.updateStat;
			},
			modelCU() {
				return this.cuStore.headerDataS;
			},
			modelCUStat() {
				return this.cuStore.headerDataStatS;
			}
		}
	}
</script>