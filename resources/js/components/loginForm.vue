<template>
	<div>

		<message v-if="message.show" :title="'Oops terjadi kesalahan'" :errorData="message.content" :showDebug="false">
		</message>

		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">

		<message v-if="errors.any() && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
		</message>

		<div class="text-center mb-3">
			<h5 class="mb-0">SIMO</h5>
			<span class="d-block text-muted">Sistem Informasi Manajemen Organisasi</span>
		</div>

		<form @submit.prevent="setValues(form) || handleSubmit(onValid)">

			<div class="form-group form-group-feedback form-group-feedback-right" >
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text" :class="{'alpha-danger border-danger text-danger' : errors.has('form.username')}">
							<i class="icon-user"></i>
						</div>
					</div>

					<Field name="username" rules="required|min:5" v-model="form.username" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Username" v-bind="field" :class="{'border-danger' : errors.has('form.username')}" autofocus>
					</Field>
				</div>

				<div class="form-control-feedback text-danger" v-if="errors.has('form.username')">
					<i class="icon-cancel-circle2"></i>
				</div>
			</div>

			<div class="form-group form-group-feedback form-group-feedback-right">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text" :class="{'alpha-danger border-danger text-danger' : errors.has('form.password')}">
							<i class="icon-lock2"></i>
						</div>
					</div>
					<Field name="password" rules="required" v-model="form.password" v-slot="{ field }">
						<input type="password" class="form-control" placeholder="Password" v-bind="field" :class="{'border-danger' : errors.has('form.password')}">
					</Field>
				</div>

				<div class="form-control-feedback text-danger" v-if="errors.has('form.password')">
					<i class="icon-cancel-circle2"></i>
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

		</VeeForm>

	</div>
</template>

<script type="text/javascript">
	import { login } from "../helpers/auth.js";
	import Token from '../helpers/token.js';
	import Message from "../components/message.vue";
	import { useAuthStore } from '../stores/auth';
	import { Field } from 'vee-validate';
	import VeeForm from './VeeForm.vue';
	export default {
		props:['mode'],
		components: {
			Message,
			VeeForm,
			Field
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
			onValid(values) {
				this.message.show = false;
				this.loadingState = 'loading';
				useAuthStore().login();

				login(this.form)
					.then((res) => {
						if(Token.isValid(res.access_token)){
							this.loadingState = 'success';
							useAuthStore().loginSuccess(res);

							let self = this;
							if(this.mode == 'loginPage'){
								setTimeout(function(){
										self.$router.push(self.$router.history.current.query.redirect || '/');
								}, 300);
							}

							// const token = Token.payload(res.access_token);
							// this.$store.commit('auth/setTokenExp', token.exp);
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
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
		}
	}
</script>