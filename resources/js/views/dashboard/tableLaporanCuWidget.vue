<template>
  <div class="card">
    <div class="card-header bg-grey-400 header-elements-inline">
      <h6 class="card-title"><i></i><i class="icon-table2 mr-2"></i> Tabel Perkembangan</h6>
      <div class="header-elements">
        <span v-if="itemDataStat == 'success' && id_cu != 0"><i class="badge badge-mark border-warning"></i> {{ $filters.dateMonth(itemData.data[itemData.total-1]['periode']) }}</span>
        <span v-if="itemDataStat == 'success' && id_cu == 0"><i class="badge badge-mark border-warning"></i> {{ $filters.dateMonth(itemData[0]['periode']) }}</span>
      </div>
    </div>

    <!-- bkcu -->
    <div class="card-body pb-0" v-if="itemData && id_cu == 0">

      <!-- tableCu -->
      <div class="row text-center">

        <div class="col-6">
          <div class="mb-3" v-if="itemDataStat == 'success'">
            <h5 class="font-weight-semibold mb-0">
              <check-value :value="itemData[0]['cu']"></check-value>
            </h5>
            <span class="text-muted font-size-sm">Total CU</span>
          </div>
          <div class="mb-3" v-else-if="itemDataStat == 'loading'">
            <h5 class="font-weight-semibold mb-0">
              <i class="icon-spinner2 spinner"></i>
            </h5>
            <span class="text-muted font-size-sm">Total CU</span>
          </div>
        </div>

        <div class="col-6">
          <div class="mb-3" v-if="itemDataStat == 'success'">
            <h5 class="font-weight-semibold mb-0">
              <check-value :value="itemData[0]['cu_sesuai'].cu"></check-value>
            </h5>
            <span class="text-muted font-size-sm">CU Sesuai Periode</span>
          </div>
          <div class="mb-3" v-else-if="itemDataStat == 'loading'">
            <h5 class="font-weight-semibold mb-0">
              <i class="icon-spinner2 spinner"></i>
            </h5>
            <span class="text-muted font-size-sm">Total CU</span>
          </div>
        </div>

        <div class="col-6">
          <div class="mb-3" v-if="itemDataStat == 'success'">
            <h5 class="font-weight-semibold mb-0">
              <check-value :value="itemData[0]['rasio_beredar']" valueType="percentage"></check-value>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Beredar</span>
          </div>
          <div class="mb-3" v-else-if="itemDataStat == 'loading'">
            <h5 class="font-weight-semibold mb-0">
              <i class="icon-spinner2 spinner"></i>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Beredar</span>
          </div>
        </div>

        <div class="col-6">
          <div class="mb-3" v-if="itemDataStat == 'success'">
            <h5 class="font-weight-semibold mb-0">
              <check-value :value="itemData[0]['rasio_lalai']" valueType="percentage"></check-value>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Lalai</span>
          </div>
          <div class="mb-3" v-else-if="itemDataStat == 'loading'">
            <h5 class="font-weight-semibold mb-0">
              <i class="icon-spinner2 spinner"></i>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Lalai</span>
          </div>
        </div>

      </div>
    </div>

    <!-- cu -->
    <div class="card-body pb-0" v-if="itemData.data && id_cu != 0">

      <!-- tableCu -->
      <div class="row text-center">

        <div class="col-6">
          <div class="mb-3" v-if="itemDataStat == 'success'">
            <h5 class="font-weight-semibold mb-0">
              <check-value :value="itemData.data[itemData.total-1]['rasio_beredar']" valueType="percentage"></check-value>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Beredar</span>
          </div>
          <div class="mb-3" v-else-if="itemDataStat == 'loading'">
            <h5 class="font-weight-semibold mb-0">
              <i class="icon-spinner2 spinner"></i>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Beredar</span>
          </div>
        </div>

        <div class="col-6">
          <div class="mb-3" v-if="itemDataStat == 'success'">
            <h5 class="font-weight-semibold mb-0">
              <check-value :value="itemData.data[itemData.total-1]['rasio_lalai']" valueType="percentage"></check-value>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Lalai</span>
          </div>
          <div class="mb-3" v-else-if="itemDataStat == 'loading'">
            <h5 class="font-weight-semibold mb-0">
              <i class="icon-spinner2 spinner"></i>
            </h5>
            <span class="text-muted font-size-sm">Rasio Piutang Lalai</span>
          </div>
        </div>

      </div>
    </div>

    <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-grey-400 border-x-0 border-bottom-0 border-top-grey-300 mb-0">


      <!-- tabel cu -->
      <li class="nav-item">
        <a href="#" class="nav-link" :class="{'active' : tabTabelName == 'tabelCu'}" @click.prevent="changeTabelTab('tabelCu')">{{ tabTitle}}</a>
      </li>

      <!-- tabel pearls -->
      <li class="nav-item">
        <a href="#" class="nav-link" :class="{'active' : tabTabelName == 'tabelPearls'}" @click.prevent="changeTabelTab('tabelPearls')" v-if="id_cu != 0">P.E.A.R.L.S. CU</a>
      </li>

    </ul>

    <transition enter-active-class="animated fadeIn" mode="out-in">
      <div class="table-responsive table-scrollable"  v-show="tabTabelName == 'tabelCu'">
        <table class="table text-nowrap">
          <thead>
            <tr>
              <th>Nama Akun</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(column, colIndex) in safeColumnData" :key="colIndex">
              <td class="font-weight-semibold">{{column.title}}</td>
              <td v-if="itemDataStat == 'success' && id_cu != 0">
                <check-value :value="itemData.data[itemData.total-1][column.name]" valueType="currency" v-if="column.name != 'rasio_beredar' && column.name != 'rasio_lalai'"></check-value>
              </td>
              <td v-if="itemDataStat == 'success' && id_cu == 0">
                <check-value :value="itemData[0][column.name]" valueType="currency" v-if="column.name != 'rasio_beredar' && column.name != 'rasio_lalai'"></check-value>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </transition>

    <transition enter-active-class="animated fadeIn" mode="out-in">
      <div class="table-responsive table-scrollable" v-show="tabTabelName == 'tabelPearls'">
        <table class="table text-nowrap">
          <thead>
            <tr>
              <th>Nama Akun</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(column, colIndex) in safeColumnDataPearls" :key="colIndex">
              <td class="font-weight-semibold" v-html="column.title"></td>
              <td v-if="itemPearlsDataStat == 'success'">
                <item-pearls
                  :type="column.name"
                  :props="itemPearlsData.data[0]"
                ></item-pearls>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </transition>
    
  </div>
</template>

<script type="text/javascript">
  import _ from 'lodash';
  import { useLaporanCuStore } from '../../stores/laporanCu';
  import checkValue from "../../components/checkValue.vue";
  import itemPearls from "../laporanCu/itemPearls.vue";

  export default {
    components: {
      checkValue,
      itemPearls
    },
    props: {
      id_cu: {
        type: [String, Number],
        default: 0
      },
      columnData: {
        type: Array,
        default: () => ([])
      },
      columnDataPearls: {
        type: Array,
        default: () => ([])
      }
    },
    data(){
      return {tabTitle: 'CU',
        tabTabelName: 'tabelCu',
        isTabelPearls: false,
        isTabelGerakan: false,
        itemData: [],
        itemDataStat: '',
        itemPearlsData: [],
        itemPearlsDataStat: '',
        isFirstLoad: false,
        isFirstPearlsLoad: false,
      }
    },
    created(){
      this.removeColumn();
      if(this.id_cu == 0){
        this.tabTitle = 'Gerakan';
      }
    },
    watch: {
      grafikDataStat(value){
        if (value === "success") {
          if(!this.isFirstLoad){
            this.itemData = this.grafikData;
            this.itemDataStat = this.grafikDataStat
            this.isFirstLoad = true;
          }
        }
      },
      grafikPearlsDataStat(value){
        if (value === "success") {
          if(!this.isFirstPearlsLoad){
            this.itemPearlsData = this.grafikPearlsData;
            this.itemPearlsDataStat = this.grafikPearlsDataStat;
            this.isFirstPearlsLoad = true;
          }
        }
      }
    },
		methods:{
      removeColumn(){
        // Don't mutate props - work with safe filtered data instead
        // The safeColumnData computed property already filters out nulls
        // This method is now just for backward compatibility
        // The actual filtering happens in the computed properties
      },
			changeTabelTab(value) {
				this.tabTabelName = value;
				if (value == 'tabelPearls' && !this.isTabelPearls) {
          this.isTabelPearls = true

          if(this.itemPearlsDataStat != 'success')
          {
            let query = {
              order_column: "p1",
              order_direction: "desc",
              filter_match: "and",
              limit: 50,
              page: 1
            };

            this.laporanCuStore.grafikPearlsCu([query,this.id_cu]);
          }
				}
			},
    },
    computed: {
      safeColumnData() {
        const disabledIndices = [1,2,3,4,5,6,32,33,46,47,48,49];
        return (this.columnData || [])
          .map((column, index) => column ? {...column, disable: disabledIndices.includes(index)} : null)
          .filter((column, index) => column != null && column.tipe && !column.disable);
      },
      safeColumnDataPearls() {
        const disabledIndices = [1,2,3,4,5,6,7,23,24,25,26];
        return (this.columnDataPearls || [])
          .map((column, index) => column ? {...column, disable: disabledIndices.includes(index)} : null)
          .filter((column, index) => column != null && column.tipe && !column.disable);
      },
      grafikData() {
        return this.laporanCuStore.grafik;
      },
      grafikDataStat() {
        return this.laporanCuStore.grafikStat;
      },
      grafikPearlsData() {
        return this.laporanCuStore.grafikPearls;
      },
      grafikPearlsDataStat() {
        return this.laporanCuStore.grafikPearlsStat;
      },
    }
  }
</script>
