<template>
	<div>
		<VeeForm :form="formTugas" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="handleSubmit(onValid)" enctype="multipart/form-data">
      <!-- nama -->
			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('name')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('name')}">
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('name')"></i>
					Tugas:
				</h5>

				<!-- text -->
				<Field name="name" v-slot="{ field }" :rules="'required'" label="Tugas">
					<input type="text" class="form-control" placeholder="Silahkan masukkan nama" v-bind="field" v-model="formTugas.name">
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('name')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('name') }}
				</small>
				<small class="text-muted" v-else>&nbsp;
				</small>
			</div>

			<!-- keterangan -->
      <div class="form-group">

        <!-- title -->
        <h5> Keterangan: </h5>

        <!-- textarea -->
        <textarea rows="5" type="text" name="keterangan" class="form-control" placeholder="Silahkan masukkan keterangan " v-model="formTugas.keterangan"></textarea>

      </div>


			<!-- tipe -->
			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('tipe')}" v-if="mode == 'create'">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('tipe')}">
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('tipe')"></i>
					Pilih Tipe:
				</h5>

				<!-- select -->
				<Field name="tipe" v-slot="{ field }" :rules="'required'" label="Tipe">
					<select class="form-control" data-width="100%" v-bind="field" v-model="formTugas.tipe">
						<option disabled value="">Silahkan pilih tipe</option>
						<option value="isian">Isian langsung</option>
						<option value="upload">Upload tugas</option>
						<option value="google form">Google form</option>
					</select>
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('tipe')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('tipe') }}
				</small>
				<small class="text-muted" v-else>&nbsp;</small>
			</div>

			<!-- upload -->		
			<template v-if="formTugas.tipe != ''">
				<div class="form-group" v-if="formTugas.tipe == 'google form'">

					<!-- title -->
					<h5>Link google form: </h5>

					<!-- textarea -->
					<input type="text" name="link" class="form-control" placeholder="Silahkan masukkan link" v-model="formTugas.link">
					<small class="text-muted">Silahkan masukkan link ke google form</small>

				</div>

				<div v-else>
					<template v-if="mode == 'create'">
						<h5>
							Dokumen pendukung:
							<br/>
							<small class="text-muted">silahkan diisi apabila ada dokumen pendukung untuk mengerjakan tugas ini</small>
						</h5>

						<!-- format -->
						<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('format')}" v-if="mode == 'create'">

							<!-- title -->
							<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('format')}">
								<i class="icon-cross2" v-if="errors && errors.has && errors.has('format')"></i>
								Pilih Format:
							</h5>

							<!-- select -->
							<Field name="format" v-slot="{ field }" :rules="'required'" label="Format">
								<select class="form-control" data-width="100%" v-bind="field" v-model="formTugas.format">
									<option disabled value="">Silahkan pilih format</option>
									<option value="upload">Upload</option>
									<option value="link">Link</option>
								</select>
							</Field>

							<!-- error message -->
							<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('format')">
								<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('format') }}
							</small>
							<small class="text-muted" v-else>&nbsp;</small>
						</div>

						<div class="form-group" v-if="formTugas.format == 'upload'">
							<!-- title -->
							<h5> Upload dokumen: </h5>

							<!-- textarea -->
							<div class="card-card-body">
								<input type="file" class="form-control" @change="upload" ref="fileInput">
							</div>
						</div>
						<div class="form-group" v-else-if="formTugas.format == 'link'">

							<!-- title -->
							<h5>Link dokumen: </h5>

							<!-- textarea -->
							<input type="text" name="link" class="form-control" placeholder="Silahkan masukkan link" v-model="formTugas.link">
							<small class="text-muted">Silahkan masukkan link ke dokumen</small>

						</div>
					</template>
				</div>
			</template>

      <!-- divider -->
      <hr>
      
      <!-- tombol desktop-->
      <div class="text-center d-none d-md-block">
        <button class="btn btn-light" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>

        <button type="submit" class="btn btn-primary">
          <i class="icon-floppy-disk"></i> Simpan</button>
      </div>  

      <!-- tombol mobile-->
      <div class="d-block d-md-none">
        <button type="submit" class="btn btn-primary btn-block pb-2">
          <i class="icon-floppy-disk"></i> Simpan</button>

        <button class="btn btn-light btn-block pb-2" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>
      </div>
    </form>
		</VeeForm>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useKegiatanBKCUStore } from '../../stores/kegiatanBKCU';
	import { toMulipartedForm } from '../../helpers/form';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";
	import VeeForm from "../../components/VeeForm.vue";
	import { Field } from 'vee-validate';

	export default {
		props: ['mode','selected','kegiatan_id','kegiatan_tipe'],
		components: {
			formInfo,
			message,
			VeeForm,
			Field
		},
		data() {
			return {
				title: '',
				formTugas: {
					id_cu: '',
					id_user: '',
					name: '',
					keterangan: '',
					tipe: '',
					format: '',
					content: '',
					link: '',
				},
				submited: false,
			}
		},
		created() {
			if(this.mode == 'edit'){
				this.formTugas = Object.assign({}, this.selected);
			}
		},
		watch: {
		},
		methods: {
			...mapActions(useKegiatanBKCUStore, {
				updateTugas: 'updateTugas',
				storeTugas: 'storeTugas',
			}),
			upload(e) {
				let files = e.target.files || e.dataTransfer.files;
				if (!files.length)
					return
				this.formTugas.content = files[0];
			},
			onValid() {
				this.formTugas.id_user = this.currentUser.id;
				this.formTugas.id_cu = this.currentUser.id_cu;
				const formData = toMulipartedForm(this.formTugas, this.mode);
				if (this.mode == 'edit') {
					this.updateTugas([this.formTugas.id, formData]);
				} else {
					this.storeTugas([this.kegiatan_tipe, this.kegiatan_id, formData]);
				}
			},
			onInvalid() {
				this.submited = true;
			},
			tutup() {
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