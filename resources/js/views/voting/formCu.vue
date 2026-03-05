<template>
	<div>
		<form @submit.prevent="save">
      <!-- status -->
      <div class="form-group">

        <!-- title -->
        <h5>Pilih CU:</h5>

        <!-- select -->
        <select name="status" data-width="100%" class="form-control" v-model="form.id_cu" :disabled="modelCUStat === 'loading'">
          <option disabled value="">Silahkan pilih CU</option>
					<option v-for="(cu, index) in modelCU" :value="cu.id" :key="index">
						{{cu.name}}
					</option>
        </select>

      </div>

      <!-- divider -->
      <hr>
      
      <!-- tombol desktop-->
      <div class="text-center d-none d-md-block">
        <button class="btn btn-light" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>

        <button type="submit" class="btn btn-primary" :disabled="form.id_cu == ''">
          <i class="icon-floppy-disk"></i> Simpan</button>
      </div>  

      <!-- tombol mobile-->
      <div class="d-block d-md-none">
        <button type="submit" class="btn btn-primary btn-block pb-2" :disabled="form.id_cu == ''">
          <i class="icon-floppy-disk"></i> Simpan</button>

        <button class="btn btn-light btn-block pb-2" @click.prevent="tutup">
          <i class="icon-cross"></i> Tutup</button>
      </div> 
    </form>	

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useCuStore } from '../../stores/cu';
	import { useVotingStore } from '../../stores/voting';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";

	export default {
		props: ['kelas','id','id_cu'],
		components: {
			formInfo,
			message
		},
		data() {
			return {
				form: {
					id: '',
					id_cu: ''
        },
			}
		},
		created() {
      this.form.id = this.id;
      this.form.id_cu = this.id_cu;

			if(this.currentUser.id_cu === 0){
				if(this.modelCuStat != 'success'){
					this.getHeader();
				}
			}
		},
		watch: {
		},
		methods: {
			...mapActions(useCuStore, {
				getHeader: 'getHeader',
			}),
			...mapActions(useVotingStore, {
				updateSuaraCu: 'updateSuaraCu',
			}),
      save(){
				this.updateSuaraCu(this.form);
      },
			tutup() {
				this.$emit('tutup');
			}
		},
		computed: {
			...mapState(useAuthStore, {
				currentUser: 'currentUser'
			}),
			...mapState(useCuStore,{
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
			}),
		}
	}
</script>