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
import { mapGetters } from 'vuex';
import lineChart from '../../components/lineChartLocal.vue';

export default {
	components:{
		lineChart
	},
	props:['title','kelas','columnData'],
  data(){
    return {
			pages: [],
			titleText:'Grafik Statistik Gerakan',
			dataShownTitle1:'Aset',
			dataShownName1:'aset',
			axisLabelKey:'periode',
    }
	},
	created() {
		this.fetch();
	},
	watch: {
		// check route changes
		'$route' (to, from){
			this.fetch();
		},
	},
	methods: {
		// fetching data from database
		fetch(){
			this.$store.dispatch(this.kelas + '/index');
		},
	},
	computed: {
		...mapGetters('laporanGerakan',{
			itemData: 'dataS',
			itemDataStat: 'dataStatS',
		}),
		sortedItemData: function () {
      return _.sortBy(this.itemData.data, ['periode']);
    },
		safeColumnData: function () {
			// Filter out undefined/null values from columnData
			if (!this.columnData || !Array.isArray(this.columnData)) {
				return [];
			}
			return this.columnData.filter(column => column != null);
		}
	}
}
</script>