<template>
  <div class="row">
    <div class="col-sm-6">
      <ul class="list list-unstyled mb-0">
        <li><b>No. KTP:</b> {{ form.nik}}</li>
        <li><b>Nama:</b> {{ form.name}}</li>
        <li><b>Nama Ahli Waris:</b> {{ form.ahli_waris}}</li>
        <li><b>Gender:</b> {{ form.kelamin}}</li>
        <li><b>Tempat Lahir:</b> {{ form.tempat_lahir}}</li>
        <li><b>Tgl. Lahir:</b> <span v-html="$filters.date(form.tanggal_lahir)"></span></li>
        <li><b>Status:</b> {{ form.status}}</li>
        <li><b>Tinggi:</b> {{ form.tinggi}}</li>
        <li><b>Agama:</b> {{ form.agama}}</li>
        <li><b>Email:</b> {{ form.email}}</li>
      </ul>
    </div>
    <div class="col-sm-6">
      <ul class="list list-unstyled mb-0">
        <li><b>Lembaga:</b> {{ form.lembaga}}</li>
        <li><b>Jabatan:</b> {{ form.jabatan}}</li>
        <li><b>Pendidikan:</b> {{ form.pendidikan}}</li>
        <li><b>No. Hp:</b> {{ form.hp}}</li>
        <li><b>Kontak Lain:</b> {{ form.kontak}}</li>
        <li><b>Provinsi:</b> {{ form.provinces ? form.provinces.name : '-'}}</li>
        <li><b>Kabupaten:</b> {{ form.regencies ?form.regencies.name : '-'}}</li>
        <li><b>Kecamatan:</b> {{ form.districts ? form.districts.name : '-'}}</li>
        <li><b>Kelurahan:</b> {{ form.villages ? form.villages.name : '-'}}</li>
        <li><b>Alamat:</b> {{ form.alamat}}</li>
      </ul>
    </div>
  </div>     
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useAnggotaCuStore } from '../../stores/anggotaCu';

	export default {
		props: ['id_props'],
		components: {
		},
		data() {
			return {
        kelas: 'anggotaCu',
        id_local: '',
			}
		},
		created() {
			this.fetch();
		},
		methods: {
			...mapActions(useAnggotaCuStore, ['editIdentitas']),
			fetch() {
				this.id_local = this.id_props;
				this.editIdentitas(this.id_local);
			},
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useAnggotaCuStore, {
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'update',
				updateStat: 'updateStat'
			}),
		}
	}
</script>