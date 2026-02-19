<template>
  <div>
    <div v-for="(item, index) in sliderItem" :key="index" class="card card-body mb-3" :style="item.style">
      
      <!-- welcome -->
      <div v-if="item.name == 'welcome'">
        <h1>{{ item.title }}</h1>
        <span v-html="item.content"></span>
        <br/>
        <a :href="item.buttonUrl" class="btn btn-danger mt-1" target="_blank" v-if="item.isButton" v-html="item.buttonTitle">
        </a>
      </div>

      <!-- birthday -->
      <div v-else-if="item.name == 'birthday'">
        <h1>{{ item.title }}</h1>
        <span class="badge bg-blue-400 align-self-center ml-2 mb-1" v-for="(item2, index2) in item.cu" :key="index2">
          <h6 class="mb-0">{{ 'CU ' + item2.name + ' Ke- ' + item2.usia }}</h6>
        </span>
        <br/><br/>
        <h4 v-html="item.content" class="d-none d-md-block"></h4>
      </div>

      <!-- news -->
      <div v-else-if="item.name == 'news'">
        <h1>{{ item.title }}</h1>
        <div class="p-3" style="background: rgba(255,255,255,0.9); border-radius: 5px;">
          <span v-html="item.content"></span>
        </div>
      </div>

    </div>
  </div>
</template>

<script type="text/javascript">
	import { useAuthStore } from '../../stores/auth';
	import CUAPI from '../../api/cu';
	import ARTIKELSIMOAPI from '../../api/artikelSimo';
  
	export default{
		components: {
		},
		data(){
			return{
				authStore: useAuthStore(),
				birthdayData: [],
				birthdayDataStat: '',
				newsData: [],
				newsDataStat: '',
				slideData: [],
				sliderItem: [
					{
						name: 'welcome',
						title: 'Selamat Datang Di SIMO',
						content: '<h5 class="d-none d-md-block">Sistem Informasi Manajemen Organisasi yang menyimpan dan mengolah data CU dalam gerakan PUSKOPCUINA.</h5> Baru pertama kali masuk ke SIMO? <br/>agar tidak bingung silahkan membaca panduan terlebih dahulu',
						isButton: true,
						buttonUrl: 'https://puskopcuina.org/panduan',
						buttonTitle: '<i class="icon-book mr-2"></i>Panduan',
						style: {
							'background-image': 'url("/images/welcomeSIMO.png")',
							'background-position': 'center',
							'background-repeat': 'no-repeat',
							'background-size': 'cover',
							'color': '#FFFFFF',
						}
					},
				],
			}
		},
		created(){
			this.getBirthday();
		},
		watch: {
			birthdayDataStat(value){
				if(value == 'success'){
					if(this.birthdayData.length > 0){
						let item = {
							name: 'birthday',
							title: 'Selamat Ulang Tahun Kepada',
							content: 'Semoga semakin maju berkembang dan bertumbuh bersama anggota',
							cu: [],
							style: {
								'background-image': 'url("/images/birthday.jpg")',
								'background-position': 'center',
								'background-repeat': 'no-repeat',
								'background-size': 'cover',
								'color': '#FFFFFF',
							}
						};
						item.cu = this.birthdayData;
						this.sliderItem.push(item);
					}
					this.getNews();
				}
			},
			newsDataStat(value){
				if(value == 'success'){
					var valData;
					for(valData of this.newsData){
						this.addNewsSlide(valData.name,valData.ringkasan,valData.gambar);
					}
				}
			}
		},
		methods:{
			getBirthday(){
				this.birthdayDataStat = 'loading';

				CUAPI.getBirthday()
        .then((response) => {
					this.birthdayData = response.data.model;
          this.birthdayDataStat = 'success';
        })
        .catch( error => {
					this.birthdayData = error.response;
          this.birthdayDataStat = 'fail';
        });
			},
			getNews(){
				this.newsDataStat = 'loading';

				ARTIKELSIMOAPI.get()
        .then((response) => {
					this.newsData = response.data.model;
          this.newsDataStat = 'success';
        })
        .catch( error => {
					this.newsData = error.response;
          this.newsDataStat = 'fail';
        });
			},
			addNewsSlide(title,content,image){
				let item = {
					name: 'news',
					title: title,
					content: content,
					style: {
						'background-image': 'url("/images/artikel_simo/'+ image +'.jpg")',
						'background-position': 'center',
						'background-repeat': 'no-repeat',
						'background-size': 'cover',
            'color': '#FFFFFF',
					}
				};
				this.sliderItem.push(item);
			}
		},
		computed: {
			currentUser() {
				return this.authStore.currentUser;
			}
		}
	}
</script>

<style scoped>
	.slideStyle {
		padding-top: 3em;
		padding-left: 2em;
		padding-right: 2em;
		text-align: center;
		align-items: center;
		justify-content: center;
		border-radius: 10px;
	}
</style>