<template>
	<div>

		<!-- cu desktop --> 
		<div class="card d-print-none" >
			<div class="card-body">  
				<div class="row">
					
					<!-- cu -->
					<div class="col-sm-5" v-if="this.currentUser.id_cu === 0">
						<div class="input-group">
							<div class="input-group-prepend">
								 <span class="input-group-text">Pilih Data</span>
							</div>

							<!-- select -->
							<select class="form-control" name="idCu" v-model="idCu" data-width="100%" @change="changeCu($event.target.value)"  :disabled="modelCUStat === 'loading'">
								<option disabled value="">Silahkan pilih data</option>
								<slot></slot>
								<template v-for="cu in modelCU" :key="cu ? cu.id : undefined">
								<option v-if="cu" :value="cu.id">{{cu.name}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" v-tooltip:top="'Reload'" @click="fetchCU" :disabled="modelCUStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelCUStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- periode -->
					<div class="col-sm-5">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">Pilih Periode</span>
							</div>

							<!-- select -->
							<select class="form-control" name="periode" v-model="periode" data-width="100%" @change="changePeriode($event.target.value)"
							:disabled="modelPeriodeStat === 'loading'">
								<option disabled value="">Silahkan pilih periode laporan</option>
								<slot></slot>
								<template v-for="periode in modelPeriode" :key="periode ? periode.periode : undefined">
								<option v-if="periode" :value="periode.periode">{{periode.periode | dateMonth}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" v-tooltip:top="'Reload'" @click="fetchPeriode(idCu)" :disabled="modelPeriodeStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelPeriodeStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- tp  -->
					<div :class="{'col-sm-5': this.currentUser.id_cu != 0, 'col-sm-10 pt-2' : this.currentUser.id_cu == 0}">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">Pilih TP/KP</span>
							</div>

							<!-- select -->
							<select class="form-control" name="idTp" v-model="idTp" data-width="100%" :disabled="modelTpStat === 'loading'">
								<option disabled value="">Silahkan pilih TP/KP</option>
								<option value="konsolidasi">Konsolidasi</option>
								<option disabled v-if="modelTp && modelTp.length != 0">----------------</option>
								<template v-for="tp in modelTp" :key="tp ? tp.id : undefined">
								<option v-if="tp && tp.tp" :value="tp.id">{{tp.tp.name}}</option>
							</template>
							</select>

							<!-- reload -->
							<div class="input-group-append">
								<button class="btn btn-light" v-tooltip:top="'Reload'" @click="fetchTp(idCu,periode)" :disabled="modelPeriodeStat === 'loading'">
									<i class="icon-sync" :class="{'spinner' : modelCUStat === 'loading'}"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- find data button -->
					<div class="col-sm-2" :class="{'pt-2': this.currentUser.id_cu == 0}">
						<button type="button" class="btn btn-light btn-icon btn-block" v-tooltip:top="'Tampilkan data sesuai pilihan'" @click.prevent="fetch()" v-if="itemDataStat != 'loading'">
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
	import _ from 'lodash';
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useLaporanCuStore } from '../../stores/laporanCu';
	import { useLaporanTpStore } from '../../stores/laporanTp';
	import { useCuStore } from '../../stores/cu';
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
			this.checkProfileIdCU();
		},
		watch: {
			itemDataStat(value){
				if(value === "success"){
					if(this.currentUser.id_cu == 0){
						this.fetchCU();
					}
					this.periode = this.itemData.periode;
					this.changePeriode(this.periode);
				}
			},
			modelCUStat(value){
				if(value === "success"){
					if(this.itemDataStat == 'success'){
						if(this.$route.meta.mode == 'detail'){
								this.idCu = this.itemData.id_cu;
						}else{
							this.idCu = this.itemData.tp.id_cu;
						}
					}
					this.changeCu(this.idCu);
				}
			},
			modelTpStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'detail'){
						this.idTp = 'konsolidasi';
					}else{
						this.idTp = this.itemData.id;
					}
				}
			},
			modelPeriodeStat(value){
				if(value === "success"){
					if(this.itemDataStat == 'success'){
						this.periode = this.itemData.periode;
						this.changePeriode(this.periode);
					}
				}
			}
    },
		methods: {
			...mapActions(useCuStore, ['getHeader']),
			...mapActions(useLaporanCuStore, ['getPeriodeCu']),
			...mapActions(useLaporanTpStore, ['getPeriodeTp']),
			checkProfileIdCU(){
				if(this.currentUser.id_cu !== 0){
					this.idCu = this.currentUser.id_cu;
					this.changeCu(this.idCu);
				}else{
					this.fetchCU();  
				}
			},
			fetch(){
				if(this.idTp == 'konsolidasi'){
					let periode = 0;
					periode = _.find(this.modelPeriode, {'periode':this.periode})
					this.$router.push({name: 'laporanCuDetail', params: { id: periode.id }});
				}else{
					this.$router.push({name: 'laporanTpDetail', params: { id: this.idTp }});
				}
			},
			fetchCU(){
				if(this.modelCuStat != 'success'){
					this.getHeader();
				}
			},
			fetchPeriode(id){
				this.getPeriodeCu(id);
			},
			fetchTp(id, periode){
				this.getPeriodeTp([id,periode]);
			},
			changeCu(value){
				if(value){
					this.fetchPeriode(value);
				}
			},
			changePeriode(value){
				if(this.idCu){
					this.fetchTp(this.idCu, value);
				}	
			}
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useLaporanCuStore,{
				itemData: 'data',
				itemDataStat: 'dataStat',
				modelPeriode: 'periode',
				modelPeriodeStat: 'periodeStat',
			}),
			...mapState(useLaporanTpStore,{
				modelTp: 'dataS',
				modelTpStat: 'dataStatS',
			}),
			...mapState(useCuStore,{
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
				updateMessage: 'update',
				updateStat: 'updateStat'
			}),
		}
	}
</script>