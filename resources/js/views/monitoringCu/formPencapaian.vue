<template>
	<div>
		<VeeForm :form="formDataLanjut" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">
		<form @submit.prevent="setValues(formDataLanjut) || handleSubmit(onValid)">

		<!-- message -->
		<message v-if="message.show" @close="messageClose" :title="'Oops terjadi kesalahan'" :errorData="message.content" :showDebug="false">
		</message>

		<div class="row">

			<!-- pencapaian -->
			<div class="col-md-6" v-if="mode != 'catatan'">
				<div class="form-group">

					<!-- title -->
					<h6>Pencapaian:</h6>

					<!-- text -->
					<textarea rows="3" cols="3" class="form-control" placeholder="Silahkan masukkan pencapaian" v-model="formDataLanjut.pencapaian"></textarea>

				</div>
			</div>

			<!-- bukti -->
			<div class="col-md-6" v-if="mode != 'catatan'">
				<div class="form-group">

					<!-- title -->
					<h6>Bukti-bukti:</h6>

					<!-- text -->
					<textarea rows="3" cols="3" class="form-control" placeholder="Silahkan masukkan bukti" v-model="formDataLanjut.bukti"></textarea>

				</div>
			</div>

			<!-- kendala -->
			<div class="col-md-6" v-if="mode != 'catatan'">
				<div class="form-group">

					<!-- title -->
					<h6>Kendala:</h6>

					<!-- text -->
					<textarea rows="3" cols="3" class="form-control" placeholder="Silahkan masukkan kendala" v-model="formDataLanjut.kendala"></textarea>

				</div>
			</div>

			<!-- tindak -->
			<div class="col-md-6" v-if="mode != 'catatan'">
				<div class="form-group">

					<!-- title -->
					<h6>Tindak Lanjut:</h6>

					<!-- text -->
					<textarea rows="3" cols="3" class="form-control" placeholder="Silahkan masukkan tindak lanjut" v-model="formDataLanjut.tindak"></textarea>

				</div>
			</div>

			<!-- tindak -->
			<div class="col-md-12" v-if="mode != 'catatan'">
				<div class="form-group">

					<!-- title -->
					<h6>Upload Foto:</h6>

						<!-- imageupload -->
						<app-image-upload :image_loc="'/images/monitoring/'" :image_temp="formDataLanjut.gambar" v-model="formDataLanjut.gambar"></app-image-upload>

				</div>
			</div>

			<!-- tindak -->
			<div class="col-md-12" v-if="mode == 'catatan'">
				<div class="form-group">

					<!-- title -->
					<h6>Catatan Pemeriksa:</h6>

					<!-- text -->
					<textarea rows="3" cols="3" class="form-control" placeholder="Silahkan masukkan catatan" v-model="formDataLanjut.catatan"></textarea>

				</div>
			</div>

		</div>

		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formDataLanjut.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formDataLanjut.cu_id == ''">
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
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useMonitoringPencapaianCuStore } from '../../stores/monitoringPencapaianCu';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import appImageUpload from '../../components/ImageUpload.vue';
	import { toMulipartedForm } from '../../helpers/form';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props: ['mode','selected'],
		components: {
			checkValue,
			Message,
			wajibBadge,
			appImageUpload,
			VeeForm,
		},
		data() {
			return {
				title: '',
				kelas: 'monitoringPencapaianCu',
				formDataLanjut:{
					id: '',
					id_user: '',
					id_monitoring: '',
					pencapaian: '',
					bukti: '',
					kendala: '',
					tindak: '',
					catatan: '',
					gambar: '',
				},
				message: {
					show: false,
					content: ''
				},
				submited: false,
			}
		},
		created(){
			if(this.mode != 'create'){
				this.formDataLanjut = Object.assign({},this.selected);
			}
		},
		watch: {},
		methods: {
			...mapActions(useMonitoringPencapaianCuStore, ['store', 'update']),
			save(){
				this.formDataLanjut.id_monitoring_cu = this.$route.params.id;
				// Trigger form submit which VeeForm handles
			},
			onValid() {
				this.formDataLanjut.id_monitoring_cu = this.$route.params.id;
				const formData = toMulipartedForm(this.formDataLanjut, this.$route.meta.mode);
				if (this.mode == 'create') {
					this.store(formData);
				} else {
					this.update([this.formDataLanjut.id, formData]);
				}
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
			},
			messageClose(){
				this.message.show = false;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
		}
	}
</script>