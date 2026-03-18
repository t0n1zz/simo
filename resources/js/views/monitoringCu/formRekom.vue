<template>
	<div>
		<VeeForm :form="formDataRekom" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">

		<form @submit.prevent="setValues(formDataRekom) || handleSubmit(onValid)">

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
					<Field name="rekomendasi" rules="required" v-model="formDataRekom.rekomendasi" v-slot="{ field }"><input type="text" class="form-control" placeholder="Silahkan masukkan rekomendasi" v-bind="field"></Field>

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

		</VeeForm>

	</div>
</template>

<script>
	import _ from 'lodash';
	import { mapState } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props: ['mode','selected'],
		components: {
			checkValue,
			Message,
			wajibBadge,
			Field,
			VeeForm
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
			onValid(values){
				if(!this.formDataRekom.status){
					this.formDataRekom.status = 0;
				}
				if(this.mode == 'edit'){
					this.$emit('editRekom',this.formDataRekom);
				}else{
					this.$emit('createRekom',this.formDataRekom);
				}
			},
			onInvalid(){
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