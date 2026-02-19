<template>
	<div>
		<form @submit.prevent="save">

		<!-- message -->
		<message v-if="message.show" @close="messageClose" :title="'Oops terjadi kesalahan'" :errorData="message.content" :showDebug="false">
		</message>

		<div class="row">

			<!-- keterangan_masuk -->
			<div class="col-md-12">
				<div class="form-group" >

					<!-- title -->
					<h6>Rekomendasi: <wajib-badge></wajib-badge></h6>

					<!-- text -->
					<input type="text" name="rekomendasi" class="form-control" placeholder="Silahkan masukkan rekomendasi" v-model="formDataRekom.rekomendasi">

					<!-- error message -->
					<small class="text-muted text-danger" v-if="v$.formDataRekom.rekomendasi.$error">
						<i class="icon-arrow-small-right"></i> {{ v$.formDataRekom.rekomendasi.$errors[0]?.$message }}
					</small>
					
				</div>
			</div>

		</div>

		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formDataRekom.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formDataRekom.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div> 

		</form>

	</div>
</template>

<script>
	import _ from 'lodash';
	import { mapState } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import wajibBadge from "../../components/wajibBadge.vue";

	import { useVuelidate } from '@vuelidate/core';
	import { required } from '@vuelidate/validators';

	export default {
		props: ['mode','selected'],
		components: {
			checkValue,
			Message,
			wajibBadge
		},
		setup() {
			return { v$: useVuelidate() }
		},
		validations() {
			return {
				formDataRekom: {
					rekomendasi: { required },
				}
			}
		},
		data() {
			return {
				title: '',
				kelas: 'monitoring',
				formDataRekom:{
					rekomendasi: '',
					status: '',
				},
				message: {
					show: false,
					content: ''
				},
				submited: false,
			}
		},
		created(){
			if(this.mode == 'edit'){
				this.formDataRekom = Object.assign({},this.selected);
			}
		},
		watch: {},
		methods: {
			save(){
				if(!this.formDataRekom.status){
					this.formDataRekom.status = 0;
				}
				this.v$.$validate();
				if (!this.v$.$error) {
					if(this.mode == 'edit'){
						this.$emit('editRekom',this.formDataRekom);
					}else{
						this.$emit('createRekom',this.formDataRekom);
					}
					this.submited = false;
				}else{
					this.submited = true;
				}
			},
			messageClose(){
				this.message.show = false;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
		}
	}
</script>