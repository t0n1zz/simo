<template>
	<div>

		<div class="card d-print-none" >
			<div class="card-body">  
				<div class="row">

					<!-- tanggal pencairan -->
					<div class="col-sm-12">
						<div class="input-group">
							<span class="input-group-prepend">
								<span class="input-group-text">Pilih Tanggal Pencairan</span>
							</span>

							<!-- select -->
							<select class="form-control" name="pencairan" v-model="pencairan" data-width="100%" @change="changePencairan($event.target.value)"
							:disabled="modelPencairanStat === 'loading'">
								<option disabled value="">Silahkan pilih tanggal pencairan</option>
								<slot></slot>
								<template v-for="pencairan in modelPencairan" :key="pencairan ? pencairan.tanggal_pencairan : undefined">
								<option v-if="pencairan" :value="pencairan.tanggal_pencairan">
									{{ pencairan.tanggal_pencairan | dateMonth }}
								</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" @click="fetchPencairan" :disabled="modelPencairanStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelPencairanStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

				</div>					
			</div>
		</div>		

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import { useJalinanKlaimStore } from '../../stores/jalinanKlaim';

	export default {
		data() {
			return {
				authStore: useAuthStore(),
				jalinanKlaimStore: useJalinanKlaimStore(),
				pencairan: '',
			};
		},
		created() {
			this.fetchPencairan();
		},
		watch: {
			$route() {
				this.pencairan = '';
				this.fetchPencairan();
			},
			modelPencairanStat(value) {
				if (value === 'success') {
					if (this.$route.meta.mode === 'cair') {
						this.pencairan = this.$route.params.awal;
					}
				}
			},
		},
		methods: {
			fetchPencairan() {
				this.jalinanKlaimStore.getPencairan();
			},
			changePencairan(value) {
				this.$router.push({ name: 'jalinanCairTanggal', params: { awal: value, cu: 'semua', tp: 'semua' } });
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			modelPencairan() {
				return this.jalinanKlaimStore.periode;
			},
			modelPencairanStat() {
				return this.jalinanKlaimStore.periodeStat;
			},
		},
	}
</script>