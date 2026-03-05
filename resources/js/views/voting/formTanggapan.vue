<template>
	<div>
		<VeeForm :form="formTanggapan" v-slot="{ errors, handleSubmit }">
			<form @submit.prevent="handleSubmit(onValid, onInvalid)">

			<!-- message -->
			<message v-if="errors.any('form') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
			</message>
			<!-- divider -->
			<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors.has('form.name')}">
					<i class="icon-cross2" v-if="errors.has('form.name')"></i>
					Tanggapan: </h5>

				<!-- text -->
				<Field
					name="name"
					rules="required"
					v-model="formTanggapan.name"
					v-slot="{ field }"
				>
					<input
						type="text"
						class="form-control"
						placeholder="Silahkan masukkan tanggapan"
						v-bind="field"
					>
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors.has('form.name')">
					<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
				</small>
				<small class="text-muted" v-else>&nbsp;</small>
			</div>

			<hr>
			
			<!-- tombol desktop-->
			<div class="text-center d-none d-md-block">
				<button type="button" class="btn btn-light" @click.prevent="tutup">
					<i class="icon-cross"></i> Tutup</button>

				<button type="submit" class="btn btn-primary">
					<i class="icon-floppy-disk"></i> Simpan</button>
			</div>  

			<!-- tombol mobile-->
			<div class="d-block d-md-none">
				<button type="submit" class="btn btn-primary btn-block pb-2">
					<i class="icon-floppy-disk"></i> Simpan</button>

				<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
					<i class="icon-cross"></i> Tutup</button>
			</div>

			</form> 
		</VeeForm>

	</div>
</template>

<script>
	import { mapState } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import checkValue from '../../components/checkValue.vue';
	import message from "../../components/message.vue";
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props: ['mode','selected'],
		components: {
			checkValue,
			message,
			VeeForm,
			Field,
		},
		data() {
			return {
				title: '',
				formTanggapan:{
					name: '',
				},
				submited: false,
			}
		},
		created(){
			if(this.mode == 'edit'){
				this.formTanggapan = Object.assign({}, this.selected);
			}
		},
		methods: {
			onValid(){
				if(this.mode == 'edit'){
					this.$emit('editTanggapan',this.formTanggapan);
				}else{
					this.$emit('createTanggapan',this.formTanggapan);
				}
				this.submited = false;
			},
			onInvalid(){
				this.submited = true;
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