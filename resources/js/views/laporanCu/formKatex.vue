<template>
	<div>
		<h5 class="text-semibold">RUMUS</h5>

		<!-- katex1 -->
		<template v-for="(katex, k1) in modalKatex.katex1" :key="k1">
		<div v-if="katex && katex.content">
			<p v-if="katex.title"><b>Keterangan:</b> {{katex.title}}</p>
			<div class="card ">
				<div class="card-body text-center pre-scrollable">
					<div v-katex="katex.content"></div>
				</div>
			</div>
		</div>
		</template>
 
		<!-- indikator -->
		<div class="alert bg-info alert-styled-left mt-2 pt-1 pb-1">
			<span class="mb-5 text-semibold"><u>Indikator:</u></span>
			<p v-html="modalKatex.indikator"></p>
		</div>
		
		<!-- separator	 -->
		<hr>

		<h5 class="text-semibold">PERHITUNGAN <small>{{ modalKatex.section }}</small></h5>

		<!-- katex2 -->
		<template v-for="(katex, k2) in modalKatex.katex2" :key="k2">
		<div v-if="katex && katex.content">
			<p v-if="katex.title"><b>Keterangan:</b> {{katex.title}}</p>
			<div class="well mb-2 pre-scrollable text-center">
				<div v-katex="katex.content"></div>
			</div>
		</div>
		</template>

		<!-- ubah -->
		<form @submit.prevent="save">
		<hr v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
		<div class="row" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<template v-for="(form, fi) in modalKatex.form" :key="fi">
				<div class="col-sm-6" v-if="form && !form.hideForm && form.title">
					<div class="form-group">

						<!-- title -->
						<h5>{{form.title}}:</h5>

						<!-- value -->
						<cleave 
							v-model="form.value" 
							class="form-control" 
							:options="cleaveOption.numeric"
							:placeholder="'Silahkan masukkan ' + form.title"></cleave>
					</div>
				</div>
				</template>

		</div>
		
		<hr>
		<div class="text-center d-none d-md-block">
			<button type="button" @click.prevent="modalTutup" class="btn btn-light">
				<i class="icon-cross"></i> Tutup
			</button>
			<button type="button" @click.prevent="modalKatex.isUbah = true" class="btn btn-light" v-if="!modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-pencil5"></i> Ubah
			</button>

			<button type="button" @click.prevent="modalKatex.isUbah = false" class="btn btn-light" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-arrow-left13"></i> Batal
			</button>
			<button type="submit" class="btn btn-primary" v-if="modalKatex.isUbah">
				<i class="icon-floppy-disk"></i> Simpan
			</button>
		</div>

		<div class="d-block d-md-none">

			<button type="submit" class="btn btn-primary btn-block" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-floppy-disk"></i> Simpan
			</button>

			<button type="button" @click.prevent="modalKatex.isUbah = false" class="btn btn-light btn-block" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-arrow-left13"></i> Batal
			</button>

			<button type="button" @click.prevent="modalKatex.isUbah = true" class="btn btn-light btn-block" v-if="!modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-pencil5"></i> Ubah
			</button>

			<button type="button" @click.prevent="modalTutup" class="btn btn-light btn-block">
				<i class="icon-cross"></i> Tutup
			</button>
			
		</div>

		</form>
	</div>
</template>

<script>
	import _ from 'lodash';
	import Cleave from 'vue-cleave-component';
	import { useAuthStore } from '../../stores/auth';
	import { useLaporanTpStore } from '../../stores/laporanTp';
	import { useLaporanCuStore } from '../../stores/laporanCu';

	export default {
		components: {
			Cleave,
		},
		props: ['modalKatex', 'kelas'],
		setup() {
			return {
				authStore: useAuthStore(),
			laporanTpStore: useLaporanTpStore(),
			laporanCuStore: useLaporanCuStore(),
			};
		},
		data() {
			return {cleaveOption: {
					numeric: {
						numeral: true,
						numeralThousandsGroupStyle: 'thousand',
						numeralDecimalScale: 2,
						numeralDecimalMark: ',',
						delimiter: '.',
					},
				},
				form: {},
			};
		},
		methods: {
			save() {
				this.form = _.chain(this.modalKatex.form).keyBy('key').mapValues('value').value();
				this.form.periode = this.modalKatex.periode;

				if (this.modalKatex.id_tp) {
					this.form.id_tp = this.modalKatex.id_tp;
					this.form.no_tp = this.modalKatex.no_tp;
					this.form.id_cu = this.modalKatex.id_cu;
					this.form.no_ba = this.modalKatex.no_ba;
					this.laporanTpStore.update([this.modalKatex.id, this.form]);
				} else {
					this.form.id_cu = this.modalKatex.id_cu;
					this.form.no_ba = this.modalKatex.no_ba;
					this.laporanCuStore.update([this.modalKatex.id, this.form]);
				}
			},
			modalTutup() {
				this.$emit('tutup');
			},
			formatPeriode(value) {
				return this.$filters?.dateMonth ? this.$filters.dateMonth(value) : value;
			},
			formatCurrency(value) {
				return this.$filters?.currency ? this.$filters.currency(value, '', 0, { thousandsSeparator: '.' }) : value;
			},
			formatPercentage(value) {
				return this.$filters?.percentage2 ? this.$filters.percentage2(value, 2) : value;
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
		},
	}
</script>