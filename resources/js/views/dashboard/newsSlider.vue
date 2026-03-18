<template>
  <div class="dashboard-slider">
    <!-- Single visible slide (carousel) -->
    <div class="slider-track" :style="trackStyle">
      <div
        v-for="(item, index) in sliderItem" :key="item.id"
        class="slider-slide card card-body"
        :class="{ 'slider-slide--active': index === currentIndex }"
        :style="item.style"
      >
        <!-- welcome -->
        <div v-if="item.name === 'welcome'" class="slider-slide__content">
          <h1 class="slider-slide__title">{{ item.title }}</h1>
          <span v-html="item.content"></span>
          <br/>
          <a :href="item.buttonUrl" class="btn btn-danger mt-1" target="_blank" v-if="item.isButton" v-html="item.buttonTitle"></a>
        </div>

        <!-- birthday -->
        <div v-else-if="item.name === 'birthday'" class="slider-slide__content">
          <h1 class="slider-slide__title">{{ item.title }}</h1>
          <span class="badge bg-blue-400 align-self-center ml-2 mb-1" v-for="(item2, index2) in item.cu" :key="index2">
            <h6 class="mb-0">{{ 'CU ' + item2.name + ' Ke- ' + item2.usia }}</h6>
          </span>
          <br/><br/>
          <h4 v-html="item.content" class="d-none d-md-block"></h4>
        </div>

        <!-- news: light box with dark text so it's readable -->
        <div v-else-if="item.name === 'news'" class="slider-slide__content slider-slide__content--news">
          <h1 class="slider-slide__title slider-slide__title--overlay">{{ item.title }}</h1>
          <div class="slider-slide__news-box">
            <span class="slider-slide__news-text" v-html="item.content"></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Dots + prev/next (only when more than one slide) -->
    <template v-if="sliderItem.length > 1">
      <button type="button" class="slider-nav slider-nav--prev" aria-label="Previous" @click="prev">
        <i class="icon-arrow-left5"></i>
      </button>
      <button type="button" class="slider-nav slider-nav--next" aria-label="Next" @click="next">
        <i class="icon-arrow-right5"></i>
      </button>
      <div class="slider-dots">
        <button
          v-for="(item, index) in sliderItem" :key="item.id"
          type="button"
          class="slider-dot"
          :class="{ 'slider-dot--active': index === currentIndex }"
          :aria-label="'Slide ' + (index + 1)"
          @click="goTo(index)"
        ></button>
      </div>
    </template>
  </div>
</template>

<script type="text/javascript">
	import { useAuthStore } from '../../stores/auth';
	import CUAPI from '../../api/cu';
	import ARTIKELSIMOAPI from '../../api/artikelSimo';
  
	export default{
		components: {
		},
		setup() {
			return {
				authStore: useAuthStore(),
			};
		},
		data() {
			return {birthdayData: [],
				birthdayDataStat: '',
				newsData: [],
				newsDataStat: '',
				slideData: [],
				currentIndex: 0,
				autoPlayTimer: null,
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
		created() {
			this.getBirthday();
		},
		beforeUnmount() {
			if (this.autoPlayTimer) clearInterval(this.autoPlayTimer);
		},
		mounted() {
			this.startAutoPlay();
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
		methods: {
			prev() {
				this.currentIndex = this.currentIndex <= 0 ? this.sliderItem.length - 1 : this.currentIndex - 1;
			},
			next() {
				this.currentIndex = this.currentIndex >= this.sliderItem.length - 1 ? 0 : this.currentIndex + 1;
			},
			goTo(index) {
				this.currentIndex = index;
			},
			startAutoPlay() {
				if (this.autoPlayTimer) clearInterval(this.autoPlayTimer);
				this.autoPlayTimer = setInterval(() => {
					if (this.sliderItem.length > 1) this.next();
				}, 6000);
			},
			getBirthday() {
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
			trackStyle() {
				return {
					transform: `translateX(-${this.currentIndex * 100}%)`,
				};
			},
			currentUser() {
				return this.authStore.currentUser;
			},
		},
	}
</script>

<style scoped>
	.dashboard-slider {
		position: relative;
		overflow: hidden;
		border-radius: 0.375rem;
		margin-bottom: 1rem;
	}
	.slider-track {
		display: flex;
		transition: transform 0.4s ease;
		width: 100%;
	}
	.slider-slide {
		flex: 0 0 100%;
		min-width: 100%;
		min-height: 180px;
		padding: 1.5rem 2rem;
	}
	.slider-slide__content {
		position: relative;
		z-index: 1;
	}
	.slider-slide__title {
		margin-bottom: 0.5rem;
	}
	.slider-slide__title--overlay {
		text-shadow: 0 1px 2px rgba(0,0,0,0.3);
	}
	/* News slide: readable text on light box */
	.slider-slide__news-box {
		background: rgba(255, 255, 255, 0.92);
		border-radius: 6px;
		padding: 1rem 1.25rem;
		margin-top: 0.5rem;
		max-width: 100%;
	}
	.slider-slide__news-text {
		color: #333;
		font-size: 0.95rem;
		line-height: 1.5;
		display: block;
	}
	.slider-slide__news-text :deep(p) {
		color: #333;
		margin-bottom: 0.5rem;
	}
	.slider-slide__news-text :deep(a) {
		color: #2563eb;
	}
	/* Nav buttons */
	.slider-nav {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		z-index: 2;
		width: 40px;
		height: 40px;
		border: none;
		border-radius: 50%;
		background: rgba(0, 0, 0, 0.4);
		color: #fff;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: background 0.2s;
	}
	.slider-nav:hover {
		background: rgba(0, 0, 0, 0.6);
	}
	.slider-nav--prev { left: 12px; }
	.slider-nav--next { right: 12px; }
	/* Dots */
	.slider-dots {
		position: absolute;
		bottom: 12px;
		left: 0;
		right: 0;
		display: flex;
		justify-content: center;
		gap: 8px;
		z-index: 2;
	}
	.slider-dot {
		width: 10px;
		height: 10px;
		border-radius: 50%;
		border: none;
		background: rgba(255, 255, 255, 0.5);
		cursor: pointer;
		padding: 0;
		transition: background 0.2s;
	}
	.slider-dot:hover {
		background: rgba(255, 255, 255, 0.8);
	}
	.slider-dot--active {
		background: #fff;
		box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.2);
	}
</style>