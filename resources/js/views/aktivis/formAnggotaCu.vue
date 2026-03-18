<template>
	<div>
		<div class="row">

			<!-- cu -->
			<div class="col-md-4" v-if="currentUser.id_cu == 0">
				<div class="form-group" :class="{'has-error' : errors.has('form.anggota_cu.id_cu')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.anggota_cu.id_cu')}">
						<i class="icon-cross2" v-if="errors.has('form.anggota_cu.id_cu')"></i>
						CU:
					</h6>

					<!-- select -->
					<Field as="select" name="id_cu" rules="required" v-model="form.anggota_cu.id_cu" class="form-control" data-width="100%" :disabled="modelCu.length == 0">
						<option disabled value="">
							<span v-if="modelCuStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih CU</span>
						</option>
						<option v-for="(cu, index) in modelCu" :value="cu.id" :key="index">{{cu.name}}</option>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.anggota_cu.id_cu')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.anggota_cu.id_cu') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- no_ba -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors.has('form.anggota_cu.no_ba')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.anggota_cu.no_ba')}">
						<i class="icon-cross2" v-if="errors.has('form.anggota_cu.no_ba')"></i>
						No. BA:</h6>

					<!-- text -->
					<Field name="anggota_no_ba" rules="required|min:5" v-model="form.anggota_cu.no_ba" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan no. BA anggota CU" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.anggota_cu.no_ba')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.anggota_cu.no_ba') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- tanggal_masuk -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors.has('form.anggota_cu.tanggal_masuk')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.anggota_cu.tanggal_masuk')}">
					<i class="icon-cross2" v-if="errors.has('form.anggota_cu.tanggal_masuk')"></i>
					Tgl. Jadi Anggota: </h6>

					<!-- input -->
					<date-picker @dateSelected="form.anggota_cu = $event" :defaultDate="form.anggota_cu"></date-picker>
					<Field name="tanggal_masuk" rules="required" v-model="form.anggota_cu" v-show="false" />

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.anggota_cu.tanggal_masuk')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.anggota_cu.tanggal_masuk') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>

				</div>
			</div>

		</div>

	</div>
</template>

<script>
	import { Field } from 'vee-validate';
	import { useAuthStore } from '../../stores/auth';
	import Cleave from 'vue-cleave-component';
	import infoIcon from "../../components/infoIcon.vue";
	import DatePicker from "../../components/datePicker.vue";

	export default {
		props:['form','modelCu','modelCuStat','errors'],
		components: {
			Field,
			Cleave,
			infoIcon,
			DatePicker
		},
		setup() {
			return {
				authStore: useAuthStore(),
			};
		},
		data() {
			return {cleaveOption: {
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
		methods: {
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			}
		}
	}
</script>