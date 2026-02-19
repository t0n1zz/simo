<template>
	<div>
		<!-- message -->
		<message v-if="errors && errors.any && errors.any('formPeserta') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="save" data-vv-scope="formPeserta">

      <!-- keteranganBatal batal -->
      <div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formPeserta.keteranganBatal')}">

        <!-- title -->
        <h5 :class="{ 'text-danger' : errors && errors.has && errors.has('formPeserta.keteranganBatal')}">
          Alasan penolakkan peserta?
        </h5>

        <!-- textarea -->
        <textarea rows="5" type="text" name="keteranganBatal" class="form-control" placeholder="Silahkan masukkan keteranganBatal " v-validate="'required|min:5'" data-vv-as="Keterangan" v-model="formPeserta.keteranganBatal"></textarea>

        <!-- error message -->
        <small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formPeserta.keteranganBatal')">
          <i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formPeserta.keteranganBatal') }}
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

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useKegiatanBKCUStore } from '../../stores/kegiatanBKCU';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";

	export default {
		props: ['kelas','tipe', 'id'],
		components: {
			formInfo,
			message
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
        // SHIM: Add dummy errors object for VeeValidate 2 compatibility in Vue 3
        errors: {
          any: () => false,
          has: () => false,
          first: () => '',
          collect: () => [],
          items: []
        },
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
      save(){
				this.$validator.validateAll('formPeserta').then((result) => {
					this.batalPeserta([this.tipe, this.id, this.formPeserta]);
				});
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