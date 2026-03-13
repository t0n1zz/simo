<template>
	<div>

		<!-- main panel -->
		<data-viewer :title="title" :columnData="columnData" :itemData="itemData" :query="query" :itemDataStat="itemDataStat" :excelDownloadUrl="excelDownloadUrl" :isUploadExcel="false" @fetch="fetch">

			<!-- desktop -->
			<!-- button desktop -->
			<template #button-desktop>

				<!-- tambah -->
				<button @click.prevent="modalConfirmOpen('tambah')"  class="btn btn-light mb-1" v-if="currentUser.can && currentUser.can['create_pengumuman']">
					<i class="icon-plus3"></i> Tambah
				</button>

				<!-- ubah-->
				<button @click.prevent="modalConfirmOpen('ubah')" class="btn btn-light mb-1" v-if="currentUser.can && currentUser.can['update_pengumuman']" :disabled="!selectedItem.id">
					<i class="icon-pencil5"></i> Ubah
				</button>

				<!-- hapus -->
				<button @click.prevent="modalConfirmOpen('hapus')" class="btn btn-light mb-1" v-if="currentUser.can && currentUser.can['destroy_pengumuman']" :disabled="!selectedItem.id">
					<i class="icon-bin2"></i> Hapus
				</button>

			</template>

			<!-- button mobile -->
			<template #button-mobile>

				<!-- tambah -->
				<button @click.prevent="modalConfirmOpen('tambah')" class="btn btn-light btn-block mb-1" v-if="currentUser.can && currentUser.can['create_pengumuman']">
					<i class="icon-plus3"></i> Tambah
				</button>

				<!-- ubah-->
				<button @click.prevent="modalConfirmOpen('ubah')" class="btn btn-light btn-block mb-1" v-if="currentUser.can && currentUser.can['update_pengumuman']" :disabled="!selectedItem.id">
					<i class="icon-pencil5"></i> Ubah
				</button>

				<!-- hapus -->
				<button @click.prevent="modalConfirmOpen('hapus')" class="btn btn-light btn-block mb-1" v-if="currentUser.can && currentUser.can['destroy_pengumuman']" :disabled="!selectedItem.id">
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
						<check-value :value="props.item.name"></check-value>
					</td>
					<td v-if="!columnData[2].hide && !columnData[2].disable">
						<check-value :value="props.item.cu.name" :empty="columnData[2].groupNoKey" v-if="props.item.cu"></check-value>
						<span v-else>PUSKOPCUINA</span>
					</td>
					<td v-if="!columnData[3].hide" v-html="$filters.dateTime(props.item.created_at)"></td>
					<td v-if="!columnData[4].hide">
						<span v-if="props.item.created_at !== props.item.updated_at" v-html="$filters.dateTime(props.item.updated_at)"></span>
						<span v-else>-</span>
					</td>
				</tr>
			</template>

		</data-viewer>
					
		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :button="modalButton" :content="modalContent" :color="modalColor"  @tutup="modalTutup" @confirmOk="modalConfirmOk" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalTutup">
			
			<!-- title -->
			<template #modal-title>
				{{ modalTitle }}
			</template>

			<!-- pengumuman -->
			<template #modal-body1>
				<form-pengumuman 
				:currentUser="currentUser"
				:state="state"
				:id="selectedItem.id"
				@cancelClick="modalTutup"></form-pengumuman>
			</template>

		</app-modal>

	</div>
</template>

<script>
	import { mapState } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { usePengumumanStore } from '../../stores/pengumuman';
	import DataViewer from '../../components/dataviewer2.vue';
	import appModal from '../../components/modal.vue';
	import checkValue from '../../components/checkValue.vue';
	import formPengumuman from './form.vue';

	export default {
		components: {
			DataViewer,
			appModal,
			checkValue,
			formPengumuman
		},
		props:['title','kelas'],
		data() {
			return {
				pengumumanStore: usePengumumanStore(),
				selectedItem: [],
				query: {
					order_column: "created_at",
					order_direction: "desc",
					filter_match: "and",
					limit: 10,
					page: 1
				},
				excelDownloadUrl: '',
				columnData: [
					{
						title: 'No.',
						name: 'No.',
						tipe: 'string',
						sort: false,
						hide: false,
						disable: false
					},
					{
						title: 'Pengumuman',
						name: 'name',
						tipe: 'string',
						sort: true,
						hide: false,
						disable: false,
						filter: true,
						filterDefault: true
					},
					{
						title: 'CU',
						name: 'cu.name',
						tipe: 'string',
						sort: false,
						hide: false,
						disable: false,
						filter: true,
					},
					{
						title: 'Tgl. Buat',
						name: 'created_at',
						tipe: 'datetime',
						sort: true,
						hide: false,
						disable: false,
						filter: true,
					},
					{
						title: 'Tgl. Ubah',
						name: 'updated_at',
						tipe: 'datetime',
						sort: true,
						hide: false,
						disable: false,
						filter: true,
					}
				],
				state: '',
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalContent: '',
				modalColor: '',
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
					this.fetch();
				}else if(value === "fail"){
					this.modalContent = this.updateMessage;
				}else{
					this.modalContent = '';
				}
			}
    },
		methods: {
			fetch(params){
				if(this.$route.params.cu == 'semua'){
					this.disableColumnCu(false);
					this.pengumumanStore.index(params);
					this.excelDownloadUrl = this.kelas;
				}else{
					this.disableColumnCu(true);
					this.pengumumanStore.indexCu([params,this.$route.params.cu]);
					this.excelDownloadUrl = this.kelas + '/indexCu/' + this.$route.params.cu;
				}
			},
			disableColumnCu(status){
				this.columnData[2].disable = status;
			},
			resetParams(){
				this.params.search_column = 'name';
				this.params.search_query_1 = '';

				this.extSearchColumn = 'name';
				this.extSearchQuery1 = '';
			},
			selectedRow(item){
				this.selectedItem = item;
			},
			modalConfirmOpen(state, isMobile, itemMobile) {
				this.modalShow = true;
				
				this.state = state;

				if(isMobile){
					this.selectedItem = itemMobile;
				}

				if (state == 'hapus') {
					this.modalState = 'confirm-tutup';
					this.modalColor = '';
					this.modalTitle = 'Hapus ' + this.title + ' ' + this.selectedItem.name + ' ?';
					this.modalButton = 'Iya, Hapus';
				}else if(state == 'ubah'){
					this.modalState = 'normal1';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Ubah ' + this.title;
					this.modalButton = 'Ok';
				}else if(state == 'tambah'){
					this.modalState = 'normal1';
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Tambah ' + this.title;
					this.modalButton = 'Ok';
				}
			},
			modalTutup() {
				this.modalShow = false;
				this.pengumumanStore.resetUpdateStat();
			},
			modalConfirmOk() {
				if (this.state == 'hapus') {
					this.pengumumanStore.destroy(this.selectedItem.id);
				}
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(usePengumumanStore, {
				itemData: 'dataS',
				itemDataStat: 'dataStatS',
				updateMessage: 'updateData',
				updateStat: 'updateStat'
			}),
		}
	}
</script>