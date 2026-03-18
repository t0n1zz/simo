<template>
	<div>
		<div class="card card-body text-center">
			<ul class="list-inline list-inline-consensed mb-0 font-size-lg">
				<li class="list-inline-item"><b>CU:</b> {{ anggota_cu.cu ? anggota_cu.cu.name : "-" }}</li>
				<li class="list-inline-item"><b>TP/KP:</b> {{ anggota_cu.cu ? anggota_cu.tp.name : "-" }}</li>
				<li class="list-inline-item"><b>No. BA:</b> {{ anggota_cu.no_ba }}</li>
				<li class="list-inline-item"><b>Tgl. Masuk:</b> {{ $filters.date(anggota_cu.tanggal_masuk) }}</li>
			</ul>
		</div>

		<VeeForm :form="formDataCu" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">
		<form @submit.prevent="setValues(formDataCu) || handleSubmit(onValid)">

		<div class="row">

			<!-- tp -->
			<div class="col-sm-12">
		<div class="form-group" :class="{'has-error' : errors.has('formDataCu.tp_id')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formDataCu.tp_id')}">
						<i class="icon-cross2" v-if="errors.has('formDataCu.tp_id')"></i>
						TP/KP Tujuan: <wajib-badge></wajib-badge>
					</h6>

					<!-- select -->
					<Field as="select" name="id_tp" rules="required" v-model="formDataCu.tp_id" class="form-control" data-width="100%">
						<option disabled value="">Silahkan pilih TP/KP</option>
						<option v-for="(tp, index) in modelTp" :key="index" :value="tp.id">{{tp.name}}</option>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formDataCu.tp_id')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formDataCu.tp_id') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tanggal pindah -->
			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors.has('formDataCu.tanggal_pindah')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formDataCu.tanggal_pindah')}">
					<i class="icon-cross2" v-if="errors.has('formDataCu.tanggal_pindah')"></i>
					Tgl. Pindah: <wajib-badge></wajib-badge></h6>

					<!-- text -->
					<date-picker @dateSelected="formDataCu.tanggal_pindah = $event" :defaultDate="formDataCu.tanggal_pindah"></date-picker>
					<Field name="tanggal_pindah" rules="required" v-model="formDataCu.tanggal_pindah" v-show="false" />

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formDataCu.tanggal_pindah')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formDataCu.tanggal_pindah') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>

				</div>
			</div>

		</div>

		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formDataCu.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formDataCu.cu_id == ''">
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
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useTpStore } from '../../stores/tp';
	import { useAnggotaCuStore } from '../../stores/anggotaCu';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import Cleave from 'vue-cleave-component';
	import produkCuAPI from '../../api/produkCu.js';
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import DatePicker from "../../components/datePicker.vue";
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
			DatePicker,
			Field,
			VeeForm
		},
		data() {
			return {
				kelas: 'anggotaCu',
				formDataCu:{
					id: '',
					tp_id: '',
					tanggal_pindah: '',
					keterangan_keluar: '',
				},
				modelProdukCu: [],
				modelProdukCuStat: '',
				cleaveOption: {
					date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
					},
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
					},
				},
				message: {
					show: false,
					content: ''
				},
				submited: false,
			}
		},
		created(){
			this.fetchTp(this.anggota_cu.cu_id);
		},
		watch: {},
		methods: {
			...mapActions(useTpStore, { getTpCu: 'getCu' }),
			...mapActions(useAnggotaCuStore, ['updatePindahTp']),
			fetchTp(value){
				this.getTpCu(value);
			},
			onValid(values){
				this.updatePindahTp([this.anggota_cu.id, this.formDataCu]);
			},
			onInvalid(){
				window.scrollTo(0, 0);
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
			...mapState(useTpStore,{
				modelTp: 'dataS',
				modelTpStat: 'dataStatS',
			}),
		}
	}
</script>