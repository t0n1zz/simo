<template>
	<div>
		<!-- first navbar -->
		<div class="navbar navbar-expand-lg navbar-dark bg-indigo">

			<div class="navbar-brand wmin-0 mr-0">
				<a href="#" class="d-inline-block">
					<img src="/images/simo.png">
				</a>
			</div>


			<div>
				<span class="navbar-text ml-lg-3 mr-lg-auto">
					<span class="badge bg-success-400">PUSKOPCUINA 
					</span>
				</span>	
			</div>

		</div>

		<!-- Page header -->
		<div>
			<div class="page-header">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4>
							<i class="mr-2" :class="titleIcon"></i>
							<span class="font-weight-semibold">{{ title }}</span> 
							<small class="d-block text-muted">{{ titleDesc }}</small>
						</h4>
					</div>
				</div>
			</div>
		</div>
		
		<!-- page container -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">
					<VeeForm :form="form" :on-invalid-submit="onInvalid" v-slot="{ errors, handleSubmit, setValues }">
					<form @submit.prevent="setValues(form) || handleSubmit(onValid)" enctype="multipart/form-data">

						<div class="card card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<h5>Silahkan masukan kode voting</h5>
										<Field name="kode" rules="required" v-model="form.kode" v-slot="{ field }"><input type="text" class="form-control" placeholder="Silahkan masukkan kode voting" v-bind="field"></Field>
									</div>
								</div>
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="errors.any('form')">
										<i :class="titleIcon"></i> Ok
									</button>
								</div>
							</div>
						</div>

					</form>
					</VeeForm>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
	import { Field } from 'vee-validate';
	import VeeForm from '../../components/VeeForm.vue';
	import message from "../../components/message.vue";
	import appModal from '../../components/modal.vue';
	import checkValue from '../../components/checkValue.vue';

	export default {
		components: {
			VeeForm,
			Field,
			message,
			appModal,
			checkValue,
		},
		data() {
			return {
				title: 'Voting',
				titleDesc: 'Silahkan memasukan kode voting',
				kelas: 'voting',
				titleIcon: 'icon-point-up',
				form: {
					kode: '',
				},
				selectedItem: {},
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				modalButton: ''
			}
		},
		created(){
		},
		watch: {
		},
		methods: {
			onValid(values){
				window.location.href = window.location.origin + '/admins/voting/pilih/' + this.form.kode;
			},
			onInvalid(){
				window.scrollTo(0, 0);
			},
		},
		computed: {
		}
	}
</script>