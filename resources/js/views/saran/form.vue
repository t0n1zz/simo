<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
			<form @submit.prevent="handleSubmit(onValid)">

				<div class="alert bg-info alert-styled-left mt-2 pt-1 pb-1">
					<p>Silahkan memberikan saran dan masukan kepada kami sesuai dengan tujuan bidang. Terima Kasih.</p>
				</div>

				<!-- message -->
				<message v-if="errors.any('form') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
				</message>

				<div class="form-group" :class="{'has-error' : errors.has('form.bidang')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('form.bidang')}">
						<i class="icon-cross2" v-if="errors.has('form.bidang')"></i>
						Silahkan memilih ingin memberikan saran kemana: <wajib-badge></wajib-badge>
					</h5>

					<!-- select -->
					<Field
						name="bidang"
						rules="required"
						v-model="form.bidang"
						v-slot="{ field }"
					>
						<select
							class="form-control"
							data-width="100%"
							v-bind="field"
						>
							<option disabled value="">Silahkan pilih bidang</option>
							<option disabled value="">----------------</option>
							<option value="organsiasi">Organisasi</option>
							<option value="pemberdayaan">Pemberdayaan</option>
							<option value="tataKelola">Tata Kelola</option>
							<option value="teknologiInformasi">Teknologi Informasi</option>
							<option value="usaha">Usaha</option>
						</select>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.bidang')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.bidang') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>

				<!-- content -->
				<div class="form-group" :class="{'has-error' : errors.has('form.content')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('form.content')}">
						<i class="icon-cross2" v-if="errors.has('form.content')"></i>
						Saran:
					</h5>

					<!-- textarea -->
					<Field
						name="content"
						rules="required|min:5"
						v-model="form.content"
						v-slot="{ field }"
					>
						<textarea
							rows="5"
							type="text"
							class="form-control"
							placeholder="Silahkan masukkan saran anda"
							v-bind="field"
						></textarea>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.content')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.content') }}
					</small>
					<small class="text-muted" v-else>&nbsp;
					</small>
				</div>

				<hr>
				<form-button
					:cancelTitle="cancelTitle"
					:cancelIcon="cancelIcon"
					:cancelState="cancelState"
					:formValidation="'form'"
					@cancelClick="cancelClick"></form-button>

			</form>
		</VeeForm>

	</div>
</template>

<script>
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import { useSaranStore } from '../../stores/saran';
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		props: ['id_user'],
		components: {
			message,
			formButton,
			VeeForm,
			Field,
		},
		setup() {
			return {
				saranStore: useSaranStore(),
			};
		},
		data() {
			return {kelas: 'saran',
				form: {
					id_user: '',
					content: '',
					bidang: ''
				},
				submited: false,
				cancelTitle: 'Tutup',
				cancelIcon: 'icon-cross',
				cancelState: 'methods'
			}
		},
		methods: {
			onValid(values) {
				const payload = {
					...this.form,
					...values,
					id_user: this.id_user,
				};
				this.saranStore.store(payload);
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			cancelClick(){
				this.$emit('cancelClick');
			}
		}
	}
</script>