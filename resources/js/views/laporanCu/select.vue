<template>
	<div>

		<!-- cu desktop --> 
		<div class="card d-print-none" >
			<div class="card-body">  
				<div class="row">
					
					<!-- cu -->
					<div class="col-sm-5" v-if="this.currentUser.id_cu === 0">
						<div class="input-group" v-if="this.currentUser.id_cu === 0">
							<span class="input-group-prepend">
								 <span class="input-group-text">Pilih Data</span>
							</span>

							<!-- select -->
							<select class="form-control" name="idCu" v-model="idCu" data-width="100%" @change="changeCu($event.target.value)" :disabled="modelCuStat === 'loading'">
								<option disabled value="">Silahkan pilih data</option>
								<slot></slot>
								<option value="semua">Semua CU</option>
								<option disabled value="">----------------</option>
								<template v-for="cu in modelCu" :key="cu ? cu.id : undefined">
								<option v-if="cu" :value="cu.id">{{cu.name}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" @click="fetchCU" :disabled="modelCuStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelCuStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- periode cu -->
					<div class="col-sm-5" v-if="idCu == 'semua'">
						<div class="input-group" v-if="this.currentUser.id_cu === 0">
							<span class="input-group-prepend">
								<span class="input-group-text">Pilih Periode</span>
							</span>

							<!-- select -->
							<select class="form-control" name="periode" v-model="periode" data-width="100%" 
							:disabled="modelPeriodeStat === 'loading'">
								<option disabled value="">Silahkan pilih periode laporan</option>
								<slot></slot>
								<template v-for="periode in modelPeriode" :key="periode ? periode.periode : undefined">
								<option v-if="periode" :value="periode.periode">{{periode.periode | dateMonth}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" @click="fetchPeriode" :disabled="modelPeriodeStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelPeriodeStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- tp  -->
					<div :class="classTp()" v-else>
						<div class="input-group">
							<span class="input-group-prepend">
								<span class="input-group-text">Pilih TP/KP</span>
							</span>

							<!-- select -->
							<select class="form-control" name="tp" v-model="idTp" data-width="100%" :disabled="modelTpStat === 'loading'" @change="changeTp($event.target.value)">
								<option disabled value="">Silahkan pilih TP/KP</option>
								<option value="konsolidasi">Konsolidasi</option>
								<option value="semua">Semua Tp</option>
								<option disabled value="">----------------</option>
								<template v-for="tp in modelTp" :key="tp ? tp.id : undefined">
								<option v-if="tp" :value="tp.id">{{tp.name}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" @click="fetchPeriode" :disabled="modelPeriodeStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelCuStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- periode tp -->
					<div :class="[{'col-sm-10': currentUser.id_cu == 0 && idTp == 'semua',
					'col-sm-6': currentUser.id_cu != 0 && idTp == 'semua'},{'pt-2': currentUser.id_cu == 0}]" v-if="idTp == 'semua' && idCu != 'semua'">
						<div class="input-group">
							<span class="input-group-prepend">
								<span class="input-group-text">Pilih Periode</span>
							</span>

							<!-- select -->
							<select class="form-control" name="periodeTp" v-model="periodeTp" data-width="100%" @change="changeTpPeriode($event.target.value)"
							:disabled="modelPeriodeTpStat === 'loading'">
								<option disabled value="">Silahkan pilih periode laporan Tp</option>
								<slot></slot>
								<template v-for="periode in modelPeriodeTp" :key="periode ? periode.periode : undefined">
								<option v-if="periode" :value="periode.periode">{{periode.periode | dateMonth}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" @click="fetchPeriodeTp" :disabled="modelPeriodeTpStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelPeriodeTpStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- find data button -->
					<div class="col-sm-2" :class="{'pt-2': idCu !='semua' && idTp == 'semua'}" v-if="this.currentUser.id_cu === 0">
						<button type="button" class="btn btn-light btn-icon btn-block" @click.prevent="fetch()" v-if="itemDataStat != 'loading'">
							<i class="icon-folder-open3"></i>  Tampilkan
						</button>
						<button type="button" class="btn btn-light btn-icon btn-block" v-else>
							<i class="icon-sync spinner"></i>
						</button>
					</div>
				</div>
					
			</div>
		</div>		

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useCuStore } from '../../stores/cu';
	import { useTpStore } from '../../stores/tp';
	import { useLaporanCuStore } from '../../stores/laporanCu';
	import { useLaporanTpStore } from '../../stores/laporanTp';
	export default {
		props:['kelas','path'],
		data(){
			return {
				idCu: '',
				idTp: '',
				periode: '',
				periodeTp: ''
			}
		},
		created(){
			if(this.currentUser.id_cu != undefined){
				this.checkProfileIdCU();
			}
		},
		watch: {
			'$route' (to, from){
				// check current page meta
				this.checkProfileIdCU(); 
			},
			modelCuStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'cu' || this.$route.meta.mode == 'cuPeriode'){			
						this.idCu = this.$route.params.cu;
						this.changeCu(this.idCu);
					}else{
						this.idCu = 'semua';
						this.changeCu(this.idCu);
					}
				}
			},
			modelTpStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'cu'){
						this.idTp = this.$route.params.tp;
					}else if(this.$route.meta.mode == 'cuPeriode'){
						this.idTp = 'semua';
						this.changeTp(this.idTp);
					}else{
						this.idTp = 'konsolidasi';
					}
				}
			},
			modelPeriodeStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'periode'){
						this.periode = this.$route.params.periode;
					}else{
						this.periode = this.modelPeriode[0].periode;
					}
				}
			},
			modelPeriodeTpStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'cuPeriode'){
						this.periodeTp = this.$route.params.periode;
					}else{
						this.periodeTp = this.modelPeriodeTp[0].periode;
					}
					this.changeTpPeriode(this.periodeTp);
				}
			}
    },
		methods: {
			...mapActions(useCuStore, {
				getCuHeader: 'getHeader',
			}),
			...mapActions(useTpStore, {
				getTpCu: 'getCu',
			}),
			...mapActions(useLaporanCuStore, {
				getLaporanCuPeriode: 'getPeriode',
			}),
			...mapActions(useLaporanTpStore, {
				getLaporanTpPeriode: 'getPeriode',
			}),
			checkProfileIdCU(){
				if(this.currentUser.id_cu !== 0){
					this.idCu = this.currentUser.id_cu;
					this.fetchTp();
				}else{
					this.fetchCU();
				}
			},
			fetch(){
				if(this.idCu != 'semua'){
					if(this.idTp != 'semua'){
						this.$router.push({name: 'laporanCuCu', params:{cu: this.idCu, tp: this.idTp} });
					}else{
						this.$router.push({name: 'laporanCuCuPeriode', params:{cu: this.idCu, periode: this.periodeTp} });
					}
				}else{
					this.$router.push({name: 'laporanCuPeriode', params:{periode: this.periode} });
				}
			},
			fetchCU(){
				if(this.modelCu.length == 0){
					this.getCuHeader(this.currentUser.id_pus);
				}else{
					if(this.$route.meta.mode == 'cu' || this.$route.meta.mode == 'cuPeriode'){			
						this.idCu = this.$route.params.cu;
						this.changeCu(this.idCu);
					}else{
						this.idCu = 'semua';
						this.changeCu(this.idCu);
					}
				}
			},
			fetchPeriode(){
				this.getLaporanCuPeriode();
			},
			fetchPeriodeTp(){
				this.getLaporanTpPeriode();
			},
			fetchTp(){
				this.getTpCu(this.idCu);
			},
			changeCu(value){
				if(value != 'semua'){
					this.fetchTp();
				}else{
					this.fetchPeriode();
				}
				this.idTp = '';
			},
			changeTp(value){
				if(this.currentUser.id_cu != 0){
					if(this.idTp != 'semua'){
						this.$router.push({name: 'laporanCuCu', params:{cu: this.currentUser.id_cu, tp: value} });
					}else{
						this.getLaporanTpPeriode();
					}
				}else{
					if(this.idTp == 'semua'){
						this.getLaporanTpPeriode();
					}
				}
			},
			changeTpPeriode(value){
				if(this.currentUser.id_cu != 0){
					this.$router.push({name: 'laporanCuCuPeriode', params:{cu: this.currentUser.id_cu, periode: value} });
				}
			},
			classTp(){
				let className = '';
				if(this.currentUser.id_cu == 0){
					className = 'col-sm-5';
				}else{
					if(this.idTp == 'semua'){
						className = 'col-sm-6';
					}else{
						className = 'col-sm-12';
					}
				}
				return className;
			}
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useLaporanCuStore,{
				modelPeriode: 'periode',
				modelPeriodeStat: 'periodeStat',
				itemDataStat: 'dataStatS',
			}),
			...mapState(useLaporanTpStore,{
				modelPeriodeTp: 'periode',
				modelPeriodeTpStat: 'periodeStat',
			}),
			...mapState(useCuStore,{
				modelCu: 'headerDataS',
				modelCuStat: 'headerDataStatS',
				updateMessage: 'update',
				updateStat: 'updateStat'
			}),
			...mapState(useTpStore,{
				modelTp: 'dataS',
				modelTpStat: 'dataStatS',
			}),
		}
	}
</script>