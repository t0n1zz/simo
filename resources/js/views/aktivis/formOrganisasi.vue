<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">
		<div class="row">

			<!-- nama -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.name')}">
						<i class="icon-cross2" v-if="errors.has('form.name')"></i>
						Nama:</h6>

					<!-- text -->
					<Field name="name" rules="required" v-model="form.name" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan nama" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- jabatan -->
			<div class="col-sm-6">
				<div class="form-group" :class="{'has-error' : errors.has('form.jabatan')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.jabatan')}">
						<i class="icon-cross2" v-if="errors.has('form.jabatan')"></i>
						Jabatan/Peran/Tanggungjawab:</h6>

					<!-- text -->
					<Field name="jabatan" rules="required|min:5" v-model="form.jabatan" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan jabatan/peran/tanggungjawab " v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.jabatan')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.jabatan') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tempat -->
			<div class="col-sm-12">
				<div class="form-group" :class="{'has-error' : errors.has('form.tempat')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.tempat')}">
						<i class="icon-cross2" v-if="errors.has('form.tempat')"></i>
						Tempat:</h6>

					<!-- text -->
					<Field name="tempat" rules="required|min:5" v-model="form.tempat" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan tempat " v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.tempat')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.tempat') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tanggal mulai -->
			<div class="col-sm-6">
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
			<div class="col-sm-6">
				<div class="form-group">

					<!-- title -->
					<h6>Tgl. Selesai</h6>

					<!-- input -->
					<date-picker @dateSelected="form.selesai = $event" :defaultDate="form.selesai"></date-picker>

					<small class="text-muted">Kosongkan apabila masih aktif / tidak memiliki periode selesai</small>
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

			<button type="submit" class="btn btn-primary" :disabled="form.aktif == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">

			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="form.aktif == ''">
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
		data() {
			return {
				aktivisStore: useAktivisStore(),
				kelas: 'aktivis',
				form: {
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
			if(this.formState == 'edit organisasi'){
				this.form = this.selected;
			}
		},
		methods: {
			onValid() {
				const formData = { organisasi: this.form };
				this.aktivisStore.saveOrganisasi([this.id_aktivis, formData]);
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