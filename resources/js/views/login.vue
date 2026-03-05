<template>
	<div class="page-content">
		<!-- Page content -->
		<div class="content-wrapper">
			<!-- Main content -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- login form -->
				<div class="login-form">

					<message v-if="message.show" :title="'Oops terjadi kesalahan'" :errorData="message.content" :showDebug="false">
					</message>

					<div v-if="isInactivityLogout" class="alert alert-info mb-3">
						Anda telah logout karena tidak ada aktivitas. Silakan login kembali.
					</div>

					<!-- VeeValidate errors removed - will implement in Phase 5 -->
				
					<div class="card card-body mb-0">
						<div class="text-center mb-3">
							<h5 class="mb-0">SIMO</h5>
							<span class="d-block text-muted">Sistem Informasi Manajemen Organisasi</span>
						</div>

						<form @submit.prevent="submit">

							<div class="form-group form-group-feedback form-group-feedback-right" >
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="icon-user"></i>
										</div>
									</div>
									
									<input type="text" class="form-control" name="Username" placeholder="Username" v-model="form.username" autofocus>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-right">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="icon-lock2"></i>
										</div>
									</div>
									<input type="password" class="form-control" name="Password" placeholder="Password" v-model="form.password">
								</div>
							</div>

							<div class="form-group">
								<button type="button" class="btn btn-primary btn-block" disabled v-if="loadingState == 'loading'">
									<i class="icon-spinner2 spinner"></i>
								</button>
								<button type="button" class="btn btn-success btn-block" disabled v-else-if="loadingState == 'success'">
									<i class="icon-checkmark3"></i>
								</button>
								<button type="submit" class="btn btn-primary btn-block" v-else>Login
									<i class="icon-circle-right2 position-right"></i>
								</button>
							</div>

						
						</form>

					</div>
				</div>
				
				
				<!-- /simple login form -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
</template>

<script>
	import { useAuthStore } from '../stores/auth';
	import { login } from "../helpers/auth.js";
	import Message from "../components/message.vue";
	
	export default {
		components: {
			Message
		},
		data() {
			return {
				form: {
					username: "",
					password: "",
				},
				loadingState: '',
				submited: '',
				message: {
					show: false,
					content: ''
				}
			}
		},
		methods: {
			submit() {
				this.message.show = false;
				const authStore = useAuthStore();
				
				// Basic validation (VeeValidate will be added in Phase 5)
				if (!this.form.username || !this.form.password) {
					this.message.show = true;
					this.message.content = 'Username and password are required';
					return;
				}
				
				this.loadingState = 'loading';
				authStore.login();

				login(this.form)
					.then((res) => {
						// Sanctum tokens are plain text, not JWT - no validation needed
						if(res.access_token){
							this.loadingState = 'success';
							authStore.loginSuccess(res);
							
							let self = this;
							setTimeout(function(){
								if(self.$route.name == 'loginRedirect'){
									self.$router.push(self.redirect);
								}else{
									self.$router.push(self.$route.query.redirect || '/');
								}
							}, 300);
						}else{
							this.message.show = true;
							this.message.content = 'Token tidak valid';
							this.loadingState = 'fail';
						}
					})
					.catch((error) => {
						this.message.show = true;
						this.message.content = error;
						this.loadingState = 'fail';
					});

				this.submited = false;
			},
		},
		computed: {
			redirect() {
				const authStore = useAuthStore();
				return authStore.getRedirect;
			},
			isInactivityLogout() {
				return this.$route.query.reason === 'inactivity';
			}
		}
	}
</script>