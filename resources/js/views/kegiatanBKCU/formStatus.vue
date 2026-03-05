<template>
	<div>
		<VeeForm :form="formStatus" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="handleSubmit(onValid)">
      <!-- status -->
      <div class="form-group">

        <!-- title -->
        <h5>Status Pertemuan:</h5>

        <!-- select -->
        <select name="status" data-width="100%" class="form-control" v-model="formStatus.status" @change="changeStatus($event.target.value)">
          <option disabled value="">Silahkan pilih status diklat</option>
          <option value="1">Menunggu</option>
          <option value="2">Pendaftaran Buka</option>
          <option value="3">Pendaftaran Tutup</option>
          <option value="4">Berjalan</option>
          <option value="5">Terlaksana</option>
          <option value="6">Batal</option>
        </select>

        <small class="text-muted">{{ penjelasanStatus }}</small>

      </div>

      <!-- keterangan batal -->
      <div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('keterangan')}" v-if="formStatus.status == 6">

        <!-- title -->
        <h5 :class="{ 'text-danger' : errors && errors.has && errors.has('keterangan')}">
          Keterangan:
        </h5>

        <!-- textarea -->
        <Field name="keterangan" v-slot="{ field }" :rules="'required|min:5'" label="Keterangan">
          <textarea rows="5" type="text" class="form-control" placeholder="Silahkan masukkan keterangan " v-bind="field" v-model="formStatus.keterangan"></textarea>
        </Field>

        <!-- error message -->
        <small class="text-muted text-danger" v-if="errors && errors.has && errors.has('keterangan')">
          <i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('keterangan') }}
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
	import { useKegiatanBKCUStore } from '../../stores/kegiatanBKCU';
	import { useAuthStore } from '../../stores/auth';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";
	import VeeForm from "../../components/VeeForm.vue";
	import { Field } from 'vee-validate';

	export default {
		props: ['kelas','id','status','keteranganBatal'],
		components: {
			formInfo,
			message,
			VeeForm,
			Field
		},
		data() {
			return {
				title: '',
				formStatus: {
					status: '',
					keterangan: ''
				},
				penjelasanStatus: '',
				submited: false,
			}
		},
		created() {
      this.formStatus.status = this.status;
      this.formStatus.keterangan = this.keteranganBatal;
		},
		watch: {
		},
		methods: {
			onValid() {
				this.updateStatus([this.id, this.formStatus]);
			},
			onInvalid() {
				this.submited = true;
			},
      changeStatus(value){
				if(value == 1){
					this.penjelasanStatus = 'Pertemuan masih belum dimulai dan belum menerima pendaftaran';
				}else if(value == 2){
					this.penjelasanStatus = 'Pertemuan masih belum dimulai tapi sudah mulai menerima pendaftaran peserta';
				}else if(value == 3){
					this.penjelasanStatus = 'Pertemuan masih belum dimulai tapi sudah tidak menerima lagi pendaftaran peserta';
				}else if(value == 4){
					this.penjelasanStatus = 'Pertemuan sudah dimulai dan sedang berproses/berjalan';
				}else if(value == 5){
					this.penjelasanStatus = 'Pertemuan sudah sukses terlaksana';
				}else if(value == 6){
					this.penjelasanStatus = 'Pertemuan batal dilaksanakan';
				}
			},
			tutup() {
				this.$emit('tutup');
			},
			...mapActions(useKegiatanBKCUStore, ['updateStatus'])
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
		}
	}
</script>