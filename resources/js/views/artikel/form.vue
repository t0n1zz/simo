<template>
	<div>
		<!-- page-header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

				<!-- main panel: VeeForm + Field rules (no schema) -->
				<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">

				<!-- message -->
				<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
				</message>

				<form @submit.prevent="setValues(form) || handleSubmit(onValid)" enctype="multipart/form-data">

						<!-- main form -->
						<div class="card">
							<div class="card-body">
								
								<div class="row">

									<!-- name -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.name')}">
												<i class="icon-cross2" v-if="errors.has('form.name')"></i>
												Judul: <wajib-badge></wajib-badge></h5>

											<!-- text (rules on the tag) -->
											<Field
												name="name"
												rules="required|min:5"
												v-model="form.name"
												v-slot="{ field }"
											>
												<input
													type="text"
													class="form-control"
													placeholder="Silahkan masukkan judul artikel"
													v-bind="field"
												>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.name')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- CU -->
								<div class="col-md-4" v-if="currentUser.id_cu === 0">
									<div class="form-group" :class="{'has-error' : errors.has('form.id_cu')}">

										<!-- title -->
										<h5 :class="{ 'text-danger' : errors.has('form.id_cu')}">
											<i class="icon-cross2" v-if="errors.has('form.id_cu')"></i>
											CU: <wajib-badge></wajib-badge>
										</h5>

										<!-- select -->
										<Field
											as="select"
											name="id_cu"
											rules="required"
											v-model="form.id_cu"
											class="form-control"
											data-width="100%"
											:disabled="modelCU.length === 0"
											@change="changeCU($event.target.value)"
										>
											<option disabled value="">
												<span v-if="modelCUStat === 'loading'">Mohon tunggu...</span>
												<span v-else>Silahkan pilih CU</span>
											</option>
											<option value="0"><span v-if="currentUser.pus">{{currentUser.pus.name}}</span> <span v-else>PUSKOPCUINA</span></option>
											<option v-for="(cu, index) in modelCU" :value="cu.id" :key="index">{{cu.name}}</option>
										</Field>

										<!-- error message -->
										<small class="text-muted text-danger" v-if="errors.has('form.id_cu')">
											<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_cu') }}
										</small>
										<small class="text-muted" v-else>&nbsp;</small>
									</div>
								</div>

									<!-- penulis -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_artikel_penulis')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_artikel_penulis')}">
												<i class="icon-cross2" v-if="errors.has('form.id_artikel_penulis')"></i>
												Penulis: <wajib-badge></wajib-badge>
											</h5>

											<div class="input-group">

												<!-- select -->
												<Field
													as="select"
													name="id_artikel_penulis"
													rules="required"
													v-model="form.id_artikel_penulis"
													class="form-control"
													data-width="100%"
													:disabled="modelPenulis.length === 0"
												>
													<option disabled value="">
														<span v-if="form.id_cu != 0 && modelPenulis.length == 0">Silahkan tambah penulis baru</span>
														<span v-else-if="form.id_cu == '' && modelPenulis.length == 0">Silahkan pilih CU terlebih dahulu</span>
														<span v-else>
															<span v-if="modelPenulisStat === 'loading'">Mohon tunggu...</span>
															<span v-else>Silahkan pilih penulis</span>
														</span>
													</option>
													<template v-for="penulis in modelPenulis" :key="penulis ? penulis.id : undefined">
													<option v-if="penulis" :value="penulis.id">{{penulis.name}}</option>
												</template>
												</Field>

												<!-- button -->
												<div class="input-group-append">
													<button type="button" class="btn btn-light" @click="modalOpen_Penulis" :disabled="form.id_cu === ''">
														<i class="icon-plus22"></i>
													</button>
												</div>
											</div>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_artikel_penulis')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_artikel_penulis') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kategori -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_artikel_kategori')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_artikel_kategori')}">
												<i class="icon-cross2" v-if="errors.has('form.id_artikel_kategori')"></i>
												Kategori: <wajib-badge></wajib-badge>
											</h5>

											<div class="input-group">

												<!-- select -->
												<Field
													as="select"
													name="id_artikel_kategori"
													rules="required"
													v-model="form.id_artikel_kategori"
													class="form-control"
													data-width="100%"
													:disabled="modelKategori.length === 0"
												>
													<option disabled value="">
														<span v-if="form.id_cu != 0 && modelKategori.length == 0">Silahkan tambah kategori baru</span>
														<span v-else>
															<span v-if="modelKategoriStat === 'loading'">Mohon tunggu...</span>
															<span v-else>Silahkan pilih kategori</span>
														</span>
													</option>
													<template v-for="kategori in modelKategori" :key="kategori ? kategori.id : undefined">
													<option v-if="kategori" :value="kategori.id">{{kategori.name}}</option>
												</template>
												</Field>

												<!-- button -->
												<div class="input-group-append">
													<button type="button" class="btn btn-light" :disabled="form.id_cu === ''" @click="modalOpen_Kategori">
														<i class="icon-plus22"></i>
													</button>
												</div>
											</div>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_artikel_kategori')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_artikel_kategori') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- terbitkan -->
									<div class="col-md-4" v-if="currentUser.can && currentUser.can['terbitkan_' + kelas]">
										<div class="form-group" :class="{'has-error' : errors.has('form.terbitkan')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.terbitkan')}">
												<i class="icon-cross2" v-if="errors.has('form.terbitkan')"></i>
												Status Penerbitan:
											</h5>

											<!-- select -->
											<select name="terbitkan" data-width="100%" class="form-control" v-model="form.terbitkan">
												<option disabled value="">Silahkan pilih status penerbitan</option>
												<option value="1">Terbitkan artikel</option>
												<option value="0">Tidak Terbitkan artikel</option>
											</select>

											<!-- error message -->
											<br/>
											<small class="text-muted text-danger" v-if="errors.has('form.terbitkan')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.terbitkan') }}
											</small>
											<small class="text-muted" v-else>&nbsp;
											</small>
										</div>
									</div>

									<!-- utamakan -->
									<div class="col-md-4" v-if="currentUser.can && currentUser.can['utamakan_' + kelas]">
										<div class="form-group" :class="{'has-error' : errors.has('form.utamakan')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.utamakan')}">
												<i class="icon-cross2" v-if="errors.has('form.utamakan')"></i>
												Utamakan: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field
												as="select"
												name="utamakan"
												rules="required"
												v-model="form.utamakan"
												class="form-control"
												data-width="100%"
											>
												<option disabled value="">Silahkan pilih tipe</option>
												<option value="1">Jadikan artikel utama</option>
												<option value="0">Tidak jadikan artikel utama</option>
											</Field>

											<!-- error message -->
											<br/>
											<small class="text-muted text-danger" v-if="errors.has('form.utamakan')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.utamakan') }}
											</small>
											<small class="text-muted" v-else>&nbsp;
											</small>
										</div>
									</div>

									<!-- gambar utama -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Gambar Utama:</h5>

											<!-- imageupload -->
											<app-image-upload :image_loc="'/images/artikel/'" :image_temp="form.gambar" v-model="form.gambar"></app-image-upload>
										</div>
									</div>

									<!-- separator -->
									<div class="col-md-12"><br/></div>

									<!-- isi artikel -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Isi Artikel:</h5>

										<!-- editor -->
										<rich-text-editor
											ref="richEditor"
											v-model="form.content"
											placeholder="Mulai menulis isi artikel..."
											image-folder="artikel"
										></rich-text-editor>
										</div>
									</div>

								</div>
								
							</div>
						</div>

						<!-- form info -->
						<form-info></form-info>	

						<!-- form button -->
						<div class="card card-body">
							<form-button
								:cancelState="'methods'"
								:formValidation="'form'"
								:buttonErrors="errors"
								@cancelClick="back"></form-button>
						</div>
						
					</form>
					</VeeForm>

				</div>
			</div>
		</div>

		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :color="modalColor" @batal="modalTutup" @tutup="modalTutup" @successOk="modalTutup" @failOk="modalTutup"  @backgroundClick="modalBackgroundClick">
			
			<!-- title -->
			<template #modal-title>
				{{ modalTitle }}
			</template>

			<!-- tambah penulis -->
			<template #modal-body1>
				<form-penulis 
				:id_cu="id_cu"
				@cancelClick="modalTutup"></form-penulis>
			</template>

			<!-- tambah kategori -->
			<template #modal-body2>
				<form-kategori
				:id_cu="id_cu"
				@cancelClick="modalTutup"></form-kategori>
			</template>

		</app-modal>

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import { useCuStore } from '../../stores/cu';
	import { useArtikelStore } from '../../stores/artikel';
	import { useArtikelKategoriStore } from '../../stores/artikelKategori';
	import { useArtikelPenulisStore } from '../../stores/artikelPenulis';
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';
	import pageHeader from '../../components/pageHeader.vue';
	import { toMulipartedForm } from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import formKategori from "./formKategori.vue";
	import formPenulis from "./formPenulis.vue";
	import { getLocalUser } from "../../helpers/auth";
	import { url_config } from '../../helpers/url.js';
	import wajibBadge from '../../components/wajibBadge.vue';
	import RichTextEditor from '../../components/RichTextEditor.vue';

	export default {
		components: {
			pageHeader,
			appModal,
			appImageUpload,
			message,
			formButton,
			formInfo,
			formKategori,
			formPenulis,
			wajibBadge,
			VeeForm,
			Field,
			RichTextEditor,
		},
		data() {
			return {
				authStore: useAuthStore(),
				cuStore: useCuStore(),
				artikelStore: useArtikelStore(),
				artikelKategoriStore: useArtikelKategoriStore(),
				artikelPenulisStore: useArtikelPenulisStore(),
				title: 'Tambah Artikel',
				titleDesc: 'Menambah artikel baru',
				titleIcon: 'icon-plus3',
				level2Title: 'Artikel',
				kelas: 'artikel',
			id_cu: '',
			utama: '',
			modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				submited: false,
				submitedKategori: false,
				submitedPenulis: false,
				saving: false
			}
		},
		beforeRouteEnter(to, from, next) {
			next(vm => vm.fetch());
		},
		created(){
			if(this.authStore.currentUser.id_cu === 0){
				if(this.cuStore.headerDataStatS != 'success'){
					this.cuStore.getHeader();
				}
			}
			if(this.$route.meta.mode !== 'edit' && this.artikelStore.data.id_cu === undefined){
				this.artikelStore.data.id_cu = this.authStore.currentUser.id_cu;
				this.changeCU(this.authStore.currentUser.id_cu);
			}
		},
		watch: {
			formStat(value){
				if(value === "success"){
					if(this.$route.meta.mode !== 'edit'){
						this.artikelStore.data.id_cu = this.authStore.currentUser.id_cu;
					}else{
						this.checkUser('update_artikel',this.artikelStore.data.id_cu);
					}
					if(this.artikelStore.data.id_cu !== undefined){
						this.changeCU(this.artikelStore.data.id_cu);
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
			updateKategoriStat(value){
				this.modalState = value;
				this.modalColor = '';

				if(value === "success"){
					this.modalTitle = this.artikelKategoriStore.updateData.message;
					this.artikelKategoriStore.getCu(this.id_cu);
					this.artikelStore.data.id_artikel_kategori = this.artikelKategoriStore.updateData.id;
				}else{
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.artikelKategoriStore.updateData.message;
				}
			},
			updatePenulisStat(value){
				this.modalState = value;
				this.modalColor = '';

				if(value === "success"){
					this.modalTitle = this.artikelPenulisStore.updateData.message;
					this.artikelPenulisStore.getCu(this.id_cu);	
					this.artikelStore.data.id_artikel_penulis = this.artikelPenulisStore.updateData.id;
				}else{
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.artikelPenulisStore.updateData.message;
				}
			}
    },
		methods: {
			fetch(){
				if(this.authStore.currentUser.id_cu === 0){
					if(this.cuStore.headerDataStatS != 'success'){
						this.cuStore.getHeader();
					}
				}

				if(this.$route.meta.mode === 'edit'){
					this.artikelStore.edit(this.$route.params.id);	
					this.title = 'Ubah Artikel';
					this.titleDesc = 'Mengubah artikel';
					this.titleIcon = 'icon-pencil5';
				} else {
					this.title = 'Tambah Artikel';
					this.titleDesc = 'Menambah artikel';
					this.titleIcon = 'icon-plus3';
					this.artikelStore.create();
				}
			},
			checkUser(permission,id_cu){
				if(this.authStore.currentUser){
					if(!this.authStore.currentUser.can || !this.authStore.currentUser.can[permission]){
						this.$router.push('/notFound');
					}
					if(!id_cu || this.authStore.currentUser.id_cu){
						if(this.authStore.currentUser.id_cu != 0 && this.authStore.currentUser.id_cu != id_cu){
							this.$router.push('/notFound');
						}
					}
				}
			},
			async onValid(values) {
				this.saving = true;
				this.modalShow = true;
				this.modalState = 'loading';
				this.modalTitle = 'Menyimpan data...';
				this.modalContent = '';

				try {
					const finalContent = await this.$refs.richEditor.prepareForSave((progress) => {
						this.modalTitle = 'Mengunggah gambar ' + progress.current + ' dari ' + progress.total + '...';
					});
					this.artikelStore.data.content = finalContent;

					this.modalTitle = 'Menyimpan artikel...';
					const mergedData = { ...this.artikelStore.data, ...values, content: finalContent };
					const formData = toMulipartedForm(mergedData, this.$route.meta.mode);
					if (this.$route.meta.mode === 'edit') {
						this.artikelStore.update(this.$route.params.id, formData);
					} else {
						this.artikelStore.store(formData);
					}
				} catch (err) {
					this.modalState = 'fail';
					this.modalTitle = 'Gagal mengunggah gambar';
					this.modalContent = { message: err?.message || 'Terjadi kesalahan. Silakan coba lagi.' };
				} finally {
					this.saving = false;
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			changeCU(id){
				this.artikelPenulisStore.getCu(id);	
				this.artikelKategoriStore.getCu(id);
			},
			back(){
				if(this.authStore.currentUser.id_cu == 0){
					this.$router.push({name: this.kelas + 'Cu', params:{cu:'semua'}});
				}else{
					this.$router.push({name: this.kelas + 'Cu', params:{cu: this.authStore.currentUser.id_cu}});
				}
			},
			modalTutup() {
 				if(this.updateStat === 'success'){
					this.back();
				}

				this.modalShow = false;
				this.submitedKategori = false;
				this.submitedPenulis = false;
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
			modalOpen_Penulis(){
				this.id_cu = this.form.id_cu;

				this.modalShow = true;
				this.modalState = 'normal1';
				this.modalColor = 'bg-primary';
				this.modalTitle = 'Tambah penulis artikel';
			},
			modalOpen_Kategori() {
				this.id_cu = this.form.id_cu;

				this.modalShow = true;
				this.modalState = 'normal2';
				this.modalColor = 'bg-primary';
				this.modalTitle = 'Tambah kategori artikel';
			},
			processFile(event) {
				this.form.gambar = event.target.files[0]
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			form() {
				return this.artikelStore.data;
			},
			formStat() {
				return this.artikelStore.dataStat;
			},
			rules() {
				return this.artikelStore.rules;
			},
			options() {
				return this.artikelStore.options;
			},
			updateResponse() {
				return this.artikelStore.updateData;
			},
			updateStat() {
				return this.artikelStore.updateStat;
			},
			modelCU() {
				return this.cuStore.headerDataS;
			},
			modelCUStat() {
				return this.cuStore.headerDataStatS;
			},
			modelKategori() {
				return this.artikelKategoriStore.dataS;
			},
			modelKategoriStat() {
				return this.artikelKategoriStore.dataStatS;
			},
			updateKategoriResponse() {
				return this.artikelKategoriStore.updateData;
			},
			updateKategoriStat() {
				return this.artikelKategoriStore.updateStat;
			},
			modelPenulis() {
				return this.artikelPenulisStore.dataS;
			},
			modelPenulisStat() {
				return this.artikelPenulisStore.dataStatS;
			},
			updatePenulisResponse() {
				return this.artikelPenulisStore.updateData;
			},
			updatePenulisStat() {
				return this.artikelPenulisStore.updateStat;
			}
		}
	}
</script>
