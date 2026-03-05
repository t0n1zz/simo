<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<!-- message -->
					<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
					</message>

					<!-- main panel -->
					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
					<form @submit.prevent="handleSubmit(onValid)">

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

											<!-- text -->
											<Field
												name="name"
												rules="required"
												v-model="form.name"
												v-slot="{ field }"
											>
												<input
													type="text"
													class="form-control"
													placeholder="Silahkan masukkan nama"
													v-bind="field"
												>
												</input>
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
											<textarea rows="5" type="text" name="deskripsi" class="form-control" placeholder="Silahkan masukkan keterangan" v-model="form.deskripsi"></textarea>

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
	import { useJenisDiklatStore } from '../../stores/jenisDiklat';
	import { useCuStore } from '../../stores/cu';
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';
	import pageHeader from "../../components/pageHeader.vue";
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from "../../components/wajibBadge.vue";

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
				jenisDiklatStore: useJenisDiklatStore(),
				cuStore: useCuStore(),
				title: 'Tambah Jenis diklat',
				titleDesc: 'Menambah jenis diklat baru',
				titleIcon: 'icon-plus3',
				kelas: 'jenisDiklat',
				level2Title: 'Jenis Diklat',
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
						this.checkUser('update_jenis_diklat',this.form.id_cu);
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
					this.jenisDiklatStore.edit(this.$route.params.id);	
					this.title = 'Ubah jenis diklat';
					this.titleDesc = 'Mengubah jenis diklat';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah jenis diklat';
					this.titleDesc = 'Menambah jenis diklat';
					this.titleIcon = 'icon-plus3';
					this.jenisDiklatStore.create();
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
			onValid(values) {
				const payload = {
					...this.form,
					...values,
				};

				if (this.$route.meta.mode == 'edit') {
					this.jenisDiklatStore.update(this.$route.params.id, payload);
				} else {
					this.jenisDiklatStore.store(payload);
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
		...mapState(useAuthStore, {
			currentUser: 'currentUser'
		}),
		...mapState(useJenisDiklatStore, {
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
		})
	}	}
</script>