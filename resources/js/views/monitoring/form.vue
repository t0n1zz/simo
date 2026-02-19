<template>
	<div>
		<!-- page-header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<!-- message -->
					<message v-if="v$.form.$error && submited" :title="'Oops, terjadi kesalahan'" :errorItem="v$.form.$errors">
					</message>

					<!-- main panel -->
					<form @submit.prevent="save">

						<!-- main form -->
						<div class="card">
							<div class="card-body">
								
								<div class="row">

									<!-- temuan -->
									<div class="col-md-12">
										<div class="form-group" :class="{'has-error' : v$.form.name.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.name.$error}">
												<i class="icon-cross2" v-if="v$.form.name.$error"></i>
												Temuan: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<input type="text" name="name" class="form-control" placeholder="Silahkan masukkan temuan artikel" v-model="form.name">

											<!-- error message -->
											<small class="text-muted text-danger" v-if="v$.form.name.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.name.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- CU -->
									<div class="col-md-6" v-if="currentUser.id_cu === 0">
										<div class="form-group" :class="{'has-error' : v$.form.id_cu.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.id_cu.$error}">
												<i class="icon-cross2" v-if="v$.form.id_cu.$error"></i>
												CU: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control" name="id_cu" v-model="form.id_cu" data-width="100%" :disabled="modelCU.length === 0" @change="changeCU($event.target.value)">
												<option disabled value="">
													<span v-if="modelCUStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih CU</span>
												</option>
												<option v-for="(cu, index) in modelCU" :value="cu.id" :key="index">{{cu.name}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="v$.form.id_cu.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.id_cu.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- TP -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : v$.form.id_tp.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.id_tp.$error}">
												<i class="icon-cross2" v-if="v$.form.id_tp.$error"></i>
												TP: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control" name="id_tp" v-model="form.id_tp" data-width="100%" :disabled="modelTP.length === 0">
												<option disabled value="">
													<span v-if="modelTPStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih TP</span>
												</option>
												<option value="0">Semua</option>
												<option v-for="(tp, index) in modelTP" :value="tp.id" :key="index">{{tp.name}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="v$.form.id_tp.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.id_tp.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- PIC CU -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : v$.form.id_aktivis_cu.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.id_aktivis_cu.$error}">
												<i class="icon-cross2" v-if="v$.form.id_aktivis_cu.$error"></i>
												PIC CU: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control" name="id_aktivis_cu" v-model="form.id_aktivis_cu" data-width="100%" :disabled="modelAktivisCU.length === 0">
												<option disabled value="">
													<span v-if="modelAktivisCUStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih PIC</span>
												</option>
												<option v-for="(ac, index) in modelAktivisCU" :key="index" :value="ac.id">{{ac.name}} {{ac.pekerjaan_aktif ? ' - ' + ac.pekerjaan_aktif.name : ''}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="v$.form.id_aktivis_cu.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.id_aktivis_cu.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- PIC BKCU -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : v$.form.id_aktivis_bkcu.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.id_aktivis_bkcu.$error}">
												<i class="icon-cross2" v-if="v$.form.id_aktivis_bkcu.$error"></i>
												PIC PUSKOPCUINA: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control" name="id_aktivis_bkcu" v-model="form.id_aktivis_bkcu" data-width="100%" :disabled="modelAktivisBKCU.length === 0">
												<option disabled value="">
													<span v-if="modelAktivisBKCUStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih PIC</span>
												</option>
												<option v-for="(ac, index) in modelAktivisBKCU" :key="index" :value="ac.id">{{ac.name}} {{ac.pekerjaan_aktif ? ' - ' + ac.pekerjaan_aktif.name : ''}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="v$.form.id_aktivis_bkcu.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.id_aktivis_bkcu.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>
									
									<!-- tanggal -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : v$.form.tanggal.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.tanggal.$error}">
												<i class="icon-cross2" v-if="v$.form.tanggal.$error"></i>
												Tanggal: <wajib-badge></wajib-badge>
											</h5>

											<!-- input -->
											<date-picker @dateSelected="form.tanggal = $event" :defaultDate="form.tanggal"></date-picker>	
											<input v-model="form.tanggal" v-show="false"/>

											<!-- error message -->
											<br/>
											<small class="text-muted text-danger" v-if="v$.form.tanggal.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.tanggal.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;
											</small>
										</div>
									</div>

									<!-- jenis -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : v$.form.jenis.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.jenis.$error}">
												<i class="icon-cross2" v-if="v$.form.jenis.$error"></i>
												Jenis: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select name="jenis" data-width="100%" class="form-control" v-model="form.jenis">
												<option disabled value="">Silahkan pilih jenis</option>
												<option value="MAYOR">MAYOR</option>
												<option value="MINOR">MINOR</option>
											</select>

											<!-- error message -->
											<br/>
											<small class="text-muted text-danger" v-if="v$.form.jenis.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.jenis.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;
											</small>
										</div>
									</div>

									<!-- aspek -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : v$.form.aspek.$error}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : v$.form.aspek.$error}">
												<i class="icon-cross2" v-if="v$.form.aspek.$error"></i>
												Aspek: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select name="aspek" data-width="100%" class="form-control" v-model="form.aspek">
												<option disabled value="">Silahkan pilih aspek</option>
												<option value="KEUANGAN">KEUANGAN</option>
												<option value="SOSIAL">SOSIAL</option>
												<option value="OPERASIONAL">OPERASIONAL</option>
												<option value="KEPATUHAN">KEPATUHAN</option>
											</select>

											<!-- error message -->
											<br/>
											<small class="text-muted text-danger" v-if="v$.form.aspek.$error">
												<i class="icon-arrow-small-right"></i> {{ v$.form.aspek.$errors[0]?.$message }}
											</small>
											<small class="text-muted" v-else>&nbsp;
											</small>
										</div>
									</div> 
								

								</div>
								
							</div>
						</div>

						<!-- rekomendasi -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">Rekomendasi <wajib-badge></wajib-badge></h5>
							</div>
							<div class="card-body pb-2">
								<div class="row">

									<div class="col-md-12">

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('tambahRekom')">
											<i class="icon-plus22"></i> Tambah
										</button>

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('ubahRekom')"
										:disabled="!selectedItemRekom.index">
											<i class="icon-pencil5"></i> Ubah
										</button>

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('hapusRekom')" :disabled="!selectedItemRekom.index">
											<i class="icon-bin2"></i> Hapus
										</button>

									</div>

								</div>		
							</div>

							<data-table :items="itemDataRekom" :columnData="columnDataRekom" :itemDataStat="itemDataRekomStat">
								<template #item-desktop="props">
									<tr :class="{ 'bg-info': selectedItemRekom.index === props.index + 1 }" class="text-nowrap" @click="selectedRekomRow(props.index,props.item)" v-if="props.item">
										<td>{{ props.index + 1 }}</td>
										<td v-html="$filters.checkStatus(props.item.status)"></td>
										<td>{{ props.item.rekomendasi }}</td>
									</tr>
								</template>	
							</data-table>

						</div>

						<!-- form info -->
						<form-info></form-info>	

						<!-- form button -->
						<div class="card card-body">
							<form-button
								:cancelState="'methods'"
								:formValidation="'form'"
								@cancelClick="back"></form-button>
						</div>
						
					</form>

				</div>
			</div>
		</div>

		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :color="modalColor"
		 @batal="modalTutup" @confirmOk="modalConfirmOk" @tutup="modalTutup" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalBackgroundClick">

			<!-- title -->
			<template #modal-title>
				{{ modalTitle }}
			</template>

			<!-- rekomendasi -->
			<template #modal-body3>
				<form-rekom 
				:mode="formRekomMode"
				:selected="selectedItemRekom"
				@createRekom="createRekom"
				@editRekom="editRekom"
				@tutup="modalTutup"></form-rekom>
			</template>

		</app-modal>

	</div>
</template>

<script>
	import { useVuelidate } from '@vuelidate/core';
	import { required } from '@vuelidate/validators';
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useMonitoringStore } from '../../stores/monitoring';
	import { useCuStore } from '../../stores/cu';
	import { useTpStore } from '../../stores/tp';
	import { useAktivisStore } from '../../stores/aktivis';
	import pageHeader from "../../components/pageHeader.vue";
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import { getLocalUser } from "../../helpers/auth";
	import { url_config } from '../../helpers/url.js';
	import wajibBadge from "../../components/wajibBadge.vue";
	import infoIcon from "../../components/infoIcon.vue";
	import dataTable from '../../components/datatable.vue';
	import formRekom from "./formRekom.vue";
	import Cleave from 'vue-cleave-component';
	import DatePicker from "../../components/datePicker.vue";
	import { filters } from '../../helpers/filters';

	export default {
		components: {
			pageHeader,
			appModal,
			message,
			formButton,
			formInfo,
			infoIcon,
			wajibBadge,
			dataTable,
			formRekom,
			Cleave,
			DatePicker
		},
		setup() {
			return { v$: useVuelidate() }
		},
		validations() {
			return {
				form: {
					name: { required },
					id_cu: { required },
					id_tp: { required },
					id_aktivis_cu: { required },
					id_aktivis_bkcu: { required },
					tanggal: { required },
					jenis: { required },
					aspek: { required },
				}
			}
		},
		computed: {
			$filters() {
				return filters;
			},
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useMonitoringStore, {
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'updateResponse',
				updateStat: 'updateStat'
			}),
			...mapState(useCuStore, {
				modelCu: 'header',
				modelCuStat: 'headerStat',
			}),
			...mapState(useTpStore, {
				modelTp: 'cu',
				modelTpStat: 'cuStat',
			}),
			...mapState(useAktivisStore, {
				modelAktivis: 'dataS',
				modelAktivisStat: 'dataSStat',
				modelAktivisBKCU: 'dataS2',
				modelAktivisBKCUStat: 'dataS2Stat',
			}),
		},
		data() {
			return {
				title: 'Tambah Temuan PUSKOPCUINA',
				titleDesc: 'Menambah temuan',
				titleIcon: 'icon-plus3',
				level2Title: 'Monitoring PUSKOPCUINA',
				kelas: 'monitoring',
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
					},
				},
				formRekomMode: '',
				selectedItemRekom: '',
				itemDataRekom: [],
				itemDataRekomStat: 'success',
				columnDataRekom:[
					{ title: 'No.' },
					{ title: 'Status' },
					{ title: 'Rekomendasi' },
				],
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				submited: false,
			}
		},
		beforeRouteEnter(to, from, next) {
			next(vm => vm.fetch());
		},
		created(){
			if(this.currentUser.id_cu == 0){
				if(this.modelCuStat != 'success'){
					this.getHeader();
				}
			}

			this.resetDataS2();
			this.get2(0);
		},
		watch: {
			formStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'create'){
						if(this.currentUser.id_cu != 0){
							this.form.id_cu = this.currentUser.id_cu;
							this.changeCU(this.form.id_cu);
						}
					}else{
						this.checkUser('update_monitoring',this.form.id_cu);
						this.changeCU(this.form.id_cu);
						this.fetchRekom();
					}	
				}
			},
			updateStat(value){
				this.modalShow = true;
				this.modalState = value;
				this.modalColor = '';

				if(value === "success"){
					this.modalTitle = this.updateResponse.message;
				}else{
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.updateResponse;
				}
			},
    },
		methods: {
			...mapActions(useMonitoringStore, ['create', 'edit', 'store', 'update', 'resetUpdateStat']),
			...mapActions(useCuStore, { getHeader: 'getHeader' }),
			...mapActions(useTpStore, { getCuTp: 'getCu' }),
			...mapActions(useAktivisStore, { getAktivis: 'get', get2: 'get2', resetDataS: 'resetDataS', resetDataS2: 'resetDataS2' }),
			fetch(){
				if(this.currentUser.id_cu == 0){
					if(this.modelCuStat != 'success'){
						this.getHeader();
					}
				}
				if(this.$route.meta.mode == 'edit'){
					this.edit(this.$route.params.id);	
					this.title = 'Ubah Temuan';
					this.titleDesc = 'Mengubah temuan';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah Temuan';
					this.titleDesc = 'Menambah temuan';
					this.titleIcon = 'icon-plus3';
					this.create();
				}
			},
			fetchRekom(){
				this.itemDataRekom = [];
				var valData;

				if(this.form.monitoring_rekom){
					for(valData of this.form.monitoring_rekom){
						this.itemDataRekom.push(valData);
					}
				}
			},
			checkUser(permission,id_cu){
				if(this.currentUser){
					if(!this.currentUser.can || !this.currentUser.can[permission]){
						this.$router.push('/notFound');
					}
					if(!id_cu || this.currentUser.id_cu){
						if(this.currentUser.id_cu != 0 && this.currentUser.id_cu != id_cu){
							this.$router.push('/notFound');
						}
					}
				}
			},
			save() {
				this.form.rekomendasi = this.itemDataRekom;
				this.v$.$validate();
				if (!this.v$.$error) {
					if(this.$route.meta.mode === 'edit'){
						this.update([this.$route.params.id, this.form]);
					}else{
						this.store(this.form);
					}
					this.submited = false;
				}else{
					window.scrollTo(0, 0);
					this.submited = true;
				}
			},
			changeCU(id){
				this.getCuTp(id);	
				this.resetDataS();
				this.getAktivis(id);
			},
			back(){
				if(this.currentUser.id_cu == 0){
					this.$router.push({name: this.kelas + 'Cu', params:{cu:'semua', tp: 'semua'}});
				}else{
					this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu, tp: 'semua'}});
				}
			},
			createRekom(value){
				this.itemDataRekom.push(value);
				this.modalTutup();
			},
			editRekom(value){
				_.remove(this.itemDataRekom, {
						index: value.index
				});
				this.itemDataRekom.push(value);
				this.modalTutup(); 
			},
			selectedRekomRow(index,item){
				this.selectedItemRekom = item;
				this.selectedItemRekom.index = index + 1;
			},
			modalOpen(state, isMobile, itemMobile) {
				this.modalShow = true;
				this.state = state;
				
				if (state == 'hapusRekom') {
					this.modalState = 'confirm-tutup';
					this.modalColor = '';
					this.modalTitle = 'Hapus Rekomendasi ' + this.selectedItemRekom.cu.name + ' ?';
					this.modalButton = 'Iya, Hapus';
					this.modalSize = '';
				}else if(state == 'ubahRekom'){
					this.modalState = 'normal3';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Ubah Rekomendasi';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
					this.formRekomMode = 'edit';
				}else if(state == 'tambahRekom'){
					this.modalState = 'normal3';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Tambah Rekomendasi';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
					this.formRekomMode = 'create';
				}
			},
			modalConfirmOk() {
				this.modalShow = false;

				if (this.state == 'hapusRekom') {
					_.remove(this.itemDataRekom, {
						index: this.selectedItemRekom.index
					});
				}
			},
			modalTutup() {
 				if(this.updateStat == 'success'){
					this.back();
					this.resetUpdateStat();
				}

				this.modalShow = false;
			},
			modalBackgroundClick(){
				if(this.modalState === 'success'){
					this.modalTutup;
				}else if(this.modalState === 'loading'){
					// do nothing
				}else{
					this.modalShow = false
				}
			},
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useMonitoringStore,{
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'update',
				updateStat: 'updateStat'
			}),
			...mapState(useCuStore,{
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
			}),
			...mapState(useTpStore,{
				modelTP: 'dataS',
				modelTPStat: 'dataStatS',
			}),
			...mapState(useAktivisStore,{
				modelAktivisCU: 'dataS',
				modelAktivisBKCU: 'dataS2',
				modelAktivisCUStat: 'dataStatS',
				modelAktivisBKCUStat: 'dataStatS2',
			}),
		}
	}
</script>

<style scoped src="../../../../public/css/admin/ckeditor-document-style.css"></style>