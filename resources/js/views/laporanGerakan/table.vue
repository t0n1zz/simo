<template>
	<div>

		<!-- main panel -->
		<data-viewer :title="title" :columnData="columnData" :itemData="itemData" :query="query" :itemDataStat="itemDataStat" :excelDownloadUrl="excelDownloadUrl" :isUploadExcel="false" @fetch="fetch">

			<!-- desktop -->
			<!-- button desktop -->
			<template #button-desktop>

				<!-- tambah -->
				<router-link :to="{ name: kelas + 'Create'}" class="btn btn-light mb-1" v-if="currentUser.can && currentUser.can['create_laporan_cu'] && currentUser.id_cu == 0">
					<i class="icon-plus3"></i> Tambah
				</router-link>

				<!-- ubah-->
				<button @click.prevent="ubahData(selectedItem.id)" class="btn btn-light mb-1" v-if="currentUser.can && currentUser.can['update_laporan_cu'] && currentUser.id_cu == 0" :disabled="!selectedItem.id">
					<i class="icon-pencil5"></i> Ubah
				</button>

				<!-- hapus -->
				<button @click.prevent="modalConfirmOpen('hapus')" class="btn btn-light mb-1" v-if="currentUser.can && currentUser.can['destroy_laporan_cu'] && currentUser.id_cu == 0" :disabled="!selectedItem.id">
					<i class="icon-bin2"></i> Hapus
				</button>

			</template>

			<!-- button mobile -->
			<template #button-mobile>

				<!-- tambah -->
				<router-link :to="{ name: kelas + 'Create'}" class="btn btn-light btn-block mb-1" v-if="currentUser.can && currentUser.can['create_laporan_cu'] && currentUser.id_cu == 0">
					<i class="icon-plus3"></i> Tambah
				</router-link>

				<!-- ubah-->
				<button @click.prevent="ubahData(selectedItem.id)" class="btn btn-light btn-block mb-1" v-if="currentUser.can && currentUser.can['update_laporan_cu'] && currentUser.id_cu == 0" :disabled="!selectedItem.id">
					<i class="icon-pencil5"></i> Ubah
				</button>

				<!-- hapus -->
				<button @click.prevent="modalConfirmOpen('hapus')" class="btn btn-light btn-block mb-1" v-if="currentUser.can && currentUser.can['destroy_laporan_cu'] && currentUser.id_cu == 0" :disabled="!selectedItem.id">
					<i class="icon-bin2"></i> Hapus
				</button>
				
			</template>

			<!-- item desktop -->
			<template #item-desktop="props">
				<tr :class="{ 'bg-info': selectedItem.id === props.item.id }" class="text-nowrap" @click="selectedRow(props.item)">
					<td v-if="!columnData[0].hide">
						{{ props.index + 1 + (+itemData.current_page-1) * +itemData.per_page + '.'}}
					</td>
					<td v-if="!columnData[1].hide">
						{{ $filters.dateMonth(props.item.periode) }}
					</td>
					<td v-if="!columnData[2].hide">
						<check-value :value="props.item.lk" valueType="currency"></check-value>
					</td>
					<td v-if="!columnData[3].hide">
						<check-value :value="props.item.pr" valueType="currency"></check-value>
					</td>
					<td v-if="!columnData[4].hide">
						<check-value :value="props.item.total_anggota" valueType="currency"></check-value>
					</td>
					<td v-if="!columnData[5].hide">
						<check-value :value="props.item.aset" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[6].hide">
						<check-value :value="props.item.shu" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[7].hide">
						<check-value :value="props.item.piutang_anggota" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[8].hide">
						<check-value :value="props.item.piutang_lalai" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[9].hide">
						<check-value :value="props.item.simpanan_anggota" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[10].hide">
						<check-value :value="props.item.dcu" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[11].hide">
						<check-value :value="props.item.dcr" valueType="currency"></check-value>
					</td>
          <td v-if="!columnData[12].hide">
						<check-value :value="props.item.aset_lancar" valueType="currency"></check-value>
					</td>
					<td v-if="!columnData[13].hide" v-html="$filters.dateTime(props.item.created_at)"></td>
					<td v-if="!columnData[14].hide">
						<span v-if="props.item.created_at !== props.item.updated_at" v-html="$filters.dateTime(props.item.updated_at)"></span>
						<span v-else>-</span>
					</td>
				</tr>
			</template>

		</data-viewer>
					
		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :button="modalButton" @tutup="modalTutup" @confirmOk="modalConfirmOk" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalTutup">
		</app-modal>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useLaporanGerakanStore } from '../../stores/laporanGerakan';
	import DataViewer from '../../components/dataviewer2.vue';
	import appModal from '../../components/modal.vue';
	import checkValue from '../../components/checkValue.vue';

	export default {
		components: {
			DataViewer,
			appModal,
			checkValue
		},
		props:['title','kelas','columnData'],
		data() {
			return {
				selectedItem: [],
				query: {
					order_column: "periode",
					order_direction: "desc",
					filter_match: "and",
					limit: 10,
					page: 1
				},
				excelDownloadUrl: '',
				state: '',
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalButton: ''
			}
		},
		created(){
			this.fetch(this.query);
		},
		watch: {
			// check route changes
			'$route' (to, from){
				this.fetch(this.query);
			},

			// when updating data
      updateStat(value) {
				this.modalState = value;
				this.modalButton = 'Ok';
				
				if(value === "success"){
					this.modalTitle = this.updateMessage.message;
					this.modalContent = '';
					this.fetch(this.query);
				}else if(value === "fail"){
					this.modalContent = this.updateMessage;
				}else{
					this.modalContent = '';
				}
			}
    },
		methods: {
			...mapActions(useLaporanGerakanStore, ['index', 'destroy', 'resetUpdateStat']),
			fetch(params){
        this.index(params);
        this.excelDownloadUrl = this.kelas;
			},
			resetParams(){
				this.params.search_column = 'periode';
				this.params.search_query_1 = '';

				this.extSearchColumn = 'periode';
				this.extSearchQuery1 = '';
			},
			selectedRow(item){
				this.selectedItem = item;
			},
			ubahData(id, id_cu) {
				this.$router.push({name: this.kelas + 'Edit', params: { id: id }});
			},
			modalConfirmOpen(state, isMobile, itemMobile) {
				this.modalShow = true;
				this.modalState = 'confirm-tutup';
				this.state = state;

				if(isMobile){
					this.selectedItem = itemMobile;
				}

				if (state == 'hapus') {
					this.modalTitle = 'Hapus ' + this.title + ' ' + this.selectedItem.name + ' ?';
					this.modalButton = 'Iya, Hapus';
				}
			},
			modalTutup() {
				this.modalShow = false;
				this.resetUpdateStat();
			},
			modalConfirmOk() {
				if (this.state == 'hapus') {
					this.destroy(this.selectedItem.id);
				}
			}
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useLaporanGerakanStore,{
				itemData: 'dataS',
				itemDataStat: 'dataStatS',
				updateMessage: 'update',
				updateStat: 'updateStat'
			}),
		}
	}
</script>