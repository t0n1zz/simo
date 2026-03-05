<template>
<div>
	<!-- laporancu -->
	<line-chart
		:titleText="titleText"
		:title="title"
		:dataShownTitle1="dataShownTitle1"
		:dataShownName1="dataShownName1"
		:axisLabelKey="axisLabelKey"
		:itemData="sortedItemData"
		:itemDataStat="itemDataStat"
		:columnData="safeColumnData"
		></line-chart>
</div>
</template>

<script>
import _ from 'lodash';
import { useLaporanGerakanStore } from '../../stores/laporanGerakan';
import lineChart from '../../components/lineChartLocal.vue';

export default {
	components: {
		lineChart,
	},
	props: ['title', 'kelas', 'columnData'],
	data() {
		return {
			laporanGerakanStore: useLaporanGerakanStore(),
			pages: [],
			titleText: 'Grafik Statistik Gerakan',
			dataShownTitle1: 'Aset',
			dataShownName1: 'aset',
			axisLabelKey: 'periode',
		};
	},
	created() {
		this.fetch();
	},
	watch: {
		$route() {
			this.fetch();
		},
	},
	methods: {
		fetch() {
			this.laporanGerakanStore.index();
		},
	},
	computed: {
		itemData() {
			return this.laporanGerakanStore.dataS;
		},
		itemDataStat() {
			return this.laporanGerakanStore.dataStatS;
		},
		sortedItemData() {
			const data = this.itemData && this.itemData.data;
			return data ? _.sortBy(data, ['periode']) : [];
		},
		safeColumnData() {
			if (!this.columnData || !Array.isArray(this.columnData)) {
				return [];
			}
			return this.columnData.filter((column) => column != null);
		},
	},
}
</script>