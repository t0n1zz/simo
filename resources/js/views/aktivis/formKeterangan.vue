<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">
		<div class="row">

			<!-- tipe -->
			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors.has('form.tipe')}">

					<!-- title -->
					<h5>
						Pilih tipe:
					</h5>

					<!-- select -->
					<Field name="tipe" rules="required" v-model="form.tipe" v-slot="{ field }">
						<select data-width="100%" class="form-control" v-bind="field">
							<option disabled value="">Silahkan pilih tipe</option>
							<option value="PENGHARGAAN">PENGHARGAAN</option>
							<option value="PELANGGARAN">PELANGGARAN</option>
							<option value="LAINNYA">LAINNYA</option>
						</select>
					</Field>

					<small class="text-muted">&nbsp;</small>
				</div>
			</div>

			<!-- nama -->
			<div class="col-sm-12">
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

			<!-- keterangan -->
			<div class="col-sm-12">
				<div class="form-group">

					<!-- title -->
					<h6>Keterangan:</h6>

					<!-- textarea -->
					<textarea rows="5" type="text" name="keterangan" class="form-control" placeholder="Silahkan masukkan keterangan" v-model="form.keterangan"></textarea>

				</div>
			</div>

			<!-- tanggal  -->
			<div class="col-sm-12">
				<div class="form-group" :class="{'has-error' : errors.has('form.tanggal')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.tanggal')}">
						<i class="icon-cross2" v-if="errors.has('form.tanggal')"></i>
						Tanggal:</h6>

					<!-- input -->
					<date-picker @dateSelected="form.tanggal = $event" :defaultDate="form.tanggal"></date-picker>
					<Field name="tanggal" rules="required" v-model="form.tanggal" v-slot="{ field }">
						<input type="hidden" v-bind="field" />
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.tanggal')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.tanggal') }}
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
					tipe: '',
					name: '',
					keterangan: '',
					tanggal: '',
				},
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
          },
        }
			}
		},
		created(){
			if(this.formState == 'edit keterangan'){
				this.form = this.selected;
			}
		},
		methods: {
			onValid() {
				const formData = { keterangan: this.form };
				this.aktivisStore.saveKeterangan([this.id_aktivis, formData]);
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