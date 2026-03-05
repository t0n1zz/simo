/**
 * Composable to use VeeValidate 4 with existing template API (errors.has('form.x'), errors.first('form.x')).
 * Use in setup() of form components; keep using v-model="form.xxx" bound to Pinia store.
 *
 * @param {import('vue').Ref|import('vue').ComputedRef} formRef - Ref/computed to store form data (e.g. toRef(store, 'data'))
 * @param {Object} validationSchema - Schema object (e.g. { name: 'required|min:5', email: 'email' })
 * @returns { { errors: import('vue').ComputedRef, handleSubmit: Function, setValues: Function, validate: Function } }
 */
import { useForm } from 'vee-validate';
import { computed } from 'vue';

export function useFormValidation(formRef, validationSchema) {
  const { errors, handleSubmit: vvHandleSubmit, setValues, setFieldValue, validate } = useForm({
    initialValues: formRef,
    validationSchema,
  });

  const errorsAdapter = computed(() => {
    const e = errors.value || {};
    return {
      has(field) {
        const key = String(field).replace(/^form\./, '');
        return !!e[key];
      },
      first(field) {
        const key = String(field).replace(/^form\./, '');
        return e[key] || '';
      },
      any(scope) {
        const keys = Object.keys(e);
        if (!keys.length) return false;
        if (scope === 'form' || !scope) return true;
        const prefix = scope.replace(/\.$/, '');
        return keys.some((k) => k === prefix || k.startsWith(prefix + '.'));
      },
      get items() {
        return Object.entries(e).map(([field, msg]) => ({ field: 'form.' + field, msg }));
      },
      collect() {
        return Object.entries(e).map(([field, msg]) => ({ field: 'form.' + field, msg }));
      },
    };
  });

  return {
    errors: errorsAdapter,
    handleSubmit: vvHandleSubmit,
    setValues,
    setFieldValue,
    validate,
  };
}
