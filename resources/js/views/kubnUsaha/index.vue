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
	import { mapState } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useKubnStore } from '../../stores/kubn';
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
				title: 'Usaha',
				kelas: 'kubnUsaha',
				titleDesc: 'Mengelola data usaha',
				titleIcon: 'icon-price-tag2',
			}
		},
		created(){
			this.checkUser('index_kubn');
		},
		methods: {
			checkUser(permission){
				if(this.currentUser){
					if(!this.currentUser.can || !this.currentUser.can[permission]){
						this.$router.push('/notFound');
					}
				}
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useKubnStore, {
				itemData: 'dataS',
				itemDataStat: 'dataStatS',
			}),
		}
	}
</script>