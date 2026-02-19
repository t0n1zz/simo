<template>
<div>
	<!-- header -->
	<router-view name="header" v-slot="{ Component }">
		<transition 
			enter-active-class="animated fadeInDown"
			leave-active-class="animated fadeOutUp"
			mode="out-in"
		>
			<component :is="Component" />
		</transition>
	</router-view>
	
	<!-- body -->
	<router-view v-slot="{ Component }">
		<transition 
			enter-active-class="animated fadeIn"
			leave-active-class=""
			mode="out-in"
		>
			<loading-page v-if="isLoading"></loading-page>
			<component :is="Component" v-else />
		</transition>
	</router-view>
	
</div>
</template>

<script>
	import { useGlobalStore } from './stores/global';
	import loadingPage from "./views/loading.vue";

	export default {
		components: {
			loadingPage
		},
		computed:{
			isLoading() {
				const globalStore = useGlobalStore();
				return globalStore.getIsLoading;
			}
		},
	}
</script>
