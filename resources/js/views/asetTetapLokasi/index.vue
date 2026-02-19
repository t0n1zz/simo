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
	import { useAsetTetapLokasiStore } from '../../stores/asetTetapLokasi';
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
			const asetTetapLokasiStore = useAsetTetapLokasiStore();
			return { authStore, asetTetapLokasiStore };
		},
		data() {
			return {
				title: 'Lokasi Aset Tetap',
				kelas: 'asetTetapLokasi',
				titleDesc: 'Mengelola data lokasi aset tetap',
				titleIcon: 'icon-drawer3',
			}
		},
		created(){
			this.checkUser('index_aset_tetap_lokasi',this.$route.params.cu);
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
				return this.asetTetapLokasiStore.dataS;
			},
			itemDataStat() {
				return this.asetTetapLokasiStore.dataStatS;
			},
		}
	}
</script>