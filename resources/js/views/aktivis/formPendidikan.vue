<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">
		<div class="row">

			<!-- tingkat -->
			<div class="col-sm-12">
				<div class="form-group" :class="{'has-error' : errors.has('form.tingkat')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.tingkat')}">
						<i class="icon-cross2" v-if="errors.has('form.tingkat')"></i>
						Tingkat:
					</h6>

					<!-- select -->
					<Field name="tingkat" rules="required" v-model="form.tingkat" v-slot="{ field }">
						<select class="form-control" data-width="100%" v-bind="field">
							<option disabled value="">Silahkan pilih tingkat pendidikan</option>
						<option value="TK">TK</option>
						<option value="SD">SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA/SMK">SMA/SMK</option>
						<option value="D1">D1</option>
						<option value="D2">D2</option>
						<option value="D3">D3</option>
						<option value="D4">D4</option>
						<option value="S1">S1</option>
						<option value="S2">S2</option>
						<option value="S3">S3</option>
						<option value="LAIN-LAIN">Lain-lain</option>
						</select>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.tingkat')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.tingkat') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- jurusan -->
			<div class="col-sm-12" v-if="form.tingkat != '' &&  form.tingkat != 'SD' && form.tingkat != 'SMP'">
				<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.name')}">
						<i class="icon-cross2" v-if="errors.has('form.name')"></i>
						Jurusan:</h6>

					<!-- text -->
					<Field name="name" rules="required" v-model="form.name" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan jurusan" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tempat -->
			<div class="col-sm-12" v-if="form.tingkat != ''">
				<div class="form-group" :class="{'has-error' : errors.has('form.tempat')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.tempat')}">
						<i class="icon-cross2" v-if="errors.has('form.tempat')"></i>
						Tempat:</h6>

					<!-- text -->
					<Field name="tempat" rules="required|min:5" v-model="form.tempat" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan tempat pendidikan" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.tempat')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.tempat') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tanggal mulai -->
			<div class="col-sm-6" v-if="form.tingkat != ''">
				<div class="form-group" :class="{'has-error' : errors.has('form.mulai')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.mulai')}">
						<i class="icon-cross2" v-if="errors.has('form.mulai')"></i>
						Tgl. Mulai:</h6>

					<!-- input -->
					<date-picker @dateSelected="form.mulai = $event" :defaultDate="form.mulai"></date-picker>
					<Field name="mulai" rules="required" v-model="form.mulai" v-slot="{ field }">
						<input type="hidden" v-bind="field" />
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.mulai')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.mulai') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tanggal selesai -->
			<div class="col-sm-6" v-if="form.tingkat != ''">
				<div class="form-group">

					<!-- title -->
					<h6>Tgl. Selesai</h6>

					<!-- input -->
					<date-picker @dateSelected="form.selesai = $event" :defaultDate="form.selesai"></date-picker>	

					<small class="text-muted">Kosongkan apabila masih menjalani pendidikan / belum mengetahui tanggal selesai pendidikan</small>
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

			<button type="submit" class="btn btn-primary" :disabled="form.tingkat == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">

			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="form.tingkat == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div> 
		</form>
		</VeeForm>
	</div>
</template>

<script>
	import { useAktivisStore } from '../../stores/aktivis';
	import Cleave from 'vue-cleave-component';
	import DatePicker from "../../components/datePicker.vue";
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		props:['formState','selected','id_aktivis'],
		components: {
			Cleave,
			DatePicker,
			VeeForm,
			Field
		},
		setup() {
			return {
				aktivisStore: useAktivisStore(),
			};
		},
		data() {
			return {kelas: 'aktivis',
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
			if(this.formState == 'edit pendidikan'){
				this.form = this.selected;
			}
		},
		methods: {
			onValid() {
				const formData = { pendidikan: this.form };
				this.aktivisStore.savePendidikan([this.id_aktivis, formData]);
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
			},
			tutup(){
				this.$emit('tutup');
			}
		}
	}
</script>