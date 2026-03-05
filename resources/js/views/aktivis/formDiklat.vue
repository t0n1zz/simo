<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">
		<div class="row">

			<!-- name -->
			<div class="col-sm-12">
				<div class="form-group" :class="{'has-error' : errors.has('form.kegiatan_tipe')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.kegiatan_tipe')}">
						<i class="icon-cross2" v-if="errors.has('form.kegiatan_tipe')"></i>
						Tipe Kegiatan: <wajib-badge></wajib-badge></h6>

					<!-- select -->
					<Field name="kegiatan_tipe" rules="required" v-model="form.kegiatan_tipe" v-slot="{ field }">
						<select class="form-control" data-width="100%" v-bind="field">
						<option disabled value="">Silahkan pilih tipe kegiatan</option>
						<option value="diklat_bkcu">Diklat PUSKOPCUINA</option>
						<option value="pertemuan_bkcu">Pertemuan PUSKOPCUINA</option>
						<option value="diklat_cu_internal">Diklat Internal CU</option>
						<option value="pertemuan_cu_internal">Pertemuan Internal CU</option>
						<option value="diklat_eksternal">Diklat Eksternal</option>
						<option value="pertemuan_eksternal">Pertemuan Eksternal</option>
						<option value="diklat_bkcu_internal" v-if="currentUser.id_cu == 0">Diklat Internal PUSKOPCUINA</option>
						<option value="pertemuan_bkcu_internal" v-if="currentUser.id_cu == 0">Pertemuan Internal PUSKOPCUINA</option>
						</select>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.kegiatan_tipe')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.kegiatan_tipe') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- name -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.kegiatan_name')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.kegiatan_name')}">
						<i class="icon-cross2" v-if="errors.has('form.kegiatan_name')"></i>
						Nama Diklat: <wajib-badge></wajib-badge></h6>

					<!-- text -->
					<Field name="kegiatan_name" rules="required" v-model="form.kegiatan_name" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan nama diklat" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.kegiatan_name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.kegiatan_name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tempat -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.tempat')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.tempat')}">
						<i class="icon-cross2" v-if="errors.has('form.tempat')"></i>
						Tempat: <wajib-badge></wajib-badge></h6>

					<!-- text -->
					<Field name="tempat" rules="required" v-model="form.tempat" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan tempat diklat" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.tempat')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.tempat') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- lembaga -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.penyelenggara')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.penyelenggara')}">
						<i class="icon-cross2" v-if="errors.has('form.penyelenggara')"></i>
						Nama Lembaga Penyelenggara: <wajib-badge></wajib-badge></h6>

					<!-- text -->
					<Field name="penyelenggara" rules="required" v-model="form.penyelenggara" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan nama lembaga penyelenggara diklat" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.penyelenggara')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.penyelenggara') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- fasilitator -->
			<div class="col-sm-6">
				<div class="form-group">

					<!-- title -->
					<h6>Nama fasilitator:</h6>

					<!-- text -->
					<input type="text" name="fasilitator" class="form-control" placeholder="Silahkan masukkan nama fasilitator penyelenggara diklat" v-model="form.fasilitator">

				</div>
			</div>

			<!-- tanggal datang -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.datang')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.datang')}">
						<i class="icon-cross2" v-if="errors.has('form.datang')"></i>
						Tgl. Mulai: <wajib-badge></wajib-badge></h6>

					<!-- input -->
					<date-picker @dateSelected="form.datang = $event" :defaultDate="form.datang"></date-picker>
					<Field name="datang" rules="required" v-model="form.datang" v-slot="{ field }">
						<input type="hidden" v-bind="field" />
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.datang')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.datang') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tanggal pulang -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.pulang')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.pulang')}">
						<i class="icon-cross2" v-if="errors.has('form.pulang')"></i>
						Tgl. Selesai: <wajib-badge></wajib-badge></h6>

					<!-- input -->
					<date-picker @dateSelected="form.pulang = $event" :defaultDate="form.pulang"></date-picker>
					<Field name="pulang" rules="required" v-model="form.pulang" v-slot="{ field }">
						<input type="hidden" v-bind="field" />
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.pulang')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.pulang') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>
			
		</div>
		<!-- divider -->
		<hr>

		<!-- button -->
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
	import { useAuthStore } from '../../stores/auth';
	import { useAktivisStore } from '../../stores/aktivis';
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';
	import Cleave from 'vue-cleave-component';
	import DatePicker from "../../components/datePicker.vue";
	import wajibBadge from "../../components/wajibBadge.vue";

	export default {
		props:['formState','selected','id_aktivis'],
		components: {
			Cleave,
			DatePicker,
			wajibBadge,
			VeeForm,
			Field
		},
		data() {
			return {
				authStore: useAuthStore(),
				aktivisStore: useAktivisStore(),
				kelas: 'aktivis',
				form: {
					tingkat: '',
					name: '',
					tempat: '',
					mulai: '',
					selesai: '',
				},
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
          },
          number12: {
            numeral: true,
            numeralIntegerScale: 12,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
					number3: {
            numeral: true,
            numeralIntegerScale: 3,
            numeralDecimalScale: 0,
            stripLeadingZeroes: false
          },
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
          }
        }
			}
		},
		created(){
			if(this.formState == 'edit diklat'){
				this.form = this.selected;
			}
		},
		methods: {
			onValid() {
				const formData = { diklat: this.form };
				this.aktivisStore.saveDiklat([this.id_aktivis, formData]);
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed:{
			currentUser() {
				return this.authStore.currentUser;
			}
		}
	}
</script>