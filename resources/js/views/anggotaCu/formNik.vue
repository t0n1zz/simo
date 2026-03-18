<template>
	<div>
		<div class="card card-body text-center">
			<ul class="list-inline list-inline-consensed mb-0 font-size-lg">
				<li class="list-inline-item"><b>No. KTP / NIK:</b> {{ anggota_cu.nik }}</li>
			</ul>
		</div>

		<VeeForm :form="formData" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">
		<form @submit.prevent="setValues(formData) || handleSubmit(onValid)">

		<div class="row">

			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors.has('formData.nik')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formData.nik')}">
					<i class="icon-cross2" v-if="errors.has('formData.nik')"></i>
					No. KTP / Nomor Induk Kependudukan (NIK):
					<br/>
					<span class="badge bg-danger-400 align-self-center ml-auto">*pastikan nomor yang dimasukan adalah nomor yang valid!</span> 
					</h6>

					<!-- text -->
					<Field name="nik" rules="required|min:16" v-model="formData.nik" v-slot="{ field }"><cleave
          v-bind="field"
          class="form-control"
          :options="cleaveOption.number16"
          placeholder="Silahkan masukkan no. KTP / Nomor Induk Kependudukan (NIK)"></cleave></Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formData.nik')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formData.nik') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>

				</div>
			</div>


		</div>

		<!-- divider -->
		<hr class="mt-0">
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formData.nik == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formData.nik == ''">
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
	import { mapActions } from 'pinia';
	import { useAnggotaCuStore } from '../../stores/anggotaCu';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import Cleave from 'vue-cleave-component';
	import produkCuAPI from '../../api/produkCu.js';
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props: ['anggota_cu'],
		components: {
			checkValue,
			Message,
			Cleave,
			infoIcon,
			wajibBadge,
			Field,
			VeeForm
		},
		data() {
			return {
				kelas: 'anggotaCu',
				formData:{
					nik: '',
				},
				cleaveOption: {
					number16: {
            numeral: true,
            numeralIntegerScale: 16,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
          }
				},
				message: {
					show: false,
					content: ''
				},
				submited: false,
			}
		},
		created(){},
		watch: {},
		methods: {
			...mapActions(useAnggotaCuStore, ['updateNik']),
			onValid(values){
				this.updateNik([this.anggota_cu.id, this.formData]);
			},
			onInvalid(){
				window.scrollTo(0, 0);
				this.submited = true;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {}
	}
</script>