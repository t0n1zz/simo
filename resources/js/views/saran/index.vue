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
	import { useSaranStore } from '../../stores/saran';
	import pageHeader from "../../components/pageHeader.vue";
	import message from "../../components/message.vue";
	import tableData from "./table.vue";
	
	export default {
		components: {
			pageHeader,
			message,
			tableData,
		},
		data() {
			return {
				title: 'Saran',
				kelas: 'saran',
				titleDesc: 'Mengelola data saran',
				titleIcon: 'icon-lifebuoy',
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useSaranStore, {
				itemData: 'dataS',
				itemDataStat: 'dataStatS',
			})
		}
	}
</script>