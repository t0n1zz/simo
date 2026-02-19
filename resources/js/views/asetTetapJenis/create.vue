<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title" :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">
          <form-data :mode="'tambah'"></form-data>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import pageHeader from "../../components/pageHeader.vue";
	import formData from "./form.vue";

	export default {
		components: {
			pageHeader,
			formData,
		},
		setup() {
			const authStore = useAuthStore();
			return { authStore };
		},
		data() {
			return {
				title: 'Tambah Jenis Aset Tetap',
				titleDesc: 'Menambah jenis aset tetap',
				titleIcon: 'icon-plus3',
				level2Title: 'Jenis Aset Tetap',
				kelas: 'asetTetapJenis'
			}
		},
		created(){},
		watch: {},
		methods: {
			back() {
				this.$router.push({name: this.kelas});
			},
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
		}
	}
</script>