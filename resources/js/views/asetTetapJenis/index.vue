<template>
	<div>
		<!-- Page header -->
		<page-header 
		:title="title" 
		:titleDesc="titleDesc" 
		:titleIcon="titleIcon"></page-header>
		
		<!-- page container -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<!-- message -->
					<message v-if="itemDataStat === 'fail'" :title="'Oops terjadi kesalahan:'" :errorData="itemData">
					</message>

					<!-- table data -->
					<table-data 
						:title="title" 
						:kelas="kelas"></table-data>

				</div>
			</div>
		</div>

	</div>
</template>

<script>
	import { useAuthStore } from '../../stores/auth';
	import { useAsetTetapJenisStore } from '../../stores/asetTetapJenis';
	import pageHeader from "../../components/pageHeader.vue";
	import message from "../../components/message.vue";
	import tableData from "./table.vue";

	export default {
		components: {
			pageHeader,
			message,
			tableData,
		},
		setup() {
			const authStore = useAuthStore();
			const asetTetapJenisStore = useAsetTetapJenisStore();
			return { authStore, asetTetapJenisStore };
		},
		data() {
			return {
				title: 'Jenis Aset Tetap',
				kelas: 'asetTetapJenis',
				titleDesc: 'Mengelola data jenis aset tetap',
				titleIcon: 'icon-grid6',
			}
		},
		created(){
			this.checkUser('index_aset_tetap_jenis',this.$route.params.cu);
		},
		methods: {
			checkUser(permission,id_cu){
				if(this.currentUser){
					if(!this.currentUser.can || !this.currentUser.can[permission]){
						this.$router.push('/notFound');
					}
				}
			}
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			itemData() {
				return this.asetTetapJenisStore.dataS;
			},
			itemDataStat() {
				return this.asetTetapJenisStore.dataStatS;
			},
		}
	}
</script>