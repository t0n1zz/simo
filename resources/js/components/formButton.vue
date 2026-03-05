<template>
    <div>
      
      <!-- tombol desktop-->
      <div class="text-center d-none d-md-block" v-if="!isSingleButton">

        <!-- tutup -->
        <button type="button" @click.prevent="cancelClick" class="btn btn-light" v-if="cancelState ==='methods'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </button>

        <!-- batal -->
        <router-link type="button" :to="{ name: cancelLink }" class="btn btn-light" v-if="cancelState ==='link'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </router-link>

        <!-- simpan -->
        <button
          type="submit"
          class="btn btn-primary ml-1"
          :disabled="loading || (resolvedButtonErrors && resolvedButtonErrors.any && resolvedButtonErrors.any(formValidation))"
          v-if="confirmState ==='submit'"
        >
          <template v-if="loading"><i class="icon-spinner2 spinner"></i> {{ loadingTitle }}</template>
          <template v-else><i :class="confirmIcon"></i> {{ confirmTitle }}</template>
        </button>

        <button
          type="button"
          class="btn btn-primary ml-1"
          :disabled="loading"
          @click.prevent="confirmClick"
          v-else
        >
          <template v-if="loading"><i class="icon-spinner2 spinner"></i> {{ loadingTitle }}</template>
          <template v-else><i :class="confirmIcon"></i> {{ confirmTitle }}</template>
        </button>

      </div>

      <!-- tombol mobile-->
      <div class="d-block d-md-none" v-if="!isSingleButton">

        <!-- simpan -->
        <button type="submit" class="btn btn-primary btn-block pb-2" :disabled="loading || (resolvedButtonErrors && resolvedButtonErrors.any && resolvedButtonErrors.any(formValidation))" v-if="confirmState ==='submit'">
          <template v-if="loading"><i class="icon-spinner2 spinner"></i> {{ loadingTitle }}</template>
          <template v-else><i :class="confirmIcon"></i> {{ confirmTitle }}</template>
        </button>

        <button type="button" class="btn btn-primary btn-block pb-2" :disabled="loading" @click.prevent="confirmClick" v-else>
          <template v-if="loading"><i class="icon-spinner2 spinner"></i> {{ loadingTitle }}</template>
          <template v-else><i :class="confirmIcon"></i> {{ confirmTitle }}</template>
        </button>

        <!-- tutup -->
        <button class="btn btn-light btn-block" @click.prevent="cancelClick"  v-if="cancelState ==='methods'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </button>

        <!-- batal -->
        <router-link type="button" :to="{ name: cancelLink }" class="btn btn-light btn-block" v-if="cancelState ==='link'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </router-link>
        
      </div>

      <!-- tombol desktop-->
      <div class="text-center d-none d-md-block" v-if="isSingleButton">

        <!-- tutup -->
        <button type="button" @click.prevent="cancelClick" class="btn btn-light" v-if="cancelState ==='methods'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </button>

        <!-- batal -->
        <router-link type="button" :to="{ name: cancelLink }" class="btn btn-light"  v-if="cancelState ==='link'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </router-link>

      </div>

      <div class="d-block d-md-none" v-if="isSingleButton">

        <!-- tutup -->
        <button class="btn btn-light btn-block" @click.prevent="cancelClick"  v-if="cancelState ==='methods'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </button>

        <!-- batal -->
        <router-link type="button" :to="{ name: cancelLink }" class="btn btn-light btn-block" v-if="cancelState ==='link'">
          <i :class="cancelIcon"></i> {{ cancelTitle }}
        </router-link>
        
      </div>

    </div>
</template>

<script type="text/javascript">

  export default {
    props: {
      isSingleButton: false,
      formValidation:{},
      buttonErrors: {
        type: Object,
        default: null,
      },
      loading: {
        type: Boolean,
        default: false,
      },
      loadingTitle: {
        default: 'Menyimpan...'
      },
      confirmTitle: {
        default: 'Simpan'
      },
      confirmIcon: {
        default: 'icon-floppy-disk'
      },
      confirmLink:{
        default: ''
      },
      confirmState:{
        default: 'submit'
      },
      cancelTitle: {
        default: 'Batal'
      },
      cancelIcon: {
        default: 'icon-arrow-left13'
      },
      cancelLink:{
        default: ''
      },
      cancelState:{
        default: 'link'
      }
    },
    data() {
      return {
        _defaultButtonErrors: {
          any: () => false,
          has: () => false,
          first: () => '',
          collect: () => [],
          items: [],
        },
      };
    },
    computed: {
      resolvedButtonErrors() {
        return this.buttonErrors != null ? this.buttonErrors : this._defaultButtonErrors;
      },
    },
    mounted() {},
    methods:{
      confirmClick(){
        this.$emit('confirmClick');
      },
      cancelClick(){
        this.$emit('cancelClick');
      }
    }
  }
</script>