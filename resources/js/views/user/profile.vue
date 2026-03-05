<template>
	<div>
		<!-- Page header -->
		<page-header 
		:title="title" 
		:titleDesc="titleDesc" 
		:titleIcon="titleIcon"></page-header>
		
		<!-- page container -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<!-- message -->
					<message v-if="formStat === 'fail'" :title="'Oops terjadi kesalahan:'" :errorData="form">
					</message>

					<div class="nav-tabs-responsive">
						<ul class="nav nav-tabs nav-tabs-solid bg-light">
							<li class="nav-item" v-if="currentUser.id_aktivis">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'riwayat'}" @click.prevent="changeTab('riwayat')"><i class="icon-list2 mr-2"></i> Riwayat</a>
							</li>
							<li class="nav-item" v-if="currentUser.id_aktivis">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'identitas'}" @click.prevent="changeTab('identitas')"><i class="icon-user-tie mr-2"></i> Ubah Identitas</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'aktivitas'}" @click.prevent="changeTab('aktivitas')"><i class="icon-eye2 mr-2"></i> Lihat Aktivitas</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'password'}" @click.prevent="changeTab('password')"><i class="icon-pencil5 mr-2"></i> Ubah Password</a>
							</li>
						</ul>
					</div>

					<br/>

					<transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-show="tabName == 'password'">

							<!-- password -->
							<form @submit.prevent="savePassword">
								<div class="card">

								<div class="card-header bg-white">
										<h6 class="card-title">Ubah Password</h6>
									</div>

									<div class="card-body">
										
										<div class="row">
											<div class="col-lg-12">
												<div class="alert alert-info alert-styled-left">
													<span class="font-weight-semibold">Informasi!</span> Mari menggunakan password dengan tingkat keamanan yang lebih tinggi!! 
													<br/>
													Dimana password anda harus minimal terdiri dari 8 karakter yang mengandung minimal 1 huruf besar, 1 huruf kecil dan 1 angka. 
													<br/>
													Usahakan password anda bukan dari tanggal lahir, alamat, nomor telepon/hp dan dari kata yang sering anda gunakan atau mudah diketahui oleh orang lain.
												</div>
											</div>

											<div class="col-lg-12">	

												<!-- password sekarang -->
												<div class="form-group">

													<!-- title -->
													<h6>
														Password Saat Ini:
														<wajib-badge></wajib-badge>
														<br/>
														<small class="text-muted"><i>Mengisi password lama anda atau yang saat ini anda gunakan untuk login</i></small> 
													</h6>

													<!-- text -->
													<input type="password" name="password_old" class="form-control" placeholder="Silahkan masukkan password" v-model="formPassword.password_old">
												</div>
											</div>
											<div class="col-lg-6">
												<!-- password -->
												<div class="form-group">

													<!-- title -->
													<h6>
														Password Baru: <wajib-badge></wajib-badge>
														<br/>
														<small class="text-muted"><i>Minimal 8 karater yang mengandung minimal 1 huruf besar, 1 huruf kecil dan 1 angka</i></small> 
													</h6>

													<!-- text -->
													<input type="password" name="password" ref="password"  class="form-control" placeholder="Silahkan masukkan password" v-model="formPassword.password">
												</div>
											</div>
											<div class="col-lg-6">
												<!-- password konfirmasi -->
												<div class="form-group">

													<!-- title -->
													<h6>
														Konfirmasi Password:
														<wajib-badge></wajib-badge>
														<br/>
														<small class="text-muted"><i>Mengisi ulang password</i></small>
													</h6>

													<!-- text -->
													<input type="password" name="passwordConfirm" class="form-control" placeholder="Silahkan masukkan password konfirmasi" v-model="formPassword.password_confirm">
												</div>
											</div>
										</div>

										<!-- form info -->
										<form-info></form-info>	

										<div class="text-center d-none d-md-block">
											<button type="submit" class="btn btn-primary">
												<i class="icon-floppy-disk"></i> Simpan</button>
										</div>  

										<!-- tombol mobile-->
										<div class="d-block d-md-none">
											<button type="submit" class="btn btn-primary btn-block pb-2">
												<i class="icon-floppy-disk"></i> Simpan</button>
										</div> 

									</div>
								</div>
							</form>

						</div>
					</transition>

					<transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-if="tabName == 'identitas'">

							<form-identitas :mode="'edit_profile'" :id_aktivis="currentUser.id_aktivis"></form-identitas>
							
						</div>
					</transition>

					<transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-if="tabName == 'riwayat'">

							<form-riwayat 
								:mode="'edit_profile'" 
								:id_aktivis="currentUser.id_aktivis" :id_cu="currentUser.id_cu"
							></form-riwayat>
							
						</div>
					</transition>

					<transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-if="tabName == 'aktivitas'">

							<aktivitas :activity="activity" :activityStat="activityStat" @fetchAktivitas="fetchAktivitas"></aktivitas>
							
						</div>
					</transition>		

				</div>
			</div>
		</div>
		
		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :color="modalColor" @batal="modalTutup" @tutup="modalTutup" @successOk="modalTutup" @failOk="modalTutup"  @backgroundClick="modalTutup">
		</app-modal>

		<!-- modal image -->
		<app-modal-image :show="modalImageShow" :content="modalImageContent" @tutup="modalImageTutup" @backgroundClick="modalImageTutup">
		</app-modal-image>

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import { useUserStore } from '../../stores/user';
	import pageHeader from "../../components/pageHeader.vue";
	import message from "../../components/message.vue";
	import appModal from '../../components/modal.vue';
	import appModalImage from '../../components/modalImage.vue';
	import { toMulipartedForm } from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import aktivitas from "./_component/aktivitas.vue";
	import formIdentitas from "../aktivis/create.vue";	
	import formRiwayat from "../aktivis/riwayatContent.vue";	
	import wajibBadge from "../../components/wajibBadge.vue";
	
	export default {
		name: 'UserIndex',
		components: {
			pageHeader,
			message,
			appModal,
			appModalImage,
			appImageUpload,
			formInfo,
			formButton,
			aktivitas,
			formIdentitas,
			formRiwayat,
			wajibBadge
		},
		data() {
			return {
				authStore: useAuthStore(),
				userStore: useUserStore(),
				title: 'Profile',
				kelas: 'user',
				titleDesc: 'Mengelola data profile',
				titleIcon: 'icon-user',
				selectCuPath: 'userCu',
				tabName: 'riwayat',
				isAktivitas: false,
				formPassword: {},
				formIdentitas: {},
				formFoto: {},
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				modalImageShow: false,
				modalImageContent: '',
				submited: false,
			}
		},
		created(){
			this.formFoto.gambar = this.currentUser.gambar;
			this.formIdentitas.name = this.currentUser.name;
			this.formIdentitas.email = this.currentUser.email;
		},
		watch: {
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
			},
    },
		methods: {
			fetchAktivitas(value){
				this.userStore.getActivity([value, this.currentUser.id]);
			},
			saveIdentitas(){
				// formIdentitas validation is handled inside child component
				this.userStore.updateIdentitas([this.$route.params.id, this.formIdentitas]);
				this.submited = false;
			},
			savePassword(){
				this.userStore.updatePassword([this.$route.params.id, this.formPassword]);
				this.submited = false;
			},
			saveFoto(){
				const formData = toMulipartedForm(this.formFoto, 'edit');
				this.userStore.updateFoto([this.$route.params.id, formData]);
			},
			changeTab(value){
				this.tabName = value;
				if(value == 'aktivitas' && !this.isAktivitas){
					this.isAktivitas = true;
					this.fetchAktivitas(this.params);
				}
			},
			modalImageBuka(content){
				this.modalImageShow = true;
				this.modalImageContent = content;
			},
			modalTutup() {
				this.modalShow = false;
				
				if(this.tabName == 'foto' || this.tabName == 'email'){
					
				}else if(this.tabName == 'password'){
					this.formPasswordReset();		
					this.currentUser.isChangePassword = 1;
				}
			},
			modalImageTutup() {
				this.modalImageShow = false;
			},
			formPasswordReset(){
				this.formPassword.password_old = '';
				this.formPassword.password = '';
				this.formPassword.password_confirm = '';
			}
		},
		computed:{
			currentUser() {
				return this.authStore.currentUser;
			},
			form() {
				return this.userStore.data;
			},
			formStat() {
				return this.userStore.dataStat;
			},
			activity() {
				return this.userStore.dataS;
			},
			activityStat() {
				return this.userStore.dataStatS;
			},
			updateResponse() {
				return this.userStore.updateData;
			},
			updateStat() {
				return this.userStore.updateStat;
			}
		},
	}
</script>