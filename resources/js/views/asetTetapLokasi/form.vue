<template>
	<div>

		<VeeForm :form="formModal" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">

		<form @submit.prevent="setValues(formModal) || handleSubmit(onValid)">

		<div class="row">

			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors.has('formModal.name')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('formModal.name')}">
						<i class="icon-cross2" v-if="errors.has('formModal.name')"></i>
						Nama: <wajib-badge></wajib-badge>
					</h5>

					<!-- text -->
					<Field name="name" rules="required" v-model="formModal.name" v-slot="{ field }"><input type="text" class="form-control" placeholder="Silahkan masukkan nama" v-bind="field"></Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formModal.name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formModal.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;
					</small>
				</div>
			</div>

			<!-- keterangan_keluar -->
			<div class="col-md-12">
				<div class="form-group" >

					<!-- title -->
					<h6>Keterangan:</h6>

					<!-- text -->
					<textarea rows="3" 
            type="text" 
            name="keterangan" 
            class="form-control" 
            placeholder="Silahkan masukkan keterangan " v-model="formModal.keterangan"></textarea>
					
				</div>
			</div>

		</div>

		<!-- form info -->
		<form-info></form-info>	

		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formModal.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formModal.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div> 

		</form>

		</VeeForm>

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import { useAsetTetapLokasiStore } from '../../stores/asetTetapLokasi';
	import _ from 'lodash';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import formInfo from "../../components/formInfo.vue";
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props: ['kelas','mode','selected'],
		components: {
			checkValue,
			Message,
			infoIcon,
			wajibBadge,
			formInfo,
			Field,
			VeeForm
		},
		setup() {
			const authStore = useAuthStore();
			const asetTetapLokasiStore = useAsetTetapLokasiStore();
			return { authStore, asetTetapLokasiStore };
		},
		data() {
			return {
				formModal:{
					id: '',
					name: '',
					keterangan: '',
				},
				message: {
					show: false,
					content: ''
				},
				submited: false,
			}
		},
		created(){
			if(this.mode == 'ubah'){
				this.formModal = Object.assign({},this.selected);
			}
		},
		watch: {},
		methods: {
			onValid(values){
				if(this.mode == 'tambah'){
					this.asetTetapLokasiStore.store(this.formModal);
				}else{
					this.asetTetapLokasiStore.update([this.selected.id, this.formModal]);
				}
			},
			onInvalid(){
				this.submited = true;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
		}
	}
</script>