<template>
  <div style="display: inline-block">
    <span v-if="value" style="display: inline-block">
      <span v-if="valueType == 'trim'" style="display: inline-block">
         {{ trimString(frontText + ' ' + value) }}
         <template v-if="isLongEnough">
            <button class="btn btn-light btn-sm ml-1" @click.prevent="modalOpen()">Lihat</button>
         </template>
      </span>
      <span v-else-if="valueType == 'modal'" style="display: inline-block">
        {{ value.substring(0, 50) }}
        <template v-if="isLongEnough">
          ...
          <button
            class="btn btn-light"
            @click.prevent="modalOpen()"
          >
            Lihat
          </button>
        </template>
      </span>
      <span v-else-if="valueType == 'currency'" style="display: inline-block"
        >{{ frontText }}
        {{ currency(value, 0, { thousandsSeparator: "." }) }}</span
      >
      <span v-else-if="valueType == 'percentage'" style="display: inline-block"
        >{{ frontText }} {{ percentage(value, 2) }}</span
      >
      <span v-else-if="valueType == 'decimal'" style="display: inline-block"
        >{{ frontText }} {{ round(value, 2) }}</span
      >
      <span v-else style="display: inline-block"
        ><b>{{ frontText }}</b> {{ value }}</span
      >
    </span>
    <span v-else style="display: inline-block"
      >{{ frontText }} {{ empty }}</span
    >

    <!-- modal -->
    <app-modal
      :show="modalShow"
      :state="modalState"
      :title="modalTitle"
      :button="modalButton"
      :content="modalContent"
      @tutup="modalTutup"
      @backgroundClick="modalTutup"
    >
    </app-modal>
  </div>
</template>

<script type="text/javascript">
// import truncate from "vue-truncate-collapsed"; // Removing potentially incompatible Vue 2 lib
import appModal from './modal.vue';
import { currency, percentage, round, trimString } from '../helpers/filterHelpers';

export default {
  components: {
    // truncate,
    appModal,
  },
  props: {
    value: {
      default: "",
    },
    frontText: {
      default: "",
    },
    trimLength: {
      default: 50,
    },
    valueType: {
      default: "trim",
    },
    empty: {
      default: "-",
    },
  },
  data() {
    return {
      modalShow: false,
      modalState: "",
      modalTitle: "",
      modalContent: "",
      modalButton: "",
    };
  },
  methods: {
    currency,
    percentage,
    round,
    trimString,
    modalOpen() {
      this.modalShow = true;
      this.modalState = "content-tutup";
      this.modalContent = this.value;
      this.modalButton = "Tutup";
    },
    modalTutup() {
      this.modalShow = false;
    },
    strip(html) {
      var tmp = document.createElement("DIV");
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || "";
    },
  },
  computed: {
    isLongEnough() {
      return this.value && this.value.length > this.trimLength;
    },
  },
};
</script>