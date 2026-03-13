<template>
  <div class="check-value-wrap">
    <span v-if="value" style="display: inline-block">
      <span v-if="valueType == 'trim'" style="display: inline-block">
         <span v-if="expandedTrim" class="check-value-expanded">{{ plainTextTrim }}</span>
         <span v-else class="check-value-collapsed">
           {{ displayTextTrim }}
           <span
             v-if="isLongEnoughTrim"
             class="check-value-ellipsis text-primary cursor-pointer"
             @click.prevent="toggleExpandTrim()"
             role="button"
             tabindex="0"
             @keydown.enter.prevent="toggleExpandTrim()"
             @keydown.space.prevent="toggleExpandTrim()"
           >...</span>
         </span>
         <span
           v-if="isLongEnoughTrim && expandedTrim"
           class="check-value-ellipsis text-primary cursor-pointer ml-1"
           @click.prevent="toggleExpandTrim()"
           role="button"
           tabindex="0"
           @keydown.enter.prevent="toggleExpandTrim()"
           @keydown.space.prevent="toggleExpandTrim()"
         > (tutup)</span>
      </span>
      <span v-else-if="valueType == 'modal'" style="display: inline-block">
        <span v-if="expandedModal" class="check-value-expanded">{{ plainTextModal }}</span>
        <span v-else class="check-value-collapsed">
          {{ displayTextModal }}
          <span
            v-if="isLongEnoughModal"
            class="check-value-ellipsis text-primary cursor-pointer"
            @click.prevent="toggleExpandModal()"
            role="button"
            tabindex="0"
            @keydown.enter.prevent="toggleExpandModal()"
            @keydown.space.prevent="toggleExpandModal()"
          >...</span>
        </span>
        <span
          v-if="isLongEnoughModal && expandedModal"
          class="check-value-ellipsis text-primary cursor-pointer ml-1"
          @click.prevent="toggleExpandModal()"
          role="button"
          tabindex="0"
          @keydown.enter.prevent="toggleExpandModal()"
          @keydown.space.prevent="toggleExpandModal()"
        > (tutup)</span>
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
import { currency, percentage, round } from '../helpers/filterHelpers';

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
      expandedTrim: false,
      expandedModal: false,
    };
  },
  methods: {
    currency,
    percentage,
    round,
    toggleExpandTrim() {
      this.expandedTrim = !this.expandedTrim;
    },
    toggleExpandModal() {
      this.expandedModal = !this.expandedModal;
    },
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
    plainTextTrim() {
      return this.strip((this.frontText + ' ' + (this.value || '')).trim());
    },
    plainTextModal() {
      return this.strip(this.value || '');
    },
    displayTextTrim() {
      if (!this.plainTextTrim) return '';
      return this.isLongEnoughTrim
        ? this.plainTextTrim.substring(0, this.trimLength)
        : this.plainTextTrim;
    },
    displayTextModal() {
      if (!this.plainTextModal) return '';
      return this.isLongEnoughModal
        ? this.plainTextModal.substring(0, this.trimLength)
        : this.plainTextModal;
    },
    isLongEnoughTrim() {
      return this.plainTextTrim.length > this.trimLength;
    },
    isLongEnoughModal() {
      return this.plainTextModal.length > this.trimLength;
    },
    isLongEnough() {
      return this.value && this.value.length > this.trimLength;
    },
  },
};
</script>

<style scoped>
.check-value-wrap {
  display: block;
}
.check-value-collapsed {
  white-space: nowrap;
}
.check-value-expanded {
  white-space: normal;
  word-wrap: break-word;
}
.check-value-ellipsis:hover {
  text-decoration: underline;
}
</style>