<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

				<!-- main panel: rules on the tag via Field, no schema -->
				<VeeForm :form="form" v-slot="{ errors, handleSubmit }">

					<!-- message -->
					<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
					</message>

					<form @submit.prevent="handleSubmit(onValid, onInvalid)">

							<!-- main form -->
							<div class="card">
								<div class="card-body">
									<div class="row">

										<!-- name: rule on the tag -->
										<div class="col-md-12">
											<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

												<h5 :class="{ 'text-danger' : errors.has('form.name')}">
													<i class="icon-cross2" v-if="errors.has('form.name')"></i>
													Nama: <wajib-badge></wajib-badge></h5>

												<Field name="name" rules="required" v-model="form.name" v-slot="{ field }">
													<input type="text" class="form-control" placeholder="Silahkan masukkan nama" v-bind="field">
												</Field>

												<small class="text-muted text-danger" v-if="errors.has('form.name')">
													<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
												</small>
												<small class="text-muted" v-else>&nbsp;</small>
											</div>
										</div>

										<!-- deskripsi (no validation) -->
										<div class="col-md-12">
											<div class="form-group">
												<h5>Keterangan:</h5>
												<textarea rows="5" type="text" name="deskripsi" class="form-control" placeholder="Silahkan masukkan keterangan" v-model="form.deskripsi"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>

							<form-info></form-info>
							<br/>

							<div class="panel panel-flat panel-body">
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
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useKeahlianStore } from '../../stores/keahlian';
	import { useCuStore } from '../../stores/cu';
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';
	import pageHeader from '../../components/pageHeader.vue';
	import appModal from '../../components/modal.vue';
	import message from '../../components/message.vue';
	import formButton from '../../components/formButton.vue';
	import formInfo from '../../components/formInfo.vue';
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
				title: 'Tambah Keahlian',
				titleDesc: 'Menambah keahlian baru',
				titleIcon: 'icon-plus3',
				kelas: 'keahlian',
				level2Title: 'Keahlian',
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
				if(this.modelCuStat != 'success'){
					this.getHeader();
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
						this.checkUser('update_keahlian',this.form.id_cu);
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
			...mapActions(useKeahlianStore, ['create', 'store', 'edit', 'update', 'resetUpdateStat']),
			...mapActions(useCuStore, ['getHeader']),
			fetch(){
				if(this.$route.meta.mode === 'edit'){
					this.edit(this.$route.params.id);	
					this.title = 'Ubah Keahlian';
					this.titleDesc = 'Mengubah Keahlian';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah Keahlian';
					this.titleDesc = 'Menambah Keahlian';
					this.titleIcon = 'icon-plus3';
					this.create();
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
					this.update([this.$route.params.id, this.form]);
				} else {
					this.store(this.form);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			back(){
				this.$router.push({name: this.kelas});
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
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useKeahlianStore,{
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'update',
				updateStat: 'updateStat'
			}),
			...mapState(useCuStore,{
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
			}),
		},
	}
</script>