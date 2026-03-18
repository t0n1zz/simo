<template>
	<div>
		<!-- page-header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="level" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
					<!-- message -->
					<message v-if="errors && errors.any && errors.any('form') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors && errors.items">
					</message>

					<!-- main panel -->
					<form @submit.prevent="handleSubmit(onValid)" enctype="multipart/form-data">
					
						<!-- informasi umum -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">1. Informasi Umum</h5>
							</div>
							<div class="card-body">	
								<div class="row">

									<!-- gambar utama -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Gambar:</h5>

											<!-- imageupload -->
											<app-image-upload :image_loc="'/images/pertemuan/'" :image_temp="form.gambar" v-model="form.gambar"></app-image-upload>
										</div>
									</div>

									<!-- kode diklat bkcu -->
									<div class="col-md-12">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.kode_kegiatan')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.kode_kegiatan')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.kode_kegiatan')"></i>
												Kode & Nama Kegiatan: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<select class="form-control" name="id_kode" v-model="form.id_kode" data-width="100%" @change="changeKodeKegiatan($event.target.value)" :disabled="itemKodeKegiatanStat.length === 0">
												<option disabled value="">
													<span v-if="itemKodeKegiatanStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih kode</span>
												</option>
												<option v-for="(kodeKegiatan, index) in itemKodeKegiatan" :value="kodeKegiatan.id" :key="index">{{kodeKegiatan.kode}} - {{kodeKegiatan.name}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.kode_kegiatan')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.kode_kegiatan') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- periode -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.periode')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.periode')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.periode')"></i>
												Periode: <wajib-badge></wajib-badge> <info-icon :message="'Format: tahun. Contoh: 2019'"></info-icon></h5>

											<!-- input -->
											<Field name="periode" rules="required" v-model="form.periode" v-slot="{ field }">
												<input type="hidden" v-bind="field" />
											</Field>
											<cleave
												v-model="form.periode"
												class="form-control"
												:raw="false"
												:options="cleaveOption.year"
												placeholder="Silahkan masukkan periode"></cleave>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.periode')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.periode') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- tahun_buku -->
									<div class="col-md-4" v-if="this.$route.params.tipe != 'diklat_bkcu' || this.$route.params.tipe != 'diklat_bkcu_internal'">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.tahun_buku')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.tahun_buku')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.tahun_buku')"></i>
												Tahun Buku: <info-icon :message="'Format: tahun. Contoh: 2019'"></info-icon></h5>

											<!-- input -->
											<cleave 
												name="tahun_buku"
												v-model="form.tahun_buku" 
												class="form-control" 
												:raw="false" 
												:options="cleaveOption.year" 
												placeholder="Silahkan masukkan tahun buku"
												></cleave>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.tahun_buku')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.tahun_buku') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- mulai -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.mulai')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.mulai')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.mulai')"></i>
												Tgl. Mulai: <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<Field name="mulai" rules="required" v-slot="{ handleChange }">
												<date-picker @dateSelected="(val) => { form.mulai = val; handleChange(val); }" :defaultDate="form.mulai"></date-picker>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.mulai')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.mulai') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- selesai -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.selesai')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.selesai')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.selesai')"></i>
												Tgl. Selesai: <wajib-badge></wajib-badge></h5>

											<!-- input  -->
											<Field name="selesai" rules="required" v-slot="{ handleChange }">
												<date-picker @dateSelected="(val) => { form.selesai = val; handleChange(val); }" :defaultDate="form.selesai"></date-picker>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.selesai')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.selesai') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- durasi -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.durasi')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.durasi')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.durasi')"></i>
												Durasi: <small>jam</small> <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<Field name="durasi" rules="required" v-model="form.durasi" v-slot="{ field }">
												<input type="hidden" v-bind="field" />
											</Field>
											<cleave
												v-model="form.durasi"
												class="form-control"
												:raw="false"
												:options="cleaveOption.number3"
												placeholder="Silahkan masukkan durasi kegiatan"></cleave>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.durasi')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.durasi') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- peserta min -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.peserta_min')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.peserta_min')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.peserta_min')"></i>
												Peserta Min: <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<Field name="peserta_min" rules="required" v-model="form.peserta_min" v-slot="{ field }">
												<input type="hidden" v-bind="field" />
											</Field>
											<cleave
												v-model="form.peserta_min"
												class="form-control"
												:raw="false"
												:options="cleaveOption.number3"
												placeholder="Silahkan masukkan peserta min"></cleave>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.peserta_min')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.peserta_min') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- peserta max cu -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.peserta_max')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.peserta_max')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.peserta_max')"></i>
												Peserta Max: <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<Field name="peserta_max" rules="required" v-model="form.peserta_max" v-slot="{ field }">
												<input type="hidden" v-bind="field" />
											</Field>
											<cleave
												v-model="form.peserta_max"
												class="form-control"
												:raw="false"
												:options="cleaveOption.number3"
												placeholder="Silahkan masukkan peserta max"></cleave>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.peserta_max')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.peserta_max') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- peserta max -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.peserta_max_cu')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.peserta_max_cu')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.peserta_max_cu')"></i>
												Peserta Max Per CU: <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<Field name="peserta_max_cu" rules="required" v-model="form.peserta_max_cu" v-slot="{ field }">
												<input type="hidden" v-bind="field" />
											</Field>
											<cleave
												v-model="form.peserta_max_cu"
												class="form-control"
												:raw="false"
												:options="cleaveOption.number3"
												placeholder="Silahkan masukkan peserta max per cu"></cleave>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.peserta_max_cu')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.peserta_max_cu') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>
									<!-- tema -->
									<div class="col-md-8">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.tema')}">
											<!-- title -->
											<h5>
												Tema Kegiatan: </h5>
											<!-- input -->
											<input type="text" name="tema" 
											class="form-control" 
											placeholder="Silahkan masukkan tema kegiatan" 
											v-model="form.tema">

						
										</div>
									</div>
									

									<!-- peserta -->
									<div class="col-md-12">
										<div class="form-group" :class="{ 'has-error': sasaranError }">

											<!-- title -->
											<h5 :class="{ 'text-danger': sasaranError }">
												<i class="icon-cross2" v-if="sasaranError"></i>
												Sasaran Peserta: <wajib-badge></wajib-badge>
											</h5>

											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="1" v-model="sasaran">
													Pengurus
												</label>
											</div>	
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="2" v-model="sasaran">
													Pengawas
												</label>
											</div>	
											<div class="form-check form-check-inline">	
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="3" v-model="sasaran">
													Komite
												</label>
											</div>	
											<div class="form-check form-check-inline">	
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="4" v-model="sasaran">
													Penasihat
												</label>
											</div>	
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="5" v-model="sasaran">
													Senior Manajer
												</label>
											</div>	
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="6" v-model="sasaran">
													Manajer
												</label>
											</div>	
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="7" v-model="sasaran">
													Supervisor
												</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="8" v-model="sasaran">
													Staf
												</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="9" v-model="sasaran">
													Kontrak
												</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="10" v-model="sasaran">
													Kolektor
												</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="11" v-model="sasaran">
													Kelompok inti
												</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="12" v-model="sasaran">
													Supporting Unit
												</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" value="13" v-model="sasaran">
													Vendor sMartCU
												</label>
											</div>
											<div class="mt-1">
												<small class="text-muted text-danger" v-if="sasaranError">
													<i class="icon-arrow-small-right"></i> {{ sasaranError }}
												</small>
												<small class="text-muted" v-else>&nbsp;</small>
											</div>
										</div>
									</div>
									<!-- sasaran cu -->
									<div class="col-md-12" v-if="this.$route.params.tipe == 'diklat_bkcu'">
										<div class="form-group" :class="{ 'has-error': sasaranCuError }">
											<!-- title -->
											<h5 :class="{ 'text-danger': sasaranCuError }">
												<i class="icon-cross2" v-if="sasaranCuError"></i>
												Sasaran CU: <wajib-badge></wajib-badge>
											</h5>
											<div class="form-check form-check-inline">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" v-model="formAllCu"
														@change="selectAllCu">Semua CU
												</label>
											</div>
											<div class="form-check form-check-inline" v-for="(cu, index) in modelCu" :key="cu.id">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" :value="cu.id"
														v-model="sasaranCu" :checked="formAllCu"
														@change="updateFormCu(cu.id, $event.target.checked)">CU {{ cu.name
														}}
												</label>
											</div>
											<div class="mt-1">
												<small class="text-muted text-danger" v-if="sasaranCuError">
													<i class="icon-arrow-small-right"></i> {{ sasaranCuError }}
												</small>
												<small class="text-muted" v-else>&nbsp;</small>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>

						<!-- tempat -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">2. Tempat</h5>
							</div>
							<div class="card-body">	
								<div class="row">

									<!-- tipe tempat -->
									<div class="col-md-12">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.tipe_tempat')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.tipe_tempat')}">
												<i class="icon-cross2" v-if="errors && errors.has && errors.has('form.tipe_tempat')"></i>
												Tipe Tempat: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="tipe_tempat" rules="required" v-model="form.tipe_tempat" v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field">
													<option disabled value="">Silahkan pilih tipe tempat</option>
													<option value="ONLINE">ONLINE</option>
													<option value="OFFLINE">OFFLINE</option>
													<option value="HYBRID"> HYBRID / OFFLINE & ONLINE</option>
												</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.tipe_tempat')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.tipe_tempat') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- Provinsi -->
									<div class="col-md-4" v-if="form.tipe_tempat == 'OFFLINE' || form.tipe_tempat == 'HYBRID'">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.id_provinces')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.id_provinces')}">
												<!-- <i class="icon-cross2" v-if="errors && errors.has && errors.has('form.id_provinces')"></i> -->
												Provinsi: 
												<!-- <wajib-badge></wajib-badge> -->
											</h5>

											<!-- select -->
											<select class="form-control" name="id_provinces" v-model="form.id_provinces" data-width="100%" :disabled="modelProvinces.length === 0" @change="changeProvinces($event.target.value)">
												<option disabled value="">
													<span v-if="modelProvincesStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih provinsi</span>
												</option>
												<option v-for="(provinces, index) in modelProvinces" :key="index" :value="provinces.id">{{provinces.name}}</option>
											</select>

											<!-- error message -->
											<!-- <small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.id_provinces')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.id_provinces') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small> -->
										</div>
									</div>

									<!-- kabupaten -->
									<div class="col-md-4" v-if="form.tipe_tempat == 'OFFLINE' || form.tipe_tempat == 'HYBRID'">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.id_regencies')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.id_regencies')}">
												<!-- <i class="icon-cross2" v-if="errors && errors.has && errors.has('form.id_regencies')"></i> -->
												Kabupaten: 
												<!-- <wajib-badge></wajib-badge> -->
											</h5>

											<!-- select -->
											<select class="form-control"  name="id_regencies" v-model="form.id_regencies" data-width="100%" @change="changeRegencies($event.target.value)" :disabled="modelRegencies.length === 0">
												<option disabled value="">
													<span v-if="modelRegenciesStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih kabupaten</span>
												</option>
												<option v-for="(regencies, index) in modelRegencies" :value="regencies.id" :key="index">{{regencies.name}}</option>
											</select>

											<!-- error message -->
											<!-- <small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.id_regencies')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.id_regencies') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small> -->
										</div>
									</div>

									<!-- tempat -->
									<div class="col-md-4" v-if="form.tipe_tempat == 'OFFLINE' || form.tipe_tempat == 'HYBRID'">
										<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('form.id_tempat')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors && errors.has && errors.has('form.id_tempat')}">
												<!-- <i class="icon-cross2" v-if="errors && errors.has && errors.has('form.id_tempat')"></i> -->
												Tempat: 
												<!-- <wajib-badge></wajib-badge> -->
											</h5>

											<div class="input-group">
												<!-- select -->
												<select class="form-control" name="id_tempat" v-model="form.id_tempat" :disabled="!form.id_regencies" @change="changeTempat($event.target.value)">
													<option disabled value="">
														<span v-if="modelTempatStat === 'loading'">Mohon tunggu...</span>
														<span v-else>Silahkan pilih tempat</span>
													</option>
													<option value="0">Belum ditentukan tempat</option>
													<option disabled value="">----------------</option>
													<option v-for="(tempat, index) in modelTempat" :value="tempat.id" :key="index">{{tempat.name}}</option>
												</select>

												<!-- button -->
												<div class="input-group-append">
													<button type="button" class="btn btn-light" @click.prevent="modalOpen('tempat')" :disabled="form.id_regencies === ''">
														<i class="icon-plus22"></i>
													</button>
												</div>
											</div>
										
											<!-- error message -->
											<!-- <small class="text-muted text-danger" v-if="errors && errors.has && errors.has('form.id_tempat')">
												<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('form.id_tempat') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small> -->
										</div>
									</div>

									<!-- tempat data -->
									<div class="col-md-12" v-if="(form.tipe_tempat == 'OFFLINE' && tempatData != '') || (form.tipe_tempat == 'HYBRID' && tempatData != '')">

										<div class="card card-body" v-if="tempatData">
											<div class="media flex-column flex-sm-row mt-0 mb-3">
												<div class="mr-sm-3 mb-2 mb-sm-0">
													<div class="card-img-actions">
														<a href="#" @click.prevent="modalImageShow('/images/tempat/' + tempatData.gambar + '.jpg')" v-if="tempatData.gambar">
															<img :src="'/images/tempat/' + tempatData.gambar + 'n.jpg'" class="img-fluid img-preview rounded" >
															<span class="card-img-actions-overlay card-img"><i class="icon-enlarge6 icon-2x"></i></span>
														</a>
														<a href="#" @click.prevent="modalImageShow('/images/no_image.jpg')" v-else>
															<img :src="'/images/no_image.jpg'" class="img-fluid img-preview rounded" >
															<span class="card-img-actions-overlay card-img"><i class="icon-enlarge6 icon-2x"></i></span>
														</a>
													</div>
												</div>

												<div class="media-body">
													<h4 class="media-title">{{ tempatData.name }}</h4>
													<hr>
													<div class="row">
															<div class="col-md-6">
																<ul class="list list-unstyled mb-0">
																	<li><b>Provinsi:</b> 
																		<span v-if="tempatData.provinces">{{ tempatData.provinces.name }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>Kabupaten/Kota:</b>
																		<span v-if="tempatData.regencies">{{ tempatData.regencies.name }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>Kecamatan:</b> 
																		<span v-if="tempatData.districts">{{ tempatData.districts.name }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>Kelurahan:</b> 
																		<span v-if="tempatData.villages">{{ tempatData.villages.name }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>Alamat:</b> 
																		<span v-if="tempatData.alamat">{{ tempatData.alamat }}</span>
																		<span v-else>-</span>
																	</li>
																</ul>
															</div>
															<div class="col-md-6">
																<ul class="list list-unstyled mb-0">
																	<li><b>Website:</b>
																		<span v-if="tempatData.website">{{ tempatData.website }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>Email:</b>
																		<span v-if="tempatData.email">{{ tempatData.email }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>No. Telp:</b>
																		<span v-if="tempatData.telp">{{ tempatData.telp }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>No. Hp:</b>
																		<span v-if="tempatData.hp">{{ tempatData.hp }}</span>
																		<span v-else>-</span>
																	</li>
																	<li><b>Kode Pos:</b>
																		<span v-if="tempatData.pos">{{ tempatData.pos }}</span>
																		<span v-else>-</span>
																	</li>
																</ul>
															</div>
														</div>
												</div>
											</div>
										</div>
										
									</div>

								</div>
							</div>
						</div>
						
						<!-- keterangan -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">3. Informasi</h5>
							</div>
							<div class="card-body">	
								<div class="row">

									<!-- kerangka -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Kerangka Acuan:</h5>

											<rich-text-editor
												ref="richEditorKeterangan"
												v-model="form.keterangan"
												placeholder="Mulai menulis kerangka acuan..."
												image-folder="kegiatan"
											></rich-text-editor>

										</div>
									</div>

									<!-- jadwal -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Jadwal:</h5>

											<rich-text-editor
												ref="richEditorJadwal"
												v-model="form.jadwal"
												placeholder="Mulai menulis jadwal..."
												image-folder="kegiatan"
											></rich-text-editor>
										</div>
									</div>
									
								</div>
							</div>
						</div>

						<!-- panitia & fasilitator -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">4. Panitia & Fasilitator <wajib-badge></wajib-badge></h5>
							</div>
							<div class="card-body pb-2">
								<div class="row">

									<div class="col-md-12">

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('tambahPanitia')">
											<i class="icon-plus22"></i> Tambah
										</button>

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('ubahPanitia')"
										:disabled="!selectedItemPanitia.index">
											<i class="icon-pencil5"></i> Ubah
										</button>

										<button class="btn btn-light mb-1" @click.prevent="modalOpen('hapusPanitia')" :disabled="!selectedItemPanitia.index">
											<i class="icon-bin2"></i> Hapus
										</button>

									</div>

								</div>		
							</div>

							<data-table :items="itemDataPanitia" :columnData="columnDataPanitia" :itemDataStat="itemDataPanitiaStat">
								<template #item-desktop="props">
									<tr :class="{ 'bg-info': selectedItemPanitia.index == props.index + 1}" class="text-nowrap" @click="selectedRow(props.item, props.index + 1, 'panitia')" v-if="props.item">
										<td>{{ props.index + 1 }}</td>
										<td>
											<template v-if="props.item.asal == 'dalam'">
												<img :src="'/images/aktivis/' + props.item.gambar + 'n.jpg'" width="35px" class="img-rounded img-fluid wmin-sm" v-if="props.item.gambar">
												<img :src="'/images/no_image.jpg'" width="35px" class="img-rounded img-fluid wmin-sm" v-else>
											</template>
											<template v-else-if="props.item.asal == 'luar'">
												<img :src="'/images/mitra_orang/' + props.item.gambar + 'n.jpg'" width="35px" class="img-rounded img-fluid wmin-sm" v-if="props.item.gambar">
												<img :src="'/images/no_image.jpg'" width="35px" class="img-rounded img-fluid wmin-sm" v-else>
											</template>
											<template v-else-if="props.item.asal == 'luar lembaga'">
												<img :src="'/images/mitra_lembaga/' + props.item.gambar + 'n.jpg'" width="35px" class="img-rounded img-fluid wmin-sm" v-if="props.item.gambar">
												<img :src="'/images/no_image.jpg'" width="35px" class="img-rounded img-fluid wmin-sm" v-else>
											</template>	
										</td>
										<td>{{ props.item.name }}</td>
										<td>{{ props.item.lembaga }}</td>
										<td>{{ props.item.asal }}</td>
										<td>{{ props.item.peran }}</td>
										<td>{{ props.item.keterangan }}</td>
										<td>{{ props.item.email }}</td>
										<td>{{ props.item.hp }}</td>
									</tr>
								</template>	
							</data-table>

						</div>

						<!-- sertifikat -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">5. Sertifikat Panitia dan Fasilitator <wajib-badge></wajib-badge></h5>
							</div>

							<div class="card-body">
								<div class="row col-md-12">
									<select class="form-control"  name="id_sertifikat" v-model="form.id_sertifikatPanitia" data-width="100%" @change="changeSertifikatPanitia($event.target.value)" :disabled="itemDataStat.length === 0">
										<option disabled value="">
											<span v-if="itemDataStat === 'loading'">Mohon tunggu...</span>
											<span v-else>Silahkan pilih sertifikat</span>
										</option>
										<option value="0">Tidak menggunakan sertifikat</option>
										<option v-for="(sertifikat, index) in this.piagamData" :value="sertifikat.id" :key="index">{{sertifikat.name}} -- {{sertifikat.kode_sertifikat}}</option>
									</select>
								</div>
							</div>
						</div>
						<!-- sertifikat peserta -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">6. Sertifikat Peserta <wajib-badge></wajib-badge></h5>
							</div>

							<div class="card-body">
								<div class="row col-md-12">
									<select class="form-control"  name="id_sertifikat" v-model="form.id_sertifikat" data-width="100%" @change="changeSertifikat($event.target.value)" :disabled="itemDataStat.length === 0">
										<option disabled value="">
											<span v-if="itemDataStat === 'loading'">Mohon tunggu...</span>
											<span v-else>Silahkan pilih sertifikat</span>
										</option>
										<option value="0">Tidak menggunakan sertifikat</option>
										<option v-for="(sertifikat, index) in itemData.data" :value="sertifikat.id" :key="index">{{sertifikat.name}} -- {{sertifikat.kode_sertifikat}}</option>
									</select>
								</div>
							</div>
						</div>

						<!-- form info -->
						<form-info></form-info>	
						<br/>

						<!-- form button -->
						<div class="card card-body">
							<form-button
								:cancelState="cancelState"
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
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :size="modalSize" :color="modalColor" @batal="modalTutup" @tutup="modalTutup" @confirmOk="modalConfirmOk" @successOk="modalTutup" @failOk="modalTutup"  @backgroundClick="modalBackgroundClick">

			<!-- title -->
			<template #modal-title>
				{{ modalTitle }}
			</template>

			<template #modal-body1>
				<!-- panitia -->
				<form-panitia
					v-if="state == 'tambahPanitia' || state == 'ubahPanitia'"
					:key="'panitia-' + state + '-' + (modalShow ? 1 : 0)"
					:mode="formPanitiaMode"
					:selected="selectedItemPanitia"
					:formKey="'panitia-form-' + state + '-' + (modalShow ? 1 : 0)"
					@createPanitia="createPanitia"
					@editPanitia="editPanitia"
					@tutup="modalTutup"
				></form-panitia>
			</template>

			<!-- tambah tempat -->
			<template #modal-body2>
				<form-tempat 
				:id_provinces="form.id_provinces"
				:id_regencies="form.id_regencies"
				@tutup="modalTutup"></form-tempat>
			</template>

		</app-modal>

	</div>
</template>

<script>
	import { mapState, mapWritableState, mapActions } from 'pinia';
	import { useKegiatanBKCUStore } from '../../stores/kegiatanBKCU';
	import { useTempatStore } from '../../stores/tempat';
	import { useProvincesStore } from '../../stores/provinces';
	import { useRegenciesStore } from '../../stores/regencies';
	import { useSertifikatKegiatanStore } from '../../stores/sertifikatKegiatan';
	import { useKodeKegiatanStore } from '../../stores/kodeKegiatan';
	import { useCuStore } from '../../stores/cu';
	import _ from 'lodash';
	import pageHeader from "../../components/pageHeader.vue";
	import infoIcon from "../../components/infoIcon.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import { toMulipartedForm } from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import formPanitia from "./formPanitia.vue";
	import formTempat from "./formTempat.vue";
	import Cleave from 'vue-cleave-component';
	import dataTable from '../../components/datatable.vue';
	import DatePicker from "../../components/datePicker.vue";
	import VeeForm from "../../components/VeeForm.vue";
	import { Field } from 'vee-validate';
	import RichTextEditor from '../../components/RichTextEditor.vue';

	export default {
		components: {
			pageHeader,
			appModal,
			appImageUpload,
			message,
			formButton,
			formInfo,
			formPanitia,
			formTempat,
			Cleave,
			dataTable,
			infoIcon,
			wajibBadge,
			DatePicker,
			VeeForm,
			Field,
			RichTextEditor,
		},
		data() {
			return {
				title: 'Tambah Pertemuan BKCU',
				titleDesc: 'Menambah pertemuan BKCU baru',
				titleIcon: 'icon-plus3',
				level: 2,
				level2Title: 'Pertemuan BKCU',
				kelas: 'kegiatanBKCU',
				sasaran: [],
				tempatData: '',
				formAllCu: false,
				sasaranCu: [],
				isSasaran_cu: '',
				sasaranError: '',
				sasaranCuError: '',
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
					number3: {
            numeral: true,
            numeralIntegerScale: 3,
            numeralDecimalScale: 0,
            stripLeadingZeroes: false
          },
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
          }
				},
				selectedKode: '',
				columnDataPanitia:[
					{ title: 'No.' },
					{ title: 'Foto' },
					{ title: 'Nama' },
					{ title: 'Lembaga' },
					{ title: 'Asal' },
					{ title: 'Peran' },
					{ title: 'Keterangan' },
					{ title: 'Email' },
					{ title: 'No. Hp' },
				],
				selectedItemPanitia: {},
				formPanitiaMode: '',
				itemDataPanitia: [],
				piagamData:[],
				itemDataPanitiaStat: 'success',
				cancelState: 'methods',
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
	watch: {
			itemDataStat(value) {
				if (value === "success") {
					this.piagamData = this.itemData.data.filter(item => item.tipe === 'piagam');
					}
			},
			
			formStat(value){
			if (value === "success") {
					if (this.$route.meta.mode == 'edit') {
						this.checkTipe(this.form.tipe);
						this.changeProvinces(this.form.id_provinces);
						this.changeRegencies(this.form.id_regencies);

						var i;
						for(i = 0; i < this.form.sasaran.length; i++){
							this.sasaran.push(this.form.sasaran[i].id.toString());
						}

						var n;
						for (n = 0; n < this.form.sasaran_cu.length; n++) {
							this.sasaranCu.push(this.form.sasaran_cu[n].id.toString());
							if (n + 1 == this.modelCu.length) {
								this.formAllCu = true;
							}
						}
						
						var valDalam;
						for (valDalam of this.form.panitia_dalam) {
							let formData = {};
							formData.aktivis_id = valDalam.id;
							formData.name = valDalam.name;
							formData.gambar = valDalam.gambar;
							formData.peran = valDalam.pivot.peran;
							formData.asal = 'dalam';
							formData.keterangan = valDalam.pivot.keterangan;
							formData.email = valDalam.email;
							formData.hp = valDalam.hp;

							if(valDalam.pekerjaan_aktif){
								if(valDalam.pekerjaan_aktif.tipe == 1){
									formData.lembaga = valDalam.pekerjaan_aktif.cu.name;
								}else if(valDalam.pekerjaan_aktif.tipe == 2){
									formData.lembaga = valDalam.pekerjaan_aktif.lembaga_lain.name;
								}else if(valDalam.pekerjaan_aktif.tipe == 3){
									formData.lembaga = "PUSKOPCUINA"
								}
							}
						
							this.itemDataPanitia.push(formData);
						}

						var valLuar;
						for (valLuar of this.form.panitia_luar) {
							let formData = {};
							formData.aktivis_id = valLuar.id;
							formData.name = valLuar.name;
							formData.gambar = valLuar.gambar;
							formData.peran = valLuar.pivot.peran;
							formData.asal = 'luar';
							formData.keterangan = valLuar.pivot.keterangan;
							formData.lembaga = valLuar.lembaga;
							formData.email = valLuar.email;
							formData.hp = valLuar.hp;

							this.itemDataPanitia.push(formData);
						}

						var valLuarLembaga;
						for (valLuarLembaga of this.form.panitia_luar_lembaga) {
							let formData = {};
							formData.aktivis_id = valLuarLembaga.id;
							formData.name = valLuarLembaga.name;
							formData.gambar = valLuarLembaga.gambar;
							formData.peran = valLuarLembaga.pivot.peran;
							formData.asal = 'luar lembaga';
							formData.keterangan = valLuarLembaga.pivot.keterangan;
							formData.lembaga = valLuarLembaga.name;
							formData.email = valLuarLembaga.email;
							formData.hp = valLuarLembaga.hp;

							this.itemDataPanitia.push(formData);
						}

					}
					
				}
			},
			modelTempatStat(value){
				if(value === "success"){
					this.changeTempat(this.form.id_tempat);
				}
			},
			updateStat(value){
				// ignore initial/loading states
				if (!value || value === 'loading') {
					return;
				}
				
				// default modal styling
				this.modalShow = true;
				this.modalColor = '';

				if (value === 'success') {
					this.modalState = 'success';
					this.modalTitle = this.updateResponse?.message || 'Data kegiatan berhasil disimpan';
					this.modalContent = '';
					return;
				}

				// Some older endpoints may return an empty array ([]) even when the
				// operation actually succeeded. In that case, avoid showing an
				// error modal and show a generic success instead.
				if (
					value === 'fail' &&
					(
						!this.updateResponse ||
						(Array.isArray(this.updateResponse) && this.updateResponse.length === 0)
					)
				) {
					this.modalState = 'success';
					this.modalTitle = 'Data kegiatan berhasil disimpan';
					this.modalContent = '';
					return;
				}

				if (value === 'fail') {
					this.modalState = 'fail';
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.updateResponse || { message: 'Terjadi kesalahan saat menyimpan data.' };
				}
			},
			updateTempatStat(value){
				this.modalShow = true;
				this.modalState = value;
				this.modalColor = '';

				if(value === "success"){
					this.modalTitle = this.updateTempatResponse.message;
					this.changeRegencies(this.form.id_regencies);
				}else{
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.updateTempatResponse;
				}
			}
    },
		methods: {
			async onValid() {
				this.form.sasaran = this.sasaran;
				this.form.panitia = this.itemDataPanitia;
				this.form.pilih = this.itemDataPilih;
				this.form.sasaranCu = this.sasaranCu.map(String);
				this.state = '';

				// reset custom validation errors
				this.sasaranError = '';
				this.sasaranCuError = '';

				// require at least one sasaran peserta
				if (!this.sasaran || this.sasaran.length === 0) {
					this.sasaranError = 'Minimal satu sasaran peserta harus dipilih.';
				}

				// require at least one sasaran CU when tipe diklat_bkcu
				if (this.$route.params.tipe === 'diklat_bkcu' && (!this.sasaranCu || this.sasaranCu.length === 0)) {
					this.sasaranCuError = 'Minimal satu sasaran CU harus dipilih.';
				}

				if (this.sasaranError || this.sasaranCuError) {
					window.scrollTo(0, 0);
					this.submited = true;
					return;
				}

				try {
					const [finalKeterangan, finalJadwal] = await Promise.all([
						this.$refs.richEditorKeterangan.prepareForSave(),
						this.$refs.richEditorJadwal.prepareForSave()
					]);
					this.form.keterangan = finalKeterangan;
					this.form.jadwal = finalJadwal;
				} catch (err) {
					this.modalShow = true;
					this.modalState = 'fail';
					this.modalTitle = 'Gagal mengunggah gambar';
					this.modalContent = { message: err?.message || 'Terjadi kesalahan. Silakan coba lagi.' };
					this.submited = false;
					return;
				}

				const formData = toMulipartedForm(this.form, this.$route.meta.mode);
				if (this.$route.meta.mode == 'edit') {
					this.updateKegiatan([this.$route.params.id, formData]);
				} else {
					this.storeKegiatan([this.$route.params.tipe, formData]);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			fetch() {
				useKodeKegiatanStore().get();
				if (this.$route.meta.mode == 'edit') {
					useKegiatanBKCUStore().edit(this.$route.params.id);
				} else {
					this.checkTipe(this.$route.params.tipe);
					useKegiatanBKCUStore().create();
				}
				useProvincesStore().get();
				useSertifikatKegiatanStore().index();
			},
			fetchCu() {
				if (this.modelCuStat != 'success') {
					useCuStore().getHeader();
				}
			},
			selectAllCu() {
				if (this.formAllCu) {
					this.sasaranCu = this.modelCu.map(cu => cu.id);
				} else {
					this.sasaranCu = [];
				}
			},
			updateFormCu(id, isChecked) {
				if (isChecked && !this.sasaranCu.includes(id)) {
					this.sasaranCu.push(id);
				} else if (!isChecked && this.sasaranCu.includes(id)) {
					const index = this.sasaranCu.indexOf(id);
					this.sasaranCu.splice(index, 1);
				}

				if (this.sasaranCu.length != this.modelCu.length) {
					this.formAllCu = false;
				} else if (this.sasaranCu.length == this.modelCu.length) {
					this.formAllCu = true;
				}
			},
			checkTipe(tipe){
				if(tipe == 'diklat_bkcu'){
					this.level2Title = 'Diklat PUSKOPCUINA';
				}else if(tipe == 'diklat_bkcu_internal'){
					this.level2Title = 'Diklat Internal PUSKOPCUINA';
				}else if(tipe == 'pertemuan_bkcu'){
					this.level2Title = 'Pertemuan PUSKOPCUINA';
				}else if(tipe == 'pertemuan_bkcu_internal'){
					this.level2Title = 'Pertemuan Internal PUSKOPCUINA';
				}
				if(this.$route.meta.mode == 'edit'){
					this.title = 'Ubah ' + this.level2Title;
					this.titleDesc = 'Mengubah ' + this.level2Title;
					this.titleIcon = 'icon-pencil5';
				}else{
					this.title = 'Tambah ' + this.level2Title;
					this.titleDesc = 'Menambah ' + this.level2Title;
					this.titleIcon = 'icon-plus3';
				}	
			},
			changeSertifikat(event){
				this.form.formSertifikat = event;
			},
			changeSertifikatPanitia(event){
				this.form.formSertifikatPanitia = event;
			},
			changeKodeKegiatan(event){
				this.form.id_kode = event;
			},
			changeProvinces(id){
				this.getRegenciesProvinces(id);
			},
			changeRegencies(id){
				this.getTempat(id);
				this.tempatData = "";
			},
			changeTempat(id){
				if(id != 0){
					this.tempatData = _.find(this.modelTempat, function(o){
						return o.id == id;
					});
				}
			},
			createPanitia(value){
				this.itemDataPanitia.push(value);
				this.selectedItemPanitia = {};
				this.modalTutup();
			},
			editPanitia(value){
				_.remove(this.itemDataPanitia, {
						index: value.index
				});
				this.itemDataPanitia.push(value);
				this.selectedItemPanitia = {};
				this.modalTutup(); 
			},
			createPilih(value){
				this.itemDataPilih.push(value);
				this.selectedItemPilih = {};
				this.modalTutup();
			},
			editPilih(value){
				_.remove(this.itemDataPilih, {
						index: value.index
				});
				this.itemDataPilih.push(value);
				this.selectedItemPilih = {};
				this.modalTutup(); 
			},
			back(){
				if(this.$route.meta.isDetail){
					// From detail -> edit -> back: return to detail view
					this.$router.push({
						name: this.kelas + 'Detail',
						params: {
							id: this.form.id,
							tipe: this.form.tipe || this.$route.params.tipe,
						},
					});
				}else{
					if(this.$route.meta.mode == 'edit'){
						this.$router.push({name: this.kelas, params:{tipe:this.form.tipe, periode: this.momentYear()}});
					}else{
						this.$router.push({name: this.kelas, params:{tipe:this.$route.params.tipe, periode: this.momentYear()}});
					}
				}
			},
			selectedRow(item,index,tipe){
				if(tipe == 'panitia'){
					this.selectedItemPanitia = item;
					this.selectedItemPanitia.index = index;
				}else{
					this.selectedItemPilih = item;
					this.selectedItemPilih.index = index;
				}
			},
			modalOpen(state, isMobile, itemMobile) {
				this.modalShow = true;
				this.state = state;

				if(isMobile){
					this.selectedItemPanitia = itemMobile;
				}

				if (state == 'tambahPanitia') {
					this.selectedItemPanitia = {};
				}

				if (state == 'hapusPanitia') {
					this.modalState = 'confirm-tutup';
					this.modalColor = '';
					this.modalTitle = 'Hapus Panitia/Fasilitator ' + this.selectedItemPanitia.name + ' ?';
					this.modalButton = 'Iya, Hapus';
					this.modalSize = '';
				}else if(state == 'ubahPanitia'){
					this.modalState = 'normal1';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Ubah Panitia/Fasilitator';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
					this.formPanitiaMode = 'edit';
				}else if(state == 'tambahPanitia'){
					this.modalState = 'normal1';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Tambah Panitia/Fasilitator';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
					this.formPanitiaMode = 'create';
				}else if(state == 'tempat'){
					this.modalState = 'normal2';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Tambah Tempat';
					this.modalButton = 'Ok';
					this.modalSize = 'modal-lg';
				}
			},
			modalImageShow(content){
				this.modalShow = true;
				this.modalState = 'image';
				this.modalContent = content;
				this.modalSize = '';
				this.modalButton = 'Ok';
			},
			modalConfirmOk() {
				this.modalShow = false;

				if (this.state == 'hapusPanitia') {
					_.remove(this.itemDataPanitia, {
						index: this.selectedItemPanitia.index
					});
					this.selectedItemPanitia = {};
				}else{
					if(this.$route.meta.isDetail){
						this.$router.push({name: this.kelas + 'Detail', params: { id: this.form.id }});
					}
				}
			},
			modalTutup() {
				// When the modal is in success state and we're not inside another
				// modal flow (like hapusPanitia), treat closing as a successful save.
				if (this.modalState === 'success' && this.state === '') {
					this.resetUpdateStat();
					this.back();
					this.modalShow = false;
					return;
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
			},
			momentYear(){
				return moment().year();
			},
			...mapActions(useKegiatanBKCUStore, {
				createKegiatan: 'create',
				editKegiatan: 'edit',
				storeKegiatan: 'store',
				updateKegiatan: 'update',
				resetUpdateStat: 'resetUpdateStat'
			}),
			...mapActions(useKodeKegiatanStore, { getKodeKegiatan: 'get' }),
			...mapActions(useProvincesStore, { getProvinces: 'get' }),
			...mapActions(useSertifikatKegiatanStore, { getSertifikat: 'index' }),
			...mapActions(useCuStore, { getCuHeader: 'getHeader' }),
			...mapActions(useRegenciesStore, { getRegenciesProvinces: 'getProvinces' }),
			...mapActions(useTempatStore, { getTempat: 'get' }),

			fetch() {
				this.getKodeKegiatan();
				if (this.$route.meta.mode == 'edit') {
					this.editKegiatan(this.$route.params.id);
				} else {
					this.checkTipe(this.$route.params.tipe);
					this.createKegiatan();
				}
				this.getProvinces();
				this.getSertifikat();
			},
			fetchCu() {
				if (this.modelCuStat != 'success') {
					this.getCuHeader();
				}
			},
		},
		computed: {
			...mapWritableState(useKegiatanBKCUStore, {
				form: 'data',
			}),
			...mapState(useKegiatanBKCUStore, {
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'updateData',
				updateStat: 'updateStat'
			}),
			...mapState(useTempatStore, {
				updateTempatResponse: 'updateData',
				updateTempatStat: 'updateStat',
				modelTempat: 'dataSForm',
				modelTempatStat: 'dataStatSForm',
			}),
			...mapState(useProvincesStore, {
				modelProvinces: 'dataS',
				modelProvincesStat: 'dataStatS'
			}),
			...mapState(useRegenciesStore, {
				modelRegencies: 'dataS',
				modelRegenciesStat: 'dataStatS'
			}),
			...mapState(useSertifikatKegiatanStore, {
				itemData: 'dataS',
				itemDataStat: 'dataStatS',
			}),
			...mapState(useKodeKegiatanStore, {
				itemKodeKegiatan: 'dataS2',
				itemKodeKegiatanStat: 'dataStatS2'
			}),
			...mapState(useCuStore, {
				modelCu: 'headerDataS',
				modelCuStat: 'headerDataStatS',
			}),
		}
	}
</script>