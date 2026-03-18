<template>
	<div>
		<VeeForm :form="formJenisDiklat" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">

			<div class="form-group">

				<!-- title -->
				<h5>
					Jenis Diklat:
				</h5>

				<div class="input-group">

					<!-- select -->
					<Field name="formJenisDiklat.jenis_diklat_id" rules="required" v-model="formJenisDiklat.jenis_diklat_id" v-slot="{ field }">
						<select class="form-control" data-width="100%" v-bind="field" :disabled="modelJenisDiklat.length === 0" @change="changeJenisDiklat($event.target.value)">
							<option disabled value="">
								<span v-if="modelJenisDiklatStat === 'loading'">Mohon tunggu...</span>
								<span v-else>Silahkan pilih jenis diklat</span>
							</option>
							<template v-for="jenisDiklat in modelJenisDiklat" :key="jenisDiklat ? jenisDiklat.id : undefined">
								<option v-if="jenisDiklat" :value="jenisDiklat.id">
									{{ jenisDiklat.name }}
								</option>
							</template>
						</select>
					</Field>

				</div>

		</div>

		<!-- message -->
		<message v-if="errors.any('formJenisDiklat') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
		</message>
		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formJenisDiklat.jenis_diklat_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formJenisDiklat.jenis_diklat_id == ''">
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
	import { useJenisDiklatStore } from '../../stores/jenisDiklat';
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
		setup() {
			return {
				authStore: useAuthStore(),
			jenisDiklatStore: useJenisDiklatStore(),
			};
		},
		data() {
			return {title: '',
				formJenisDiklat: {
					id: '',
					jenis_diklat_id: '',
					name: '',
					deskripsi: '',
				},
				submited: false,
			};
		},
		created() {
			this.jenisDiklatStore.get();
			if (this.mode === 'edit') {
				this.formJenisDiklat = Object.assign({}, this.selected);
			}
		},
		methods: {
			onValid() {
				if (this.mode === 'edit') {
					this.$emit('editJenisDiklat', this.formJenisDiklat);
				} else {
					this.$emit('createJenisDiklat', this.formJenisDiklat);
				}
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
			},
			changeJenisDiklat(value) {
				const valJenisDiklat = _.find(this.modelJenisDiklat, { id: Number(value) });
				if (valJenisDiklat) {
					this.formJenisDiklat.name = valJenisDiklat.name;
					this.formJenisDiklat.deskripsi = valJenisDiklat.deskripsi;
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
			modelJenisDiklat() {
				return this.jenisDiklatStore.dataS;
			},
			modelJenisDiklatStat() {
				return this.jenisDiklatStore.dataStatS;
			},
		},
	}
</script>