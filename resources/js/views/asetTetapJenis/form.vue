<template>
	<div>
		<VeeForm :form="formModal" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">

		<div class="row">

			<!-- golongan -->
			<div class="col-md-12">
				<div class="form-group">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formModal.aset_tetap_golongan_id')}">
						<i class="icon-cross2" v-if="errors.has('formModal.aset_tetap_golongan_id')"></i>
						Golongan: <wajib-badge></wajib-badge>
					</h6>

					<!-- <div class="input-group"> -->

						<!-- select -->
							<Field name="formModal.aset_tetap_golongan_id" rules="required" v-model="formModal.aset_tetap_golongan_id" v-slot="{ field }">
								<select class="form-control" data-width="100%" v-bind="field" :disabled="modelGolongan.length == 0" @change="changeGolongan($event.target.value)">
									<option disabled value="">
										<span v-if="modelGolonganStat === 'loading'">Mohon tunggu...</span>
										<span v-else>Silahkan pilih golongan</span>
									</option>
									<template v-for="datas in modelGolongan" :key="datas ? datas.id : undefined">
										<option v-if="datas" :value="datas.id">{{ datas.kode + ' | ' + datas.name }}</option>
									</template>
								</select>
							</Field>

						<!-- button -->
						<!-- <div class="input-group-append" v-if="currentUser.can && currentUser.can['create_aset_tetap_jenis']">
							<button type="button" class="btn btn-light" @click="modalOpen('golongan')">
								<i class="icon-plus22"></i>
							</button>
						</div>

					</div> -->

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formModal.aset_tetap_golongan_id')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formModal.aset_tetap_golongan_id') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kelompok -->
			<div class="col-md-12">
				<div class="form-group">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formModal.aset_tetap_kelompok_id')}">
						<i class="icon-cross2" v-if="errors.has('formModal.aset_tetap_kelompok_id')"></i>
						Kelompok: <wajib-badge></wajib-badge>
					</h6>

					<!-- <div class="input-group"> -->

						<!-- select -->
							<Field name="formModal.aset_tetap_kelompok_id" rules="required" v-model="formModal.aset_tetap_kelompok_id" v-slot="{ field }">
								<select class="form-control" data-width="100%" v-bind="field" :disabled="modelKelompok.length == 0">
									<option disabled value="">
										<span v-if="modelKelompokStat === 'loading'">Mohon tunggu...</span>
										<span v-else>Silahkan pilih kelompok</span>
									</option>
									<template v-for="datas in modelKelompok" :key="datas ? datas.id : undefined">
										<option v-if="datas" :value="datas.id">{{ datas.kode + ' | ' + datas.name }}</option>
									</template>
								</select>
							</Field>

						<!-- button -->
						<!-- <div class="input-group-append" v-if="currentUser.can && currentUser.can['create_aset_tetap_jenis']">
							<button type="button" class="btn btn-light" @click="modalOpen('kelompok')">
								<i class="icon-plus22"></i>
							</button>
						</div>

					</div> -->

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formModal.aset_tetap_kelompok_id')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formModal.aset_tetap_kelompok_id') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kode -->
			<div class="col-md-12" v-if="formModal.aset_tetap_kelompok_id != ''">
				<div class="form-group" :class="{'has-error' : errors.has('formModal.kode')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('formModal.kode')}">
						<i class="icon-cross2" v-if="errors.has('formModal.kode')"></i>
						Kode: <wajib-badge></wajib-badge></h6>

					<!-- text -->
					<Field name="formModal.kode" rules="required" v-model="formModal.kode" v-slot="{ field }">
						<input type="hidden" v-bind="field" />
					</Field>
					<cleave
						v-model="formModal.kode"
						class="form-control"
						:options="cleaveOption.number4"
						placeholder="Silahkan masukkan kode"></cleave>	
					
					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formModal.kode')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formModal.kode') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div> 

			<div class="col-md-12" v-if="formModal.aset_tetap_kelompok_id != ''">
				<div class="form-group" :class="{'has-error' : errors.has('formModal.name')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('formModal.name')}">
						<i class="icon-cross2" v-if="errors.has('formModal.name')"></i>
						Nama: <wajib-badge></wajib-badge>
					</h5>

					<!-- text -->
					<Field name="formModal.name" rules="required" v-model="formModal.name" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan nama" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formModal.name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formModal.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;
					</small>
				</div>
			</div>

			<!-- keterangan_keluar -->
			<div class="col-md-12" v-if="formModal.aset_tetap_kelompok_id != ''">
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
	import { useAsetTetapJenisStore } from '../../stores/asetTetapJenis';
	import { useAsetTetapGolonganStore } from '../../stores/asetTetapGolongan';
	import { useAsetTetapKelompokStore } from '../../stores/asetTetapKelompok';
	import _ from 'lodash';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import formInfo from "../../components/formInfo.vue";
	import Cleave from 'vue-cleave-component';
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		props: ['kelas','mode','selected'],
		components: {
			checkValue,
			Message,
			infoIcon,
			wajibBadge,
			formInfo,
			Cleave,
			VeeForm,
			Field
		},
		setup() {
			const authStore = useAuthStore();
			const asetTetapJenisStore = useAsetTetapJenisStore();
			const asetTetapGolonganStore = useAsetTetapGolonganStore();
			const asetTetapKelompokStore = useAsetTetapKelompokStore();
			return { authStore, asetTetapJenisStore, asetTetapGolonganStore, asetTetapKelompokStore };
		},
		data() {
			return {
				cleaveOption: {
					number4: {
            numeral: true,
            numeralIntegerScale: 4,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
				},
				formModal:{
					aset_tetap_kelompok_id: '',
					id: '',
					kode: '',
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
			this.asetTetapGolonganStore.resetDataS();
			this.asetTetapGolonganStore.get().then(() => {
				
				if(this.mode == 'ubah'){
					this.formModal = Object.assign({},this.selected);
					// if ubah, we need to load kelompok based on golongan
					if(this.formModal.kelompok && this.formModal.kelompok.aset_tetap_golongan_id){
						this.formModal.aset_tetap_golongan_id = this.formModal.kelompok.aset_tetap_golongan_id;
						this.changeGolongan(this.formModal.aset_tetap_golongan_id);
					}
				}

			});
		},
		watch: {},
		methods: {
			changeGolongan(id){
				this.asetTetapKelompokStore.resetDataS();
				this.asetTetapKelompokStore.get(id);
			},
			onValid() {
				if(this.mode == 'tambah'){
					this.asetTetapJenisStore.store(this.formModal);
				}else{
					this.asetTetapJenisStore.update([this.selected.id, this.formModal]);
				}
			},
			onInvalid() {
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
			modelKelompok() {
				return this.asetTetapKelompokStore.dataS;
			},
			modelKelompokStat() {
				return this.asetTetapKelompokStore.dataStatS;
			},
			modelGolongan() {
				return this.asetTetapGolonganStore.dataS;
			},
			modelGolonganStat() {
				return this.asetTetapGolonganStore.dataStatS;
			}
		}
	}
</script>