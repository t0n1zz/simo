<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">

					<!-- message -->
					<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
					</message>

					<!-- main panel -->
					<form @submit.prevent="handleSubmit(onValid)">

						<!-- select anggota cu -->
						<div class="card" v-if="form.anggota_cu_id == ''">
							<div class="card-header bg-white">
								<h5 class="card-title">Pilih Anggota CU</h5>
							</div>
							<div class="card-body">

								<!-- pilih cu -->
								<div class="row col-12" v-if="this.currentUser.id_cu === 0">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">Pilih Data</span>
										</div>
	
										<!-- select -->
										<Field name="id_cu" rules="required" v-model="form.id_cu" v-slot="{ field }">
											<select class="form-control" data-width="100%" v-bind="field" :disabled="modelCU.length === 0" @change="changeCU($event.target.value)">
												<option disabled value="">
													<span v-if="modelCUStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih CU</span>
												</option>
												<template v-for="(cu, index) in modelCU" :key="cu ? cu.id : index">
													<option v-if="cu" :value="cu.id">
														{{ cu.name }}
													</option>
												</template>
											</select>
										</Field>
	
										<!-- reload cu -->
										<div class="input-group-append">
											<button class="btn btn-light" @click="fetchCU" :disabled="modelCUStat === 'loading'">
												<i class="icon-sync" :class="{'spinner' : modelCUStat === 'loading'}"></i>
											</button>
										</div>
									</div>
								</div>
								
								<!-- tabel anggota cu -->
								<data-viewer :title="'Anggota CU'" :columnData="columnDataAnggota" :itemData="itemDataAnggota" :query="queryAnggota" :itemDataStat="itemDataAnggotaStat" @fetch="fetchAnggota" :isDasar="'true'" :isNoButtonRow="'true'" v-if="form.id_cu != ''">
									<!-- item  -->
									<template #item-desktop="props">
										<tr class="text-nowrap cursor-pointer" @click="selectedRowAnggota(props.item)">
											<td>
												{{ props.index + 1 + (+itemDataAnggota.current_page - 1) * +itemDataAnggota.per_page + '.' }}
											</td>
											<td>
												<img :src="'/images/' + kelas + '/' + props.item.gambar + 'n.jpg'"
													class="img-rounded img-fluid wmin-sm" v-if="props.item.gambar">
												<img :src="'/images/no_image.jpg'" class="img-rounded img-fluid wmin-sm" v-else>
											</td>
											<td>
												<check-value :value="props.item.no_ba"></check-value>
											</td>
											<td>
												<check-value :value="props.item.name"></check-value>
											</td>
											<td>
												<check-value :value="props.item.kelamin"></check-value>
											</td>
											<td v-html="$filters.date(props.item.tanggal_lahir)">
											</td>
											<td>
												<check-value :value="props.item.tempat_lahir"></check-value>
											</td>
											<td>
												<check-value :value="props.item.agama"></check-value>
											</td>
											<td>
												<check-value :value="props.item.status"></check-value>
											</td>
											<td>
												<check-value :value="props.item.alamat"></check-value>
											</td>
											<td>
												<check-value :value="props.item.email"></check-value>
											</td>
											<td>
												<check-value :value="props.item.hp"></check-value>
											</td>
										</tr>
									</template>
								</data-viewer>
							</div>
						</div>

						<!-- anggota cu selected -->
						<div class="card" v-if="form.anggota_cu_id">
							<div class="card-header bg-info text-white header-elements-inline">
								<h6 class="card-title"></h6>
								<div class="header-elements">
									<button type="button" class="btn btn-danger" @click.prevent="deleteSelectedAnggota"><i class="icon-cross2 mr-2"></i> Batal</button>
								</div>
							</div>
							<div class="card-body">
								<div class="media flex-column flex-sm-row mt-0">
									<div class="mr-sm-3 mb-2 mb-sm-0">
										<div class="card-img-actions">
												<img :src="'/images/anggotaCu/' + form.anggota_cu.gambar + '.jpg'" class="img-fluid img-preview rounded" v-if="form.anggota_cu.gambar" >
												<img :src="'/images/no_image.jpg'" class="img-fluid img-preview rounded" v-else>
										</div>
									</div>

									<div class="media-body">
										<ul class="list list-unstyled mb-0">
											<li><b>NIK:</b> {{ form.anggota_cu.nik }}</li>
											<li><b>Nama:</b> {{ form.anggota_cu.name }}</li>
											<li><b>Gender:</b> {{ form.anggota_cu.kelamin }}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<!-- informasi -->
						<div class="card" v-if="form.anggota_cu_id">
							<div class="card-header bg-white">
								<h5 class="card-title">1. Informasi</h5>
							</div>
							<div class="card-body">
								<div class="row">

									<!-- keterangan -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>
												Keterangan:
											</h5>

											<!-- textarea -->
											<textarea rows="5" type="text" name="keterangan" class="form-control" placeholder="Silahkan masukkan keterangan" v-model="form.keterangan"></textarea>

										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- keahlian -->
						<div class="card" v-if="form.anggota_cu_id">
							<div class="card-header bg-white">
								<h5 class="card-title">2. Keahlian</h5>
							</div>
							<div class="card-body pb-2">
								<div class="row">

									<div class="col-md-12">

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('tambahKeahlian')">
											<i class="icon-plus22"></i> Tambah
										</button>

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('ubahKeahlian')"
										:disabled="!selectedItemKeahlian.index">
											<i class="icon-pencil5"></i> Ubah
										</button>

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('hapusKeahlian')" :disabled="!selectedItemKeahlian.index">
											<i class="icon-bin2"></i> Hapus
										</button>

									</div>

								</div>		
							</div>

							<data-table :items="itemDataKeahlian" :columnData="columnDataKeahlian" :itemDataStat="itemDataKeahlianStat">
								<template #item-desktop="props">
									<tr :class="{ 'bg-info': selectedItemKeahlian.index == props.index + 1}" class="text-nowrap" @click="selectedRowKeahlian(props.item, props.index + 1, 'diklat')" v-if="props.item">
										<td>{{ props.index + 1 }}</td>
										<td>{{ props.item.name }}</td>
										<td>{{ props.item.deskripsi }}</td>
									</tr>
								</template>	
							</data-table>

						</div>

						<!-- form info -->
						<form-info v-if="form.anggota_cu_id"></form-info>	
						<br/>

						<!-- form button -->
						<div class="panel panel-flat panel-body" v-if="form.anggota_cu_id">
							<form-button
								:cancelState="'methods'"
								:formValidation="'form'"
								@cancelClick="back"></form-button>
						</div>

					</form>

					</VeeForm>
				</div>
			</div>
		</div>

		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :size="modalSize" :color="modalColor" @batal="modalTutup" @tutup="modalTutup" @confirmOk="modalConfirmOk" @successOk="modalTutup" @failOk="modalTutup"  @backgroundClick="modalBackgroundClick">

			<!-- title -->
			<template #modal-title>
				{{ modalTitle }}
			</template>

			<template #modal-body1>

				<!-- keahlia -->
				<form-keahlian 
				:mode="formKeahlianMode"
				:selected="selectedItemKeahlian"
				@createKeahlian="createKeahlian"
				@editKeahlian="editKeahlian"
				@tutup="modalTutup" v-if="state == 'tambahKeahlian' || state == 'ubahKeahlian'"></form-keahlian>

			</template>

		</app-modal>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useMentorStore } from '../../stores/mentor';
	import { useCuStore } from '../../stores/cu';
	import { useAnggotaCuStore } from '../../stores/anggotaCu';
	import pageHeader from "../../components/pageHeader.vue";
	import { toMulipartedForm } from '../../helpers/form';
	import _ from 'lodash';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';
	import Cleave from 'vue-cleave-component';
	import dataTable from '../../components/datatable.vue';
	import DatePicker from "../../components/datePicker.vue";
	import formKeahlian from "./formKeahlian.vue";
	import DataViewer from '../../components/dataviewer2.vue';
	import checkValue from '../../components/checkValue.vue';

	export default {
		components: {
			pageHeader,
			DataViewer,
			checkValue,
			appModal,
			appImageUpload,
			message,
			formButton,
			formInfo,
			wajibBadge,
			Cleave,
			dataTable,
			DatePicker,
			formKeahlian,
			VeeForm,
			Field
		},
		data() {
			return {
				title: 'Tambah Mentor',
				titleDesc: 'Menambah Mentor baru',
				titleIcon: 'icon-plus3',
				kelas: 'mentor',
				level2Title: 'Mentor',
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
					},
					year:{
            date: true,
            datePattern: ['Y'],
          },
          number12: {
            numeral: true,
            numeralIntegerScale: 12,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
          }
				},
				queryAnggota: {
					order_column: "name",
					order_direction: "asc",
					filter_match: "and",
					limit: 10,
					page: 1
				},
				columnDataAnggota: [
					{ title: 'No.' },
					{ title: 'Foto' },
					{ title: 'No. BA' },
					{
						title: 'Nama',
						name: 'name',
						tipe: 'string',
						sort: true,
						hide: false,
						disable: false,
						filter: true,
						filterDefault: true
					},
					{ title: 'Gender' },
					{ title: 'Tgl. Lahir' },
					{ title: 'Tempat Lahir' },
					{ title: 'Agama' },
					{ title: 'Status' },
					{ title: 'Alamat' },
					{ title: 'Email' },
					{ title: 'Hp' },
				],
				selectedItemAnggota: '',
				columnDataKeahlian:[
					{ title: 'No.' },
					{ title: 'Name' },
					{ title: 'Keterangan' },
				],
				selectedItemKeahlian: '',
				formKeahlianMode: '',
				itemDataKeahlian: [],
				itemDataKeahlianStat: 'success',
				state: '',
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				modalSize: '',
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
		},
		watch: {
			formStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'edit'){
						var valKeahlian;
						for (valKeahlian of this.form.keahlian){
							let formData = {};
							formData.id = valKeahlian.pivot.id;
							formData.keahlian_id = valKeahlian.pivot.keahlian_id;
							formData.name = valKeahlian.name;
							formData.deskripsi = valKeahlian.deskripsi;

							this.itemDataKeahlian.push(formData);
						}
					}else{
						if(this.currentUser.id_cu != 0 && this.form.id_cu !== undefined){
							this.changeCU(this.currentUser.id_cu);
						}	
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
			}
    },
		methods: {
			...mapActions(useMentorStore, ['edit', 'create', 'update', 'store', 'resetUpdateStat']),
			...mapActions(useAnggotaCuStore, ['indexCuMentor']),
			...mapActions(useCuStore, ['getHeader']),
			fetch(){
				if(this.$route.meta.mode === 'edit'){
					this.edit(this.$route.params.id);	
					this.title = 'Ubah Mentor';
					this.titleDesc = 'Mengubah Mentor';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah Mentor';
					this.titleDesc = 'Menambah Mentor';
					this.titleIcon = 'icon-plus3';
					this.create();
				}
			},
			fetchAnggota(params) {
				this.indexCuMentor([params, this.form.id_cu, 'semua'])
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
			fetchCU(){
				if(this.modelCu.length == 0){
					this.getHeader(this.currentUser.id_pus);
				}
			},
			changeCU(id){
				this.form.id_cu = id;
				this.fetchAnggota(this.queryAnggota);
			},
			selectedRowAnggota(item,index,tipe){
				this.selectedItemAnggota = item;
				this.form.anggota_cu_id = item.id;

				this.form.anggota_cu = this.form.anggota_cu || {};
				this.form.anggota_cu.name = item.name;
				this.form.anggota_cu.nik = item.nik;
				this.form.anggota_cu.gambar = item.gambar;
				this.form.anggota_cu.kelamin = item.kelamin;
			},
			deleteSelectedAnggota(){
				this.selectedItemAnggota = '';
				this.form.anggota_cu_id = '';
				this.form.anggota_cu.name = '';
				this.form.anggota_cu.nik = '';
				this.form.anggota_cu.gambar = '';
				this.form.anggota_cu.kelamin = '';
			},
			selectedRowKeahlian(item,index,tipe){
				this.selectedItemKeahlian = item;
				this.selectedItemKeahlian.index = index;
			},
			createKeahlian(value){
				this.itemDataKeahlian.push(value);
				this.selectedItemKeahlian = {};
				this.modalTutup();
			},
			editKeahlian(value){
				_.remove(this.itemDataKeahlian, {
						index: value.index
				});
				this.itemDataKeahlian.push(value);
				this.selectedItemKeahlian = {};
				this.modalTutup(); 
			},
			onValid() {
				this.form.anggota = this.itemDataAnggota;
				this.form.keahlian = this.itemDataKeahlian;
				this.state = '';
				
				const formData = toMulipartedForm(this.form, this.$route.meta.mode);
				if(this.$route.meta.mode == 'edit'){
					this.update([this.$route.params.id, formData]);
				}else{
					this.store(formData);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			back(){
				if(this.$route.meta.mode == 'edit' && this.currentUser.id_cu == 0){
					this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
				}else{
					if(this.currentUser.id_cu == 0){
						if(this.form.id_cu == 0){
							this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
						}else{
							this.$router.push({name: this.kelas + 'Cu', params:{cu: this.form.id_cu}});
						}
					}else{
						this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu}});
					}
				}
			},
			modalOpen(state, isMobile, itemMobile) {
				this.modalShow = true;
				this.state = state;

				if(isMobile){
					this.selectedItemAnggota = itemMobile;
					this.selectedItemKeahlian = itemMobile;
				}

				if (state == 'hapusKeahlian') {
					this.modalState = 'confirm-tutup';
					this.modalColor = '';
					this.modalTitle = 'Hapus Keahlian' + this.selectedItemKeahlian.name + ' ?';
					this.modalButton = 'Iya, Hapus';
					this.modalSize = '';
				}else if(state == 'ubahKeahlian'){
					this.modalState = 'normal1';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Ubah Keahlian';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
					this.formKeahlianMode = 'edit';
				}else if(state == 'tambahKeahlian'){
					this.modalState = 'normal1';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Tambah Keahlian';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
					this.formAnggotaMode = 'create';
				}
			},
			modalConfirmOk() {
				this.modalShow = false;

				if (this.state == 'hapusKeahlian') {
					_.remove(this.itemDataKeahlian, {
						index: this.selectedItemKeahlian.index
					});
					this.selectedItemKeahlian = {};
				}
			},
			modalTutup() {
 				if(this.updateStat === 'success' && this.state == ''){
					this.resetUpdateStat();
					this.back();
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
			processFile(event) {
				this.form.gambar = event.target.files[0]
				console.log(event.target.files[0].name);
			},
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useMentorStore,{
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'update',
				updateStat: 'updateStat'
			}),
			...mapState(useCuStore,{
				modelCu: 'headerDataS',
				modelCuStat: 'headerDataStatS',
			}),
			...mapState(useAnggotaCuStore,{
				itemDataAnggota: 'dataS',
				itemDataAnggotaStat: 'dataStatS'
			}),
		}
	}
</script>