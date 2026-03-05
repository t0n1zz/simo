<template>
	<div>
		<VeeForm :form="formSertifikat" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">

		<!-- asal -->
		<div class="form-group" :class="{'has-error' : errors && errors.has && errors.has('formSertifikat')}" v-if="mode == 'create'">

			<!-- error message -->
			<small class="text-muted text-danger" v-if="errors && errors.has && errors.has('formSertifikat')">
				<i class="icon-arrow-small-right"></i> {{ errors && errors.first && errors.first('formSertifikat') }}
			</small>
			<small class="text-muted" v-else>&nbsp;</small>
		</div>

		<data-viewer :title="'Sertifikat'" :columnData="columnDataSertifikat"  :itemData="itemDataSertifikat" :query="query" :itemDataStat="itemDataSertifikatStat" @fetch="fetch" :isDasar="'true'" :isNoButtonRow="'true'" v-if="mode == 'create'">

			<!-- item  -->
			<template #item-desktop="props">
				<tr :class="{ 'bg-info': selectedItem.id === props.item.id }" class="text-nowrap" @click="selectedRow(props.item)">
					<td>
						{{ props.index + 1 + (+itemDataSertifikat.current_page-1) * +itemDataSertifikat.per_page + '.'}}
					</td>
					<td>
						<check-value :value="props.item.kode_sertifikat"></check-value>
					</td>
					<td>
						<check-value :value="props.item.name"></check-value>
					</td>
					
				</tr>
			</template>

		</data-viewer>

		<!-- message -->
		<message v-if="errors && errors.any && errors.any() && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors && errors.items">
		</message>
		<!-- divider -->
		<hr>

		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formSertifikat.id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formSertifikat.id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div>

		</form>
		</VeeForm>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useSertifikatKegiatanStore } from '../../stores/sertifikatKegiatan';
	import checkValue from '../../components/checkValue.vue';
	import DataViewer from '../../components/dataviewer2.vue';
	import message from "../../components/message.vue";
	import VeeForm from "../../components/VeeForm.vue";

	export default {
		props: ['mode','selected'],
		components: {
			DataViewer,
			checkValue,
			message,
			VeeForm
		},
		data() {
			return {
				title: '',
				kelas: 'sertifikat',
				selectedItem: [],
				formSertifikat:{
					id_sertifikat: '',
                    kode_sertifikat:'',
					name: '',},
				query: {
					order_column: "name",
					order_direction: "asc",
					filter_match: "and",
					limit: 5,
					page: 1
				},
				columnDataSertifikat: [
					{ title: 'No.' },
					{ title: 'Kode Sertifikat' },
					{
						title: 'Nama',
						name: 'name',
						tipe: 'string',
						sort: true,
						hide: false,
						disable: false,
						filter: true,
						filterDefault: true
					},
				],
				submited: false,
			}
		},
		created(){
			if(this.mode == 'edit'){
				this.formSertifikat = Object.assign({}, this.selected);
			}
			this.fetch(this.query);
		},
		updated(){
			
		},
		methods: {
			...mapActions(useSertifikatKegiatanStore, {
				fetchSertifikat: 'index',
			}),
			fetch(params){
				this.fetchSertifikat(params);
			},
			
			deleteSelected(){
				this.formSertifikat.id_sertifikat = '';
				this.selectedItem = '';
			},
			selectedRow(item){
				this.selectedItem = item;
				this.formSertifikat.id_sertifikat = item.id;
				this.formSertifikat.name = item.name;
				this.formSertifikat.kode_sertifikat = item.kode_sertifikat;
				
			},
			onValid() {
				if (this.mode == 'edit') {
					this.$emit('editSertifikat', this.formSertifikat);
				} else {
					this.$emit('createSertifikat', this.formSertifikat);
				}
				this.submited = false;
			},
			onInvalid() {
				this.submited = true;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {
			...mapState(useAuthStore,{
				currentUser: 'currentUser'
			}),
			...mapState(useSertifikatKegiatanStore,{
				itemDataSertifikat: 'dataS',
				itemDataSertifikatStat: 'dataStatS',
				updateMessage: 'update',
				updateStat: 'updateStat'
			}),	
		}
	}
</script>