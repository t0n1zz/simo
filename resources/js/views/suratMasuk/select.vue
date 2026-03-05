<template>
	<div>

		<!-- desktop --> 
		<div class="card d-none d-md-block d-print-none">
			<div class="card-body">

				<!-- periode -->
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Pilih Periode</span>
					</div>
					<select class="form-control" name="periode" v-model="periode" data-width="100%" @change="changePeriode($event.target.value)" :disabled="modelDataStat === 'loading'">
						<option disabled value="">Silahkan pilih periode</option>
						<option value="semua">Semua</option>
						<option disabled value="">----------------</option>
						<option v-for="(data, index) in modelData" :value="data" :key="index">{{data}}</option>
					</select>

					<!-- reload -->
					<div class="input-group-append">
						<button class="btn btn-light" @click="fetchData" :disabled="modelDataStat === 'loading'">
							<i class="icon-sync" :class="{'spinner' : modelDataStat === 'loading'}"></i>
						</button>
					</div>
				</div>
 
			</div>
		</div>		

		<!-- mobile -->
		<div class="card d-block d-md-none d-print-none">
			<div class="card-body"> 

				<!-- periode -->
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Pilih Data</span>
					</div>
					<select class="form-control" name="periode" v-model="periode" data-width="100%" @change="changePeriode($event.target.value)"  :disabled="modelDataStat === 'loading'">
						<option disabled value="">Silahkan pilih periode</option>
						<option value="semua">Semua</option>
						<option disabled value="">----------------</option>
						<option v-for="(data, index) in modelData" :key="index" :value="data">{{data}}</option>
					</select>
				</div>

				<!-- reload  -->
				<div class="pt-2">
					<button class="btn btn-light btn-lg btn-block" @click="fetchData" :disabled="modelDataStat === 'loading'">
						<i class="icon-sync" :class="{'spinner' : modelDataStat === 'loading'}"></i> Reload
					</button>
				</div>

			</div>
		</div>

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import { useSuratMasukStore } from '../../stores/suratMasuk';

	export default {
		props: ['kelas'],
		data() {
			return {
				authStore: useAuthStore(),
				suratMasukStore: useSuratMasukStore(),
				periode: '',
			};
		},
		created() {
			this.fetchData();
		},
		watch: {
			$route() {
				this.fetchData();
			},
			modelDataStat(value) {
				if (value === 'success') {
					this.periode = this.$route.params.periode;
				}
			},
		},
		methods: {
			fetch() {
				this.$router.push({ name: this.kelas + 'Cu', params: { cu: this.$route.params.cu, periode: this.periode } });
			},
			fetchData() {
				if (this.modelData.length === 0) {
					this.suratMasukStore.fetchPeriode(this.$route.params.cu);
				}
				this.periode = this.$route.params.periode;
			},
			changePeriode(periode) {
				this.fetch();
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			modelData() {
				return this.suratMasukStore.periode;
			},
			modelDataStat() {
				return this.suratMasukStore.periodeStat;
			},
		},
	}
</script>