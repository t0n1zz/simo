<template>
	<div>
		<VeeForm :form="formPeserta" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="handleSubmit(onValid)">

      <!-- keteranganBatal batal -->
      <div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('keteranganBatal')}">

        <!-- title -->
        <h5 :class="{ 'text-danger' : errors && errors.has && errors.has('keteranganBatal')}">
          Alasan penolakkan peserta?
        </h5>

        <!-- textarea -->
        <Field name="keteranganBatal" v-slot="{ field }" :rules="'required|min:5'" label="Keterangan">
          <textarea rows="5" type="text" class="form-control" placeholder="Silahkan masukkan keteranganBatal " v-bind="field" v-model="formPeserta.keteranganBatal"></textarea>
        </Field>

        <!-- error message -->
        <small class="text-muted text-danger" v-if="errors && errors.has && errors.has('keteranganBatal')">
          <i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('keteranganBatal') }}
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
        <button class="btn btn-light btn-block pb-2" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>

        <button type="submit" class="btn btn-primary btn-block pb-2">
          <i class="icon-floppy-disk"></i> Simpan</button>
      </div>
    </form>
		</VeeForm>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useKegiatanBKCUStore } from '../../stores/kegiatanBKCU';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";
	import VeeForm from "../../components/VeeForm.vue";
	import { Field } from 'vee-validate';

	export default {
		props: ['kelas','tipe', 'id'],
		components: {
			formInfo,
			message,
			VeeForm,
			Field
		},
		data() {
			return {
				title: '',
				formPeserta: {
					status: '',
					keteranganBatal: ''
				},
				penjelasanStatus: '',
				submited: false,
			}
		},
		created() {
		},
		watch: {
		},
		methods: {
			...mapActions(useKegiatanBKCUStore, {
				batalPeserta: 'batalPeserta',
			}),
			onValid() {
				this.batalPeserta([this.tipe, this.id, this.formPeserta]);
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