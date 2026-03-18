<template>
	<div>
		<div class="row">

			<!-- Provinsi -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.id_provinces')}">
						<i class="icon-cross2" v-if="errors.has('form.id_provinces')"></i>
						Provinsi:
					</h6>

					<!-- select -->
					<Field as="select" name="id_provinces" rules="required" v-model="form.id_provinces" class="form-control" data-width="100%" :disabled="modelProvinces.length == 0" @change="changeProvinces($event.target.value)">
						<option disabled value="">
							<span v-if="modelProvincesStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih provinsi</span>
						</option>
						<option v-for="provinces in modelProvinces" :key="provinces.id" :value="provinces.id">{{provinces.name}}</option>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.id_provinces')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_provinces') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kabupaten -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors.has('form.id_regencies')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.id_regencies')}">
						<i class="icon-cross2" v-if="errors.has('form.id_regencies')"></i>
						Kabupaten:
					</h6>

					<!-- select -->
					<Field as="select" name="id_regencies" rules="required" v-model="form.id_regencies" class="form-control" data-width="100%" @change="changeRegencies($event.target.value)" :disabled="modelRegencies.length === 0">
						<option disabled value="">
							<span v-if="modelRegenciesStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih kabupaten</span>
						</option>
						<option v-for="regencies in modelRegencies" :key="regencies.id" :value="regencies.id">{{regencies.name}}</option>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.id_regencies')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_regencies') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kecamatan -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors.has('form.id_districts')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.id_districts')}">
						<i class="icon-cross2" v-if="errors.has('form.id_districts')"></i>
						Kecamatan:
					</h6>

					<!-- select -->
					<Field as="select" name="id_districts" rules="required" v-model="form.id_districts" class="form-control" data-width="100%" :disabled="modelDistricts.length === 0" @change="changeDistricts($event.target.value)">
						<option disabled value="">
							<span v-if="modelDistrictsStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih kecamatan</span>
						</option>
						<option v-for="districts in modelDistricts" :key="districts.id" :value="districts.id">{{districts.name}}</option>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.id_regency')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_regency') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kelurahan -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors.has('form.id_villages')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.id_villages')}">
						<i class="icon-cross2" v-if="errors.has('form.id_villages')"></i>
						Kelurahan:
					</h6>

					<!-- select -->
					<Field as="select" name="id_villages" rules="required" v-model="form.id_villages" class="form-control" data-width="100%" :disabled="modelVillages.length === 0">
						<option disabled value="">
							<span v-if="modelVillagesStat === 'loading'">Mohon tunggu... mohon tunggu</span>
							<span v-else>Silahkan pilih kelurahan</span>
						</option>
						<option v-for="villages in modelVillages" :key="villages.id" :value="villages.id">{{villages.name}}</option>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.id_villages')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_villages') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- alamat -->
			<div class="col-md-8">
				<div class="form-group" :class="{'has-error' : errors.has('form.alamat')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.alamat')}">
						<i class="icon-cross2" v-if="errors.has('form.alamat')"></i>
						Alamat:</h6>

					<!-- text -->
					<Field name="alamat" rules="required|min:5" v-model="form.alamat" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan alamat" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.alamat')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.alamat') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- no hp -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h6>No. Hp:</h6>

					<!-- text -->
					<cleave
						v-model="form.hp"
						class="form-control"
						:options="cleaveOption.number12"
						placeholder="Silahkan masukkan no hp"></cleave>

					<!-- error message -->
					<small class="text-muted">&nbsp;</small>
				</div>
			</div>

			<!-- email -->
			<div class="col-md-4">
				<div class="form-group" :class="{'has-error' : errors.has('form.email')}">

					<!-- title -->
					<h6 :class="{ 'text-danger' : errors.has('form.email')}">
						<i class="icon-cross2" v-if="errors.has('form.email')"></i>
						Email:</h6>

					<!-- text -->
					<Field name="email" rules="email" v-model="form.email" v-slot="{ field }">
						<input type="text" class="form-control" placeholder="Silahkan masukkan alamat email" v-bind="field">
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.email')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.email') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- kontak -->
			<div class="col-md-4">
				<div class="form-group">

					<!-- title -->
					<h6>Kontak Lainnya:</h6>

					<!-- text -->
					<input type="text" name="kontak" class="form-control" placeholder="Silahkan masukkan kontak lainnya" v-model="form.kontak">

				</div>
			</div>

		</div>

	</div>
</template>

<script>
	import { Field } from 'vee-validate';
	import Cleave from 'vue-cleave-component';
	import { useProvincesStore } from '../../stores/provinces';
	import { useRegenciesStore } from '../../stores/regencies';
	import { useDistrictsStore } from '../../stores/districts';
	import { useVillagesStore } from '../../stores/villages';

	export default {
		props: ['form', 'errors'],
		components: {
			Field,
			Cleave,
		},
		data() {
			return {
				provincesStore: useProvincesStore(),
				regenciesStore: useRegenciesStore(),
				districtsStore: useDistrictsStore(),
				villagesStore: useVillagesStore(),
				cleaveOption: {
					date: {
						date: true,
						datePattern: ['Y', 'm', 'd'],
						delimiter: '-',
					},
					number12: {
						numeral: true,
						numeralIntegerScale: 12,
						numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: '',
					},
					number3: {
						numeral: true,
						numeralIntegerScale: 3,
						numeralDecimalScale: 0,
						stripLeadingZeroes: false,
					},
					numeric: {
						numeral: true,
						numeralThousandsGroupStyle: 'thousand',
						numeralDecimalScale: 2,
						numeralDecimalMark: ',',
						delimiter: '.',
					},
				},
			};
		},
		created() {
			this.fetch();
		},
		methods: {
			fetch() {
				this.provincesStore.get();
			},
			changeProvinces(id) {
				this.regenciesStore.indexProvinces(id);
			},
			changeRegencies(id) {
				this.districtsStore.indexRegencies(id);
			},
			changeDistricts(id) {
				this.villagesStore.indexDistricts(id);
			},
		},
		computed: {
			modelProvinces() {
				return this.provincesStore.dataS;
			},
			modelProvincesStat() {
				return this.provincesStore.dataStatS;
			},
			modelRegencies() {
				return this.regenciesStore.dataS;
			},
			modelRegenciesStat() {
				return this.regenciesStore.dataStatS;
			},
			modelDistricts() {
				return this.districtsStore.dataS;
			},
			modelDistrictsStat() {
				return this.districtsStore.dataStatS;
			},
			modelVillages() {
				return this.villagesStore.dataS;
			},
			modelVillagesStat() {
				return this.villagesStore.dataStatS;
			},
		},
	}
</script>