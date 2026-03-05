<template>
	<div>
		<VeeForm :form="form" v-slot="{ errors, handleSubmit }">
			<!-- message -->
			<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
			</message>

			<form @submit.prevent="handleSubmit(onValid, onInvalid)">

				<!-- name -->
				<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('form.name')}">
						<i class="icon-cross2" v-if="errors.has('form.name')"></i>
						Nama: <wajib-badge></wajib-badge></h5>

					<!-- text -->
					<Field
						name="name"
						rules="required"
						v-model="form.name"
						v-slot="{ field }"
					>
						<input
							type="text"
							class="form-control"
							placeholder="Silahkan masukkan kode"
							@keydown.space.prevent
							v-bind="field"
						>
					</Field>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('form.name')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>

	      <!-- divider -->
	      <hr>
	      
	      <!-- tombol desktop-->
	      <div class="text-center d-none d-md-block">
	        <button class="btn btn-light" @click.prevent="tutup">
	          <i class="icon-cross"></i> Tutup</button>

	        <button type="submit" class="btn btn-primary" :disabled="errors.any('form')">
	          <i class="icon-floppy-disk"></i> Simpan</button>
	      </div>  

	      <!-- tombol mobile-->
	      <div class="d-block d-md-none">
	        <button type="submit" class="btn btn-primary btn-block pb-2" :disabled="errors.any('form')">
	          <i class="icon-floppy-disk"></i> Simpan</button>

	        <button class="btn btn-light btn-block pb-2" @click.prevent="tutup">
	          <i class="icon-cross"></i> Tutup</button>
	      </div> 
	    </form>	
		</VeeForm>

	</div>
</template>

<script>
	import { mapState, mapActions } from 'pinia';
	import { useAuthStore } from '../../stores/auth';
	import { useCuStore } from '../../stores/cu';
	import { usePemilihanStore } from '../../stores/pemilihan';
	import message from "../../components/message.vue";
	import formInfo from "../../components/formInfo.vue";
	import wajibBadge from "../../components/wajibBadge.vue";
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';

	export default {
		props: ['kelas','id','id_cu','selectedItem','mode'],
		components: {
			formInfo,
			message,
			wajibBadge,
			VeeForm,
			Field,
		},
		data() {
			return {
				form: {
					id: '',
					pemilihan_id: '',
					id_cu: '',
					name: '',
        },
				submited: false,
			}
		},
		created() {
			this.form.pemilihan_id = this.id;

			if(this.mode == 'edit'){
				this.form.id = this.selectedItem.id;
				this.form.id_cu = this.selectedItem.id_cu;
				this.form.name = this.selectedItem.name;
			}

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
				getHeader: 'getHeader'
			}),
			...mapActions(usePemilihanStore, {
				storeSuara: 'storeSuara',
				updateSuara: 'updateSuara'
			}),
      onValid(){
				if(this.mode === 'edit'){
					this.updateSuara([this.form.id, this.form]);
				}else{
					this.storeSuara(this.form);
				}
				this.submited = false;
      },
			onInvalid(){
				window.scrollTo(0, 0);
				this.submited = true;
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