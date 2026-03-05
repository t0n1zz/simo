<template>
	<div>
		<VeeForm :form="formKeahlian" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">

			<div class="form-group">

				<!-- title -->
				<h5>
					Keahlian:
				</h5>

				<div class="input-group">

					<!-- select -->
					<Field name="formKeahlian.keahlian_id" rules="required" v-model="formKeahlian.keahlian_id" v-slot="{ field }">
						<select class="form-control" data-width="100%" v-bind="field" :disabled="modelKeahlian.length === 0" @change="changeKeahlian($event.target.value)">
							<option disabled value="">
								<span v-if="modelKeahlianStat === 'loading'">Mohon tunggu...</span>
								<span v-else>Silahkan pilih jenis keahlian</span>
							</option>
							<template v-for="keahlian in modelKeahlian" :key="keahlian ? keahlian.id : undefined">
								<option v-if="keahlian" :value="keahlian.id">
									{{ keahlian.name }}
								</option>
							</template>
						</select>
					</Field>

				</div>

		</div>

		<!-- message -->
		<message v-if="errors.any('formKeahlian') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
		</message>
		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formKeahlian.keahlian_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formKeahlian.keahlian_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div>

		</form>
		</VeeForm>

	</div>
</template>

<script>
	import _ from 'lodash';
	import { useAuthStore } from '../../stores/auth';
	import { useKeahlianStore } from '../../stores/keahlian';
	import message from '../../components/message.vue';
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		props: ['mode', 'selected'],
		components: {
			message,
			VeeForm,
			Field,
		},
		data() {
			return {
				authStore: useAuthStore(),
				keahlianStore: useKeahlianStore(),
				title: '',
				formKeahlian: {
					id: '',
					keahlian_id: '',
					name: '',
					deskripsi: '',
				},
				submited: false,
			};
		},
		created() {
			this.keahlianStore.get();
			if (this.mode === 'edit') {
				this.formKeahlian = Object.assign({}, this.selected);
			}
		},
		methods: {
			onValid() {
				if (this.mode === 'edit') {
					this.$emit('editKeahlian', this.formKeahlian);
				} else {
					this.$emit('createKeahlian', this.formKeahlian);
				}
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
			},
			changeKeahlian(value) {
				const valKeahlian = _.find(this.modelKeahlian, { id: Number(value) });
				if (valKeahlian) {
					this.formKeahlian.name = valKeahlian.name;
					this.formKeahlian.deskripsi = valKeahlian.deskripsi;
				}
			},
			tutup() {
				this.$emit('tutup');
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			modelKeahlian() {
				return this.keahlianStore.dataS;
			},
			modelKeahlianStat() {
				return this.keahlianStore.dataStatS;
			},
		},
	}
</script>