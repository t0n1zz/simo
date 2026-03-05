<template>
  <Form :initial-values="form" v-slot="slotProps" :key="formKey" @invalid-submit="onInvalidSubmit">
    <slot
      :errors="errorsAdapter(slotProps.errors)"
      :handle-submit="slotProps.handleSubmit"
      :set-values="slotProps.setValues"
    />
  </Form>
</template>

<script>
import { Form } from 'vee-validate';

/**
 * Adapter so existing templates can use errors.has('form.name'), errors.first('form.name'), etc.
 */
function errorsAdapter(e) {
  const err = e || {};
  return {
    has(field) {
      const key = String(field).replace(/^form\./, '');
      return !!err[key];
    },
    first(field) {
      const key = String(field).replace(/^form\./, '');
      return err[key] || '';
    },
    any(scope) {
      const keys = Object.keys(err);
      if (!keys.length) return false;
      if (scope === 'form' || !scope) return true;
      return keys.some((k) => k === scope || k.startsWith(scope + '.'));
    },
    get items() {
      return Object.entries(err).map(([field, msg]) => ({ field: 'form.' + field, msg }));
    },
  };
}

export default {
  name: 'VeeForm',
  components: { Form },
  props: {
    form: {
      type: Object,
      required: true,
    },
    formKey: {
      type: [String, Number],
      default: '',
    },
    onInvalidSubmit: {
      type: Function,
      default: undefined,
    },
  },
  methods: {
    errorsAdapter,
  },
};
</script>
