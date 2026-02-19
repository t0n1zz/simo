<template>
	<div>
		<div class="card card-body">
			<card-data :itemData="selectedItem"></card-data>
		</div>

		<form @submit.prevent="save" data-vv-scope="formData">

		<div class="row">
			<!-- lokasi -->
			<div class="col-md-12">
				<div class="form-group">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formData.aset_tetap_lokasi_id')}">
						<i class="icon-cross2" v-if="errors.has('formData.aset_tetap_lokasi_id')"></i>
						Lokasi:
					</h6>

					<!-- select -->
					<select class="form-control" name="lokasi" v-model="formData.aset_tetap_lokasi_id" data-width="100%" v-validate="'required'" data-vv-as="Lokasi" :disabled="modelLokasi.length == 0" @change="changeLokasi($event.target.value)">
						<option disabled value="">
							<span v-if="modelLokasiStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih lokasi</span>
						</option>
						<option v-for="datas in modelLokasi" :value="datas.id" v-if="datas">{{datas.name}}</option>
					</select>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formData.aset_tetap_lokasi_id')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formData.aset_tetap_lokasi_id') }}
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

	</div>
</template>

<script>
	import _ from 'lodash';
	import { useAuthStore } from '../../stores/auth';
	import { useAsetTetapStore } from '../../stores/asetTetap';
	import { useAsetTetapLokasiStore } from '../../stores/asetTetapLokasi';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import Cleave from 'vue-cleave-component';
	import formInfo from "../../components/formInfo.vue";
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import cardData from "./card.vue";

	export default {
		props: ['kelas','selectedItem'],
		components: {
			checkValue,
			Message,
			Cleave,
			infoIcon,
			wajibBadge,
			cardData,
			formInfo
		},
		setup() {
			const authStore = useAuthStore();
			const asetTetapStore = useAsetTetapStore();
			const asetTetapLokasiStore = useAsetTetapLokasiStore();
			return { authStore, asetTetapStore, asetTetapLokasiStore };
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
			modelLokasiStat(value){
				if(value === "success"){
					this.formData = Object.assign({},this.selectedItem);
				}
			},
		},
		methods: {
			save(){
				this.$validator.validateAll('formData').then((result) => {
					if (result) {
						this.asetTetapStore.updateLokasi([this.selectedItem.lokasi.id, this.formData]);
					}else{
						
						this.submited = true;
					}	
				});	
			},
			fetch(){
				this.asetTetapLokasiStore.resetDataS();
				this.asetTetapLokasiStore.get();
			},
			tutup(){
				this.$emit('tutup');
			},
			changeLokasi(event){
				this.selectedItem.lokasi.id = event;
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			modelLokasi() {
				return this.asetTetapLokasiStore.dataS;
			},
			modelLokasiStat() {
				return this.asetTetapLokasiStore.dataStatS;
			},
			updateLokasiResponse() {
				return this.asetTetapLokasiStore.update;
			},
			updateLokasiStat() {
				return this.asetTetapLokasiStore.updateStat;
			},
		}
	}
</script>