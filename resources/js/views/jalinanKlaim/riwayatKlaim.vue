<template>
	<div>
		<!-- itemdata -->
		<div v-if="itemDataStat == 'success'">
			<div v-if="itemData.length > 0">
				<div class="card border-left-primary rounded-left-0" v-for="(history,index) in history" :key="index">
					<div class="card-header bg-white header-elements-sm-inline">
						<h6 class="card-title">
							&nbsp;
						</h6>
						<div class="header-elements">
							<ul class="list-inline mb-0">
								<li class="list-inline-item"><i class="icon-calendar2"></i> <span v-html="formatDate(index)"></span></li>
								<li class="list-inline-item"><i></i><i class="icon-alarm"></i> <span v-html="formatTime(index)"></span></li>
							</ul>
						</div>
					</div>

					<div class="card-body">	

						<div class="card card-body" v-for="(rev, index) in history" :key="index">
							<div class="media">
								<div class="mr-3 position-relative">
									<img :src="'/images/user/' + rev.user.gambar + '.jpg'" width="36" height="36" class="rounded-circle"  alt="user image" v-if="rev.user.gambar">
									<img src="/images/no_image_man.jpg" width="36" height="36" class="rounded-circle" alt="user image" v-else>
								</div>

								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">{{ rev.user.username }}</span>
										</a>
									</div>

									<span>Telah mengubah 
										<mark>{{ rev.key }}</mark>
										dari
										<template v-if="rev.key == 'status_klaim'">
											<mark><span v-html="formatStatusKlaim(rev.old_value)"></span></mark>
											menjadi 
											<mark><span v-html="formatStatusKlaim(rev.new_value)"></span></mark>
										</template>
										<template v-else>
											<mark>{{ rev.old_value }}</mark>
											menjadi 
											<mark>{{ rev.new_value }}</mark>
										</template>  
									</span>
								</div>
								
							</div>
						</div>

					</div>

				</div>
			</div>

			<!-- no itemdata -->
			<div v-else>
				<div class="card">
					<div class="card-body">
						<h3>Belum terdapat riwayat bantuan solidaritas apapun...</h3>
					</div>
				</div>
			</div>

		</div>

		<!-- loading -->
		<div v-if="itemDataStat == 'loading'">
			<div class="card">
				<div class="card-body">
					<h4>Mohon tunggu...</h4>
					<div class="progress">
						<div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated" style="width: 100%">
							<span class="sr-only">100% Complete</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</template>

<script>
	import checkValue from '../../components/checkValue.vue';
	import { date, time, month, year, currency, percentage2, statusKlaimJalinan } from '../../helpers/filterHelpers';

	export default {
		props: ['itemData','itemDataStat'],
		components:{
			checkValue,
		},
		data(){
			return {
			}
		},
		created(){
		},
		watch: {
    },
		methods: {
			// formating
			formatDate(value){
				return date(value);
			},
			formatTime(value){
				return time(value);
			},
			formatStatusKlaim(value){
				return statusKlaimJalinan(value);
			},
			formatPeriode(value){
				return month(value) + ' ' + year(value);
			},
			formatCurrency(value){
				return currency(value,'',0,{ thousandsSeparator: '.'});
			},
			formatPercentage(value){
				return percentage2(value,2);
			},
			countTotal(value1,value2){
				return value1 - value2;
			},
			countPercentage(value1,value2){
				if(value2 > 0){
					return this.formatPercentage((this.countTotal(value1,value2) / value2));
				}else{
					return this.formatPercentage('0');
				}
			}
		},
		computed: {
			history(){
				return _.groupBy(this.itemData,'created_at');
			},
		}
	}
</script>