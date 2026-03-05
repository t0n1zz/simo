<template>
	<div>
		<!-- page-header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">

						<!-- message -->
						<message v-if="errors.any('form') && submited" :title="'Oops terjadi kesalahan'"
							:errorItem="errors.items">
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
									
									<!-- foto -->
									<div class="col-md-6">
										<div class="form-group">

											<!-- title -->
											<h5>Foto Kantor Pusat:</h5>

											<!-- imageupload -->
											<app-image-upload :image_loc="'/images/cu/'" :image_temp="form.gambar" v-model="form.gambar"></app-image-upload>
										</div>
									</div>  

									<!-- logo -->
									<div class="col-md-6">
										<div class="form-group">

											<!-- title -->
											<h5>Logo CU:</h5>

											<!-- imageupload -->
											<app-image-upload :image_loc="'/images/logo/'" :image_temp="form.logo" v-model="form.logo"></app-image-upload>
										</div>
									</div> 

									<!-- no_ba -->
									<div class="col-md-2">
										<div class="form-group" :class="{'has-error' : errors.has('form.no_ba')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.no_ba')}">
												<i class="icon-cross2" v-if="errors.has('form.no_ba')"></i>
												No. BA: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="no_ba" rules="required" v-model="form.no_ba" v-slot="{ field }">
												<cleave
													:name="field.name"
													:value="field.value"
													@input="field.onChange"
													@blur="field.onBlur"
													class="form-control"
													:options="cleaveOption.number3"
													placeholder="Silahkan masukkan no ba."
													:readonly="currentUser.id_cu != 0"
												></cleave>
											</Field>
											

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.no_ba')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.no_ba') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- name -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.name')}">
												<i class="icon-cross2" v-if="errors.has('form.name')"></i>
												Nama: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="name" rules="required|min:5" v-model="form.name" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan nama CU" v-bind="field"
													:readonly="currentUser.id_cu != 0">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.name')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- name -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : errors.has('form.name_legal')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.name_legal')}">
												<i class="icon-cross2" v-if="errors.has('form.name_legal')"></i>
												Nama Legal: <wajib-badge></wajib-badge> <info-icon class="text-right" :message="'nama yang terdaftar secara hukum contoh: KSP xxx'"></info-icon></h5>

											<!-- text -->
											<input type="text" name="name_legal" class="form-control" placeholder="Silahkan masukkan nama legal" v-model="form.name_legal" >

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.name_legal')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.name_legal') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									
									<!-- badan hukum -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.badan_hukum')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.badan_hukum')}">
												<i class="icon-cross2" v-if="errors.has('form.badan_hukum')"></i>
												Badan Hukum:</h5>

											<!-- text -->
											<input type="text" name="badan_hukum" class="form-control" placeholder="Silahkan masukkan nama CU"  v-model="form.badan_hukum" >

											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- npwp -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.npwp')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.npwp')}">
												<i class="icon-cross2" v-if="errors.has('form.npwp')"></i>
												NPWP (nomor pokok wajib pajak):</h5>

											<!-- text -->
											<input type="text" name="npwp" class="form-control" placeholder="Silahkan masukkan NPWP"  v-model="form.npwp" >

											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- nik -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.nik')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.nik')}">
												<i class="icon-cross2" v-if="errors.has('form.nik')"></i>
												NIK (nomor induk koperasi):</h5>

											<!-- text -->
											<input type="text" name="NIK" class="form-control" placeholder="Silahkan masukkan NIK"  v-model="form.nik" >

											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- SITU -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.situ')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.situ')}">
												<i class="icon-cross2" v-if="errors.has('form.situ')"></i>
												SITU (surat izin tempat usaha):</h5>

											<!-- text -->
											<input type="text" name="SITU" class="form-control" placeholder="Silahkan masukkan SITU"  v-model="form.situ" >

											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- SIUSP -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.siusp')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.siusp')}">
												<i class="icon-cross2" v-if="errors.has('form.siusp')"></i>
												SIUSP (surat izin usaha simpan pinjam):</h5>

											<!-- text -->
											<input type="text" name="SIUSP" class="form-control" placeholder="Silahkan masukkan SIUSP"  v-model="form.siusp" >

											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- izin operasional -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.izinOp')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.izinOp')}">
												<i class="icon-cross2" v-if="errors.has('form.izinOp')"></i>
												Izin Operasional:</h5>

											<!-- text -->
											<input type="text" name="izinOp" class="form-control" placeholder="Silahkan masukkan izin operasional"  v-model="form.izinOp" >

											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- aplikasi -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.app')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.app')}">
												<i class="icon-cross2" v-if="errors.has('form.app')"></i>
												Aplikasi Keuangan Utama: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="app" rules="required" v-model="form.app" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan nama aplikasi keuangan utama"
													v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.app')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.app') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- ultah -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.ultah')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.ultah')}">
												<i class="icon-cross2" v-if="errors.has('form.ultah')"></i>
												Tgl. Berdiri: <wajib-badge></wajib-badge></h5>

											<!-- input -->
											<date-picker @dateSelected="form.ultah = $event" :defaultDate="form.ultah"></date-picker>
											<Field name="ultah" rules="required" v-model="form.ultah" v-slot="{ field }">
												<input v-bind="field" type="text" v-show="false" aria-hidden="true" />
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.ultah')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.ultah') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- bergabung -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.bergabung')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.bergabung')}">
												<i class="icon-cross2" v-if="errors.has('form.bergabung')"></i>
												Tgl. Bergabung: <wajib-badge></wajib-badge></h5>

											<!-- input  -->
											<date-picker @dateSelected="form.bergabung = $event" :defaultDate="form.bergabung"></date-picker>
											<Field name="bergabung" rules="required" v-model="form.bergabung" v-slot="{ field }">
												<input v-bind="field" type="text" v-show="false" aria-hidden="true" />
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.bergabung')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.bergabung') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>
									
								</div>
							</div>
						</div>

						<!-- lokasi -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">2. Lokasi</h5>
							</div>
							<div class="card-body">
								<div class="row">
									
									<!-- Provinsi -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_provinces')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_provinces')}">
												<i class="icon-cross2" v-if="errors.has('form.id_provinces')"></i>
												Provinsi: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<Field name="id_provinces" rules="required" v-model="form.id_provinces"
												v-slot="{ field }">
												<select class="form-control" data-width="100%" v-bind="field"
													:disabled="modelProvinces.length === 0 || !currentUser.can['update_' + kelas]"
													@change="changeProvinces($event.target.value)">
												<option disabled value="">
													<span v-if="modelProvincesStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih provinsi</span>
												</option>
												<option v-for="(provinces, index) in modelProvinces" :value="provinces.id" :key="index">{{provinces.name}}</option>
											</select>
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_provinces')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_provinces') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kabupaten -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_regencies')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_regencies')}">
												<i class="icon-cross2" v-if="errors.has('form.id_regencies')"></i>
												Kabupaten: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control"  name="id_regencies" v-model="form.id_regencies" data-width="100%"  data-vv-as="Kabupaten" @change="changeRegencies($event.target.value)" :disabled="modelRegencies.length === 0 || !currentUser.can['update_' + kelas]">
												<option disabled value="">
													<span v-if="modelRegenciesStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih kabupaten</span>
												</option>
												<option v-for="(regencies, index) in modelRegencies" :value="regencies.id" :key="index">{{regencies.name}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_regencies')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_regencies') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kecamatan -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_districts')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_districts')}">
												<i class="icon-cross2" v-if="errors.has('form.id_districts')"></i>
												Kecamatan: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control"  name="id_districts" v-model="form.id_districts" data-width="100%" data-vv-as="Kecamatan" :disabled="modelDistricts.length === 0 || !currentUser.can['update_' + kelas]" @change="changeDistricts($event.target.value)">
												<option disabled value="">
													<span v-if="modelDistrictsStat === 'loading'">Mohon tunggu...</span>
													<span v-else>Silahkan pilih kecamatan</span>
												</option>
												<option v-for="(districts, index) in modelDistricts" :value="districts.id" :key="index">{{districts.name}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_regency')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_regency') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- kelurahan -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.id_villages')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.id_villages')}">
												<i class="icon-cross2" v-if="errors.has('form.id_villages')"></i>
												Kelurahan: <wajib-badge></wajib-badge>
											</h5>

											<!-- select -->
											<select class="form-control"  name="id_villages" v-model="form.id_villages" data-width="100%"  data-vv-as="Kelurahan" :disabled="modelVillages.length === 0 || !currentUser.can['update_' + kelas]">
												<option disabled value="">
													<span v-if="modelVillagesStat === 'loading'">Mohon tunggu... mohon tunggu</span>
													<span v-else>Silahkan pilih kelurahan</span>
												</option>
												<option v-for="(villages, index) in modelVillages" :value="villages.id" :key="index">{{villages.name}}</option>
											</select>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.id_villages')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_villages') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- alamat -->
									<div class="col-md-8">
										<div class="form-group" :class="{'has-error' : errors.has('form.alamat')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.alamat')}">
												<i class="icon-cross2" v-if="errors.has('form.alamat')"></i>
												Alamat: <wajib-badge></wajib-badge></h5>

											<!-- text -->
											<Field name="alamat" rules="required|min:5" v-model="form.alamat"
												v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan alamat" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.alamat')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.alamat') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- lat -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5>Koordinat garis lintang (latitude):</h5>

											<!-- text -->
											<input type="text" name="lat" class="form-control" placeholder="Silahkan masukkan koordinat garis lintang" data-vv-as="Latitude" v-model="form.lat">

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- lng -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5>Koordinat garis bujur (longitude):</h5>

											<!-- text -->
											<input type="text" name="lng" class="form-control" placeholder="Silahkan masukkan koordinat garis bujur" data-vv-as="Longitude" v-model="form.lng">

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- informasi kontak -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">3. Kontak</h5>
							</div>
							<div class="card-body">
								<div class="row">

									<!-- no telp -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.telp')}">
												<i class="icon-cross2" v-if="errors.has('form.telp')"></i>
												No. Telp:</h5>

											<!-- text -->
											<cleave 
												v-model="form.telp" 
												class="form-control" 
												:options="cleaveOption.number12"
												placeholder="Silahkan masukkan no telp"
												></cleave>

											<!-- error message -->
											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- no hp -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.hp')}">
												<i class="icon-cross2" v-if="errors.has('form.hp')"></i>
												No. Hp:</h5>

											<!-- text -->
											<cleave 
												v-model="form.hp" 
												class="form-control" 
												:options="cleaveOption.number12"
												placeholder="Silahkan masukkan no hp"
												></cleave>

											<!-- error message -->
											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- kode pos -->
									<div class="col-md-4">
										<div class="form-group">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.pos')}">
												<i class="icon-cross2" v-if="errors.has('form.pos')"></i>
												Kode Pos:</h5>

											<!-- text -->
											<cleave 
												v-model="form.pos" 
												class="form-control" 
												:options="cleaveOption.number12"
												placeholder="Silahkan masukkan kode pos"
												></cleave>

											<!-- error message -->
											<small class="text-muted">&nbsp;</small>	
										</div>
									</div>

									<!-- email -->
									<div class="col-md-4">
										<div class="form-group" :class="{'has-error' : errors.has('form.email')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.email')}">
												<i class="icon-cross2" v-if="errors.has('form.email')"></i>
												E-mail:</h5>

											<!-- text -->
											<input type="text" name="email" class="form-control" placeholder="Silahkan masukkan alamat e-mail" v-model="form.email" >

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.email')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.email') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- website -->
									<div class="col-md-8">
										<div class="form-group" :class="{'has-error' : errors.has('form.website')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.website')}">
												<i class="icon-cross2" v-if="errors.has('form.website')"></i>
												Website:</h5>

											<!-- text -->
											<Field name="website" rules="url" v-model="form.website" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan alamat website" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.website')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.website') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>
									
									<!-- facebook -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : errors.has('form.facebook')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.facebook')}">
												<i class="icon-cross2" v-if="errors.has('form.facebook')"></i>
												Facebook: <br/>
												<small class="text-muted">copy linknya contoh: https://www.facebook.com/puskopcuina</small>
											</h5>

											<!-- text -->
											<Field name="facebook" rules="url" v-model="form.facebook" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan link facebook" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.facebook')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.facebook') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- instagram -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : errors.has('form.instagram')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.instagram')}">
												<i class="icon-cross2" v-if="errors.has('form.instagram')"></i>
												Instagram: <br/>
												<small class="text-muted">copy linknya contoh: https://www.instagram.com/puskopcuina/</small>
											</h5>

											<!-- text -->
											<Field name="instagram" rules="url" v-model="form.instagram" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan link instagram" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.instagram')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.instagram') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- youtube -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : errors.has('form.youtube')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.youtube')}">
												<i class="icon-cross2" v-if="errors.has('form.youtube')"></i>
												Youtube: <br/>
												<small class="text-muted">copy linknya contoh: https://www.youtube.com/@PuskopcuinaOfficial</small>
											</h5>

											<!-- text -->
											<Field name="youtube" rules="url" v-model="form.youtube" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan link youtube" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.youtube')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.youtube') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

									<!-- tiktok -->
									<div class="col-md-6">
										<div class="form-group" :class="{'has-error' : errors.has('form.tiktok')}">

											<!-- title -->
											<h5 :class="{ 'text-danger' : errors.has('form.tiktok')}">
												<i class="icon-cross2" v-if="errors.has('form.tiktok')"></i>
												Tiktok: <br/>
												<small class="text-muted">copy linknya contoh: https://www.tiktok.com/@PuskopcuinaOfficial</small>
											</h5>

											<!-- text -->
											<Field name="tiktok" rules="url" v-model="form.tiktok" v-slot="{ field }">
												<input type="text" class="form-control"
													placeholder="Silahkan masukkan link tiktok" v-bind="field">
											</Field>

											<!-- error message -->
											<small class="text-muted text-danger" v-if="errors.has('form.tiktok')">
												<i class="icon-arrow-small-right"></i> {{ errors.first('form.tiktok') }}
											</small>
											<small class="text-muted" v-else>&nbsp;</small>
										</div>
									</div>

								</div>	
							</div>
						</div>

						<!-- informasi profil -->
						<div class="card">
							<div class="card-header bg-white">
								<h5 class="card-title">4. Profil</h5>
							</div>
							<div class="card-body">
								<div class="row">
								
									<!-- misi -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Misi:</h5>

											<!-- textarea -->
											<ckeditor type="classic" :config="ckeditorNoImageConfig" v-model="form.misi" ></ckeditor>

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- visi -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Visi:</h5>

											<!-- textarea -->
											<ckeditor type="classic" :config="ckeditorNoImageConfig" v-model="form.visi" ></ckeditor>

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- nilai -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Nilai-nilai Inti:</h5>

											<!-- textarea -->
											<ckeditor type="classic" :config="ckeditorNoImageConfig" v-model="form.nilai" ></ckeditor>

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- slogan -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Slogan:</h5>

											<!-- textarea -->
											<input type="text" name="slogan" class="form-control" placeholder="Silahkan masukkan slogan" v-model="form.slogan" >

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- sejarah -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Sejarah:</h5>

											<!-- textarea -->
											<ckeditor type="classic" :config="ckeditorNoImageConfig"  v-model="form.sejarah" ></ckeditor>

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

									<!-- deskripsi -->
									<div class="col-md-12">
										<div class="form-group">

											<!-- title -->
											<h5>Deskripsi:</h5>

											<!-- textarea -->
											<ckeditor type="classic" :config="ckeditorNoImageConfig" v-model="form.deskripsi" ></ckeditor>

											<small class="text-muted">&nbsp;</small>
										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- form info -->
						<form-info v-if="currentUser.can && currentUser.can['update_' + kelas]"></form-info>	
						<br/>

						<!-- form button -->
						<div class="card card-body" v-if="currentUser.can && currentUser.can['update_' + kelas]">
							<form-button
								:cancelState="cancelState"
								:formValidation="'form'"
								@cancelClick="back"></form-button>
						</div>	

						<div v-else>
							<div class="alert bg-warning alert-styled-left">
								<h6>Untuk menyimpan pengubahan data, anda mesti memiliki hak akses untuk mengubah CU, silahkan hubungi user di CU anda yang memiliki akses mengelola user.</h6>
							</div>
						</div>

					</form>

					</VeeForm>

				</div>
			</div>
		</div>

		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :color="modalColor" @batal="modalTutup" @tutup="modalTutup" @successOk="modalTutup" @failOk="modalTutup"  @backgroundClick="modalBackgroundClick">
		</app-modal>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useCuStore } from '../../stores/cu';
	import { useAuthStore } from '../../stores/auth';
	import { useProvincesStore } from '../../stores/provinces';
	import { useRegenciesStore } from '../../stores/regencies';
	import { useDistrictsStore } from '../../stores/districts';
	import { useVillagesStore } from '../../stores/villages';
	import pageHeader from "../../components/pageHeader.vue";
	import { toMulipartedForm } from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal.vue';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import Cleave from 'vue-cleave-component';
	import wajibBadge from "../../components/wajibBadge.vue";
	import infoIcon from "../../components/infoIcon.vue";
	import DatePicker from "../../components/datePicker.vue";
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		components: {
			pageHeader,
			appModal,
			appImageUpload,
			message,
			formButton,
			formInfo,
			Cleave,
			wajibBadge,
			infoIcon,
			DatePicker,
			VeeForm,
			Field,
		},
		data() {
			return {
				title: 'Tambah CU',
				titleDesc: 'Menambah CU baru',
				titleIcon: 'icon-plus3',
				level: 2,
				level2Title: 'CU',
				kelas: 'cu',
				redirect: '/cu/',
				ckeditorNoImageConfig: {
					toolbar: {
						items: [
							'heading',
							'|',
							'bold',
							'italic',
							'link',
							'bulletedList',
							'numberedList',
							'blockQuote',
							'insertTable',
							'mediaEmbed',
							'undo',
							'redo'
						]
					},
					table: {
						contentToolbar: [
							'tableColumn',
							'tableRow',
							'mergeTableCells'
						]
					},
				},
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
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
				cancelState: 'methods',
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
		watch: {
			formStat(value){
				if(value === "success"){
					if(this.$route.meta.mode == 'edit'|| this.$route.meta.mode == 'profile' ){
						if(this.currentUser.id_cu !== 0 && this.currentUser.id_cu !== this.form.id){
							this.$router.push({name: 'notFound'});
						}

						this.changeProvinces(this.form.id_provinces);
						this.changeRegencies(this.form.id_regencies);
						this.changeDistricts(this.form.id_districts);
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
			...mapActions(useCuStore, ['create', 'edit', 'store', 'update']),
			...mapActions(useProvincesStore, {fetchProvinces: 'get'}),
			...mapActions(useRegenciesStore, {indexRegencies: 'indexProvinces'}),
			...mapActions(useDistrictsStore, {indexDistricts: 'indexRegencies'}),
			...mapActions(useVillagesStore, {indexVillages: 'indexDistricts'}),
			fetch(){
				if(this.$route.meta.mode == 'edit'){
					this.edit(this.$route.params.id);	
					this.title = 'Ubah ' + this.level2Title;
					this.titleDesc = 'Mengubah ' + this.level2Title;
					this.titleIcon = 'icon-pencil5';
				} else if(this.$route.meta.mode == 'profile'){
					this.edit(this.$route.params.id);	
					this.title = 'Profile ' + this.level2Title;
					this.titleDesc = 'Mengubah profile ' + this.level2Title;
					this.titleIcon = 'icon-office';
					this.level = 1;
					this.level2Title = '';
					this.cancelState = '';
				} else {
					this.create();
					this.title = 'Tambah ' + this.level2Title;
					this.titleDesc = 'Menambah ' + this.level2Title;
					this.titleIcon = 'icon-plus3';
				}

				this.fetchProvinces();
			},
			onValid(values) {
				const payload = { ...this.form, ...values };
				const formData = toMulipartedForm(payload, this.$route.meta.mode);
				if (this.$route.meta.mode == 'edit' || this.$route.meta.mode == 'profile') {
					this.update([this.$route.params.id, formData]);
				} else {
					this.store(formData);
				}
				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			back(){
				this.$router.push({name: this.kelas});
			},
			changeProvinces(id){
				this.indexRegencies(id);
			},
			changeRegencies(id){
				this.indexDistricts(id);
			},
			changeDistricts(id){
				this.indexVillages(id);
			},
			modalTutup() {
 				if(this.updateStat === 'success' && this.$route.meta.mode == 'edit'){
					this.$router.push(this.redirect);
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
			processFile(event) {
				this.form.gambar = event.target.files[0]
				console.log(event.target.files[0].name);
			},
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useCuStore, {
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'updateData',
				updateStat: 'updateStat'
			}),
			...mapState(useProvincesStore, {
				modelProvinces: 'dataS',
				modelProvincesStat: 'dataStatS'
			}),
			...mapState(useRegenciesStore, {
				modelRegencies: 'dataS',
				modelRegenciesStat: 'dataStatS'
			}),
			...mapState(useDistrictsStore, {
				modelDistricts: 'dataS',
				modelDistrictsStat: 'dataStatS'
			}),
			...mapState(useVillagesStore, {
				modelVillages: 'dataS',
				modelVillagesStat: 'dataStatS'
			})
		}
	}
</script>