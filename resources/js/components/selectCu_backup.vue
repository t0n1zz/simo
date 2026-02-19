<template>
	<div>

		<!-- cu desktop --> 
		<div class="card d-none d-md-block d-print-none">
			<div class="card-body">  
					<div class="input-group" v-if="this.currentUser.id_cu === 0">
						<div class="input-group-prepend">
							<span class="input-group-text">Pilih Data</span>
						</div>

						<!-- select -->
						<select class="form-control" name="idCu" v-model="idCu" data-width="100%" @change="changeCU($event.target.value)" :disabled="modelCuStat === 'loading'">
							<option disabled value="">Silahkan pilih data</option>
							<slot></slot>
							<option value="semua">Semua CU</option>
							<option value="0" v-if="isPus"><span v-if="currentUser.pus">{{currentUser.pus.name}}</span> <span v-else>PUSKOPCUINA</span></option>
							<option disabled value="">----------------</option>
							<option v-for="cu in modelCu" :value="cu.id" v-if="cu">{{cu.name}}</option>
						</select>

						<!-- reload cu -->
						<div class="input-group-append">
							<button class="btn btn-light" @click="fetchCU" :disabled="modelCuStat === 'loading'">
								<i class="icon-sync" :class="{'spinner' : modelCuStat === 'loading'}"></i>
							</button>
						</div>
					</div>
			</div>
		</div>		

		<div class="card d-block d-md-none d-print-none">
			<div class="card-body">  
				<!-- select -->
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Pilih Data</span>
					</div>
					<select class="form-control" name="idCu" v-model="idCu" data-width="100%" @change="changeCU($event.target.value)" :disabled="modelCuStat === 'loading'">
						<option disabled value="">Silahkan pilih data</option>
						<option value="semua">Semua CU</option>
						<option value="0" v-if="isPus"><span v-if="currentUser.pus">{{currentUser.pus.name}}</span> <span v-else>PUSKOPCUINA</span></option>
						<option disabled value="">----------------</option>
						<option v-for="cu in modelCu" :value="cu.id" v-if="cu">{{cu.name}}</option>
					</select>
				</div>

				<!-- reload cu -->
				<div class="pt-2">
					<button class="btn btn-light btn-lg btn-block" @click="fetchCU" :disabled="modelCuStat === 'loading'">
						<i class="icon-sync" :class="{'spinner' : modelCuStat === 'loading'}"></i> Reload
					</button>
				</div> 
			</div>
		</div>

	</div>
</template>

<script>
	import { useAuthStore } from '../stores/auth';
	import { useCuStore } from '../stores/cu';

	export default {
		props:['kelas','isPus','path'],
		data(){
			return {
				authStore: useAuthStore(),
				cuStore: useCuStore(),
				idCu: ''
			}
		},
		created(){
			if(this.currentUser && this.currentUser.id_cu !== undefined){
				this.fetchCU();
			}		},
		watch: {
			'$route' (to, from){
				// check current page meta
				this.fetchCU();
			},
			modelCuStat(value){
				if(value === "success"){
					this.idCu = this.$route.params.cu;
				}
			},
    },
		methods: {
			fetchCU(){
				if(!this.modelCu || this.modelCu.length == 0){
					this.cuStore.getHeader();
				}
				if(this.$route.params.cu){
				this.idCu = this.$route.params.cu;
			}
	
			},
			changeCU(id){
				this.$router.push({name: this.path, params:{cu: id} });
			}
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			modelCu() {
				return this.cuStore.headerDataS;
			},
			modelCuStat() {
				return this.cuStore.headerDataStatS;
			},
			updateMessage() {
				return this.cuStore.update;
			},
			updateStat() {
				return this.cuStore.updateStat;
			}
		}
	}
</script>