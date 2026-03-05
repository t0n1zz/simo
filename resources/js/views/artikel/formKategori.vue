<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">
			<form @submit.prevent="setValues(form) || handleSubmit(onValid)">

				<!-- message -->
				<message v-if="errors.any('form') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
				</message>

				<!-- name -->
				<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('form.name')}">
						<i class="icon-cross2" v-if="errors.has('form.name')"></i>
						Nama: <wajib-badge></wajib-badge>
					</h5>

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
							placeholder="Silahkan masukkan name kategori"
							v-bind="field"
						>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;
					</small>
				</div>

				<!-- keterangan -->
				<div class="form-group">

					<!-- title -->
					<h5>
						Keterangan:
					</h5>

					<!-- textarea -->
					<textarea rows="5" type="text" name="deskripsi" class="form-control" placeholder="Silahkan masukkan keterangan kategori" v-model="form.deskripsi"></textarea>

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
	import { useArtikelKategoriStore } from '../../stores/artikelKategori';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props:['id_cu'],
		components: {
			message,
			formButton,
			formInfo,
			wajibBadge,
			VeeForm,
			Field,
		},
		data() {
			return {
				artikelKategoriStore: useArtikelKategoriStore(),
				kelas: 'artikelKategori',
				form: {
					id_cu: '',
					name: '',
					deskripsi: ''
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
					id_cu: this.id_cu,
				};
				this.artikelKategoriStore.store(payload);
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