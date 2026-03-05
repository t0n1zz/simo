<template>
	<div>
		<div class="card card-body">
			<card-data :itemData="selectedItem"></card-data>
		</div>

		<VeeForm :form="formData" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">

		<div class="row">

			<!-- kondisi -->
			<div class="col-md-12">
				<div class="form-group">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formData.kondisi')}">
						<i class="icon-cross2" v-if="errors.has('formData.kondisi')"></i>
						Kondisi: 
					</h6>

					<!-- select -->
					<Field name="formData.kondisi" rules="required" v-model="formData.kondisi" v-slot="{ field }">
						<select class="form-control" data-width="100%" v-bind="field">
							<option disabled value="">Silahkan pilih kondisi</option>
							<option value="Baik">Baik</option>
							<option value="Diperbaiki">Diperbaiki</option>
							<option value="Rusak">Rusak</option>
							<option value="Dijual">Dijual</option>
							<option value="Hilang">Hilang</option>
							<option value="Disewa">Disewa</option>
						</select>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formData.kondisi')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formData.kondisi') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

		</div>

		<!-- form info -->
		<form-info></form-info>	
		<br/>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formData.cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formData.cu_id == ''">
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
	import { useAuthStore } from '../../stores/auth';
	import { useAsetTetapStore } from '../../stores/asetTetap';
	import { useAsetTetapKondisiStore } from '../../stores/asetTetapKondisi';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import Cleave from 'vue-cleave-component';
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import cardData from "./card.vue";
	import formInfo from "../../components/formInfo.vue";
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		props: ['kelas','selectedItem'],
		components: {
			checkValue,
			Message,
			Cleave,
			infoIcon,
			wajibBadge,
			cardData,
			formInfo,
			VeeForm,
			Field
		},
		setup() {
			const authStore = useAuthStore();
			const asetTetapStore = useAsetTetapStore();
			const asetTetapKondisiStore = useAsetTetapKondisiStore();
			return { authStore, asetTetapStore, asetTetapKondisiStore };
		},
		data() {
			return {
				formData:{},
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
			this.fetch();
			this.formData = Object.assign({},this.selectedItem);
		},
		watch: {
			modelKondisiStat(value){
				if(value === "success"){
					this.formData = Object.assign({},this.selectedItem);
				}
			},
		},
		methods: {
			onValid() {
				this.asetTetapStore.updateKondisi([this.selectedItem.id, this.formData]);
			},
			onInvalid() {
				this.submited = true;
			},
			fetch(){
				this.asetTetapKondisiStore.resetDataS();
				this.asetTetapKondisiStore.get();
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			modeKondisi() {
				return this.asetTetapKondisiStore.dataS;
			},
			modelKondisiStat() {
				return this.asetTetapKondisiStore.dataStatS;
			},
			updateKondisiResponse() {
				return this.asetTetapKondisiStore.updateData;
			},
			updateKondisiStat() {
				return this.asetTetapKondisiStore.updateStat;
			},
		}
	}
</script>