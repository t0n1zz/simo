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

					<!-- select data -->
					<select-cu 
						:kelas="kelas"
						:path="selectCuPath"
						:isPus="true"
						v-if="currentUser.id_cu == 0"></select-cu>

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
	import { useArtikelStore } from '../../stores/artikel';
	import pageHeader from "../../components/pageHeader.vue";
	import message from "../../components/message.vue";
	import selectCu from "../../components/selectCu.vue";
	import tableData from "./table.vue";
	
	export default {
		components: {
			pageHeader,
			message,
			selectCu,
			tableData,
		},
		data() {
			return {
				authStore: useAuthStore(),
				artikelStore: useArtikelStore(),
				title: 'Artikel',
				kelas: 'artikel',
				titleDesc: 'Mengelola data artikel',
				titleIcon: 'icon-magazine',
				selectCuPath: 'artikelCu',
			}
		},
		created(){
			this.checkUser('index_artikel',this.$route.params.cu);
		},
		methods: {
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
			}
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			},
			itemData() {
				return this.artikelStore.dataS;
			},
			itemDataStat() {
				return this.artikelStore.dataStatS;
			}
		}
	}
</script>