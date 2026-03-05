<template>
	<div>
		<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit }">
		<form @submit.prevent="handleSubmit(onValid)">

			<!-- message -->
			<message v-if="errors.any('form') && submited" :title="'Oops terjadi kesalahan'" :errorItem="errors.items">
			</message>

			<!-- content -->
			<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors.has('form.name')}">
					<i class="icon-cross2" v-if="errors.has('form.name')"></i>
					Pengumuman:
				</h5>

				<!-- textarea -->
				<Field
					name="name"
					rules="required|min:5|max:160"
					v-model="form.name"
					v-slot="{ field }"
				>
					<textarea
						rows="5"
						type="text"
						class="form-control"
						placeholder="Silahkan masukkan pengumuman di website anda"
						v-bind="field"
					></textarea>
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors.has('form.name')">
					<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
				</small>
				<small class="text-muted" v-else>Maksimal karakter yang bisa dimunculkan di pengumuman adalah 160 karakter.
				</small>
			</div>

			<!-- CU -->
			<div class="form-group" v-if="currentUser.id_cu == 0" :class="{'has-error' : errors.has('form.id_cu')}">

				<!-- title -->
				<h5 :class="{ 'text-danger' : errors.has('form.id_cu')}">
					<i class="icon-cross2" v-if="errors.has('form.id_cu')"></i>
					CU:
				</h5>

				<!-- select -->
				<Field
					name="id_cu"
					rules="required"
					v-model="form.id_cu"
					v-slot="{ field }"
				>
					<select
						class="form-control"
						data-width="100%"
						v-bind="field"
						:disabled="modelCU.length === 0"
					>
						<option disabled value="">Silahkan pilih CU</option>
						<option value="0"><span v-if="currentUser.pus">{{currentUser.pus.name}}</span> <span v-else>PUSKOPCUINA</span></option>
						<option disabled value="">----------------</option>
						<option v-for="(cu, index) in modelCU" :value="cu.id" :key="index">{{cu.name}}</option>
					</select>
				</Field>

				<!-- error message -->
				<small class="text-muted text-danger" v-if="errors.has('form.id_cu')">
					<i class="icon-arrow-small-right"></i> {{ errors.first('form.id_cu') }}
				</small>
				<small class="text-muted" v-else>&nbsp;</small>
			</div>

			<hr>
			<form-button
				:cancelTitle="cancelTitle"
				:cancelIcon="cancelIcon"
				:cancelState="cancelState"
				:formValidation="'form'"
				@cancelClick="cancelClick"></form-button>

		</form>
		</VeeForm>

	</div>
</template>

<script>
	import { mapState } from 'pinia';
	import { usePengumumanStore } from '../../stores/pengumuman';
	import { useCuStore } from '../../stores/cu';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import VeeForm from '../../components/VeeForm.vue';
	import { Field } from 'vee-validate';

	export default {
		props: ['currentUser','state','id'],
		components: {
			message,
			formButton,
			VeeForm,
			Field,
		},
		data() {
			return {
				pengumumanStore: usePengumumanStore(),
				cuStore: useCuStore(),
				kelas: 'pengumuman',
				submited: false,
				cancelTitle: 'Tutup',
				cancelIcon: 'icon-cross',
				cancelState: 'methods'
			}
		},
		created(){
			this.fetch();
		},
		watch: {
      formStat(value) {
				if(value === "success"){
					if(this.state == 'tambah'){
						if(this.$route.params.cu == 'semua'){
							this.form.id_cu = 0;
						}else{
							this.form.id_cu = this.$route.params.cu;
						}
					}
				}
			}
    },
		methods: {
			fetch(){
				if(this.state == 'ubah'){
					this.pengumumanStore.edit(this.id);	
				}else{
					this.pengumumanStore.create();
				}
			},
			onValid(values) {
				const payload = {
					...this.form,
					...values,
				};

				if (this.state == 'ubah') {
					this.pengumumanStore.update([this.id, payload]);
				} else {
					if (this.currentUser.id_cu != 0) {
						payload.id_cu = this.currentUser.id_cu;
					}
					this.pengumumanStore.store(payload);
				}

				this.submited = false;
			},
			onInvalid() {
				window.scrollTo(0, 0);
				this.submited = true;
			},
			cancelClick(){
				this.$emit('cancelClick');
			}
		},
		computed: {
			...mapState(usePengumumanStore, {
				form: 'data',
				formStat: 'dataStat',
				updateMessage: 'updateData',
				updateStat: 'updateStat'
			}),
			...mapState(useCuStore, {
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
			}),
		}
	}
</script>