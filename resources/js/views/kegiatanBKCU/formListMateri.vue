<template>
	<div>
		<VeeForm :form="formListMateri" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="handleSubmit(onValid)" enctype="multipart/form-data">
      <!-- nama -->
			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('nama')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('nama')}">
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('nama')"></i>
					Nama :
				</h5>

				<!-- text -->
				<Field name="nama" v-slot="{ field }" :rules="'required'" label="Nama">
					<input type="text" class="form-control" placeholder="Silahkan masukkan nama materi" v-bind="field" v-model="formListMateri.nama">
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('nama')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('nama') }}
				</small>
				<small class="text-muted" v-else>&nbsp;
				</small>
			</div>

			<!-- waktu -->
			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('waktu')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('waktu')}">
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('waktu')"></i>
					Waktu (Jam) :
				</h5>

				<!-- text -->
				<Field name="waktu" v-slot="{ field }" :rules="'required'" label="Waktu">
					<input type="text" class="form-control" placeholder="Silahkan masukkan waktu (jam)" v-bind="field" v-model="formListMateri.waktu">
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('waktu')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('waktu') }}
				</small>
				<small class="text-muted" v-else>&nbsp;
				</small>
			</div>
			<!-- narasumber -->
			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('narasumber')}">

			<!-- title -->
			<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('narasumber')}">
				<i class="icon-cross2" v-if="errors && errors.has && errors.has('narasumber')"></i>
				Narasumber :
			</h5>

			<!-- text -->
			<Field name="narasumber" v-slot="{ field }" :rules="'required'" label="Narasumber">
				<input type="text" class="form-control" placeholder="Silahkan masukkan narasumber" v-bind="field" v-model="formListMateri.narasumber">
			</Field>

			<!-- error message -->
			<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('narasumber')">
				<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('narasumber') }}
			</small>
			<small class="text-muted" v-else>&nbsp;
			</small>
			</div>

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
				formListMateri: {
					nama: '',
					waktu: '',
					narasumber: ''
				},
				penjelasanStatus: '',
				submited: false,
			}
		},
	created() {
			if(this.mode == 'edit'){
				this.formListMateri = Object.assign({}, this.selected);
			}
		},
		watch: {
			
		},
		methods: {
			...mapActions(useKegiatanBKCUStore, {
				updateListMateri: 'updateListMateri',
				storeListMateri: 'storeListMateri',
			}),
			upload(e) {
				let files = e.target.files || e.dataTransfer.files;
				if (!files.length)
					return
				this.formListMateri.content = files[0];
			},
			onValid() {
				const formData = toMulipartedForm(this.formListMateri, this.mode);
				if (this.mode == 'edit') {
					this.updateListMateri([this.formListMateri.id, formData]);
				} else {
					this.storeListMateri([this.kegiatan_tipe, this.kegiatan_id, formData]);
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