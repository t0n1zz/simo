<template>
	<div>
		<VeeForm :form="formRekom" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>

		<form @submit.prevent="handleSubmit(onValid)" enctype="multipart/form-data">

			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('no')}">
				<!-- title -->
				<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('no')}">
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('no')"></i>
					No.: <wajib-badge></wajib-badge>
				</h5>

				<!-- text -->
				<Field name="no" rules="required" v-model="formRekom.no" v-slot="{ field }" label="Nomor rekomendasi">
					<input type="hidden" v-bind="field" />
				</Field>
				<cleave
					v-model="formRekom.no"
					class="form-control"
					:options="cleaveOption.number4"
					placeholder="Silahkan masukkan nomor rekomendasi"></cleave>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('no')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('no') }}
				</small>
				<small class="text-muted" v-else>&nbsp;
				</small>
			</div>

      <!-- name -->
			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('name')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('name')}">
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('name')"></i>
					Rekomendasi <wajib-badge></wajib-badge>
				</h5>

				<!-- textarea -->
				<Field name="name" v-slot="{ field }" :rules="'required'" label="Rekomendasi">
					<textarea rows="5" type="text" class="form-control" placeholder="Silahkan masukkan rekomendasi " v-bind="field" v-model="formRekom.name"></textarea>
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('name')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('name') }}
				</small>
				<small class="text-muted" v-else>&nbsp;
				</small>
			</div>

			<div class="form-group">
				<!-- title -->
				<h5>PIC:</h5>

				<!-- text -->
				<input type="text" name="pic" class="form-control" placeholder="Silahkan masukkan pic" v-model="formRekom.pic">
			</div>

			<div class="form-group">
				<!-- title -->
				<h5>Waktu:</h5>

				<!-- text -->
				<input type="text" name="waktu" class="form-control" placeholder="Silahkan masukkan waktu" v-model="formRekom.waktu">
			</div>

			<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('tipe')}">
				<!-- title -->
				<h5>
					<i class="icon-cross2" v-if="errors && errors.has && errors.has('tipe')"></i>Tipe Tindak Lanjut <wajib-badge></wajib-badge>
				</h5>

				<!-- select -->
				<Field name="tipe" v-slot="{ field }" :rules="'required'" label="Tipe Tindak Lanjut">
					<select class="form-control" data-width="100%" v-bind="field" v-model="formRekom.tipe">
						<option disabled value="">Silahkan pilih tipe tindak lanjut</option>
						<option value="1">Per lembaga</option>
						<option value="2">Per peserta</option>
						<option value="3">PUSKOPCUINA</option>
					</select>
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('tipe')">
					<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('tipe') }}
				</small>
				<small class="text-muted" v-else>&nbsp;
				</small>
			</div>

      <!-- divider -->
      <hr>
      
      <!-- tombol desktop-->
      <div class="text-center d-none d-md-block">
        <button class="btn btn-light" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>

        <button type="submit" class="btn btn-primary">
          <i class="icon-floppy-disk"></i> Simpan</button>
      </div>  

      <!-- tombol mobile-->
      <div class="d-block d-md-none">
        <button type="submit" class="btn btn-primary btn-block pb-2">
          <i class="icon-floppy-disk"></i> Simpan</button>

        <button class="btn btn-light btn-block pb-2" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>
      </div>
    </form>
		</VeeForm>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useKegiatanRekomStore } from '../../stores/kegiatanRekom';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import Cleave from 'vue-cleave-component';
	import VeeForm from "../../components/VeeForm.vue";
	import { Field } from 'vee-validate';

	export default {
		props: ['mode','selected','kegiatan_id','kelas'],
		components: {
			formInfo,
			message,
			wajibBadge,
			Cleave,
			VeeForm,
			Field
		},
		data() {
			return {
				title: '',
				formRekom: {
					kegiatan_id: '',
					no: '',
					name: '',
					pic: '',
					waktu: '',
					tipe: '',
				},
				penjelasanStatus: '',
				submited: false,
				cleaveOption: {
					number4: {
						numeral: true,
						numeralIntegerScale: 4,
						numeralDecimalScale: 0,
						stripLeadingZeroes: false
					},
				},
			}
		},
		created() {
			if(this.mode == 'edit'){
				this.formRekom = Object.assign({}, this.selected);
			}
			this.formRekom.kegiatan_id = this.kegiatan_id;
		},
		watch: {
		},
		methods: {
			...mapActions(useKegiatanRekomStore, {
				update: 'update',
				store: 'store',
			}),
			onValid() {
				if (this.mode == 'edit') {
					this.update([this.formRekom.id, this.formRekom]);
				} else {
					this.store(this.formRekom);
				}
			},
			onInvalid() {
				this.submited = true;
			},
			tutup() {
				this.$emit('tutup');
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
		}
	}
</script>