/**
 * Simple manual form validation (replaces VeeValidate 2 / $validator in forms).
 * Use with errors object and errorItems in component; see views that use validateForm.
 */

const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const URL_REGEX = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/;

function required(value) {
    const v = value != null ? String(value).trim() : '';
    return v.length > 0 ? null : 'Field wajib diisi';
}

function minLen(value, n) {
    const v = value != null ? String(value).trim() : '';
    if (v.length === 0) return null;
    return v.length >= n ? null : `Minimal ${n} karakter`;
}

function email(value) {
    const v = value != null ? String(value).trim() : '';
    if (v.length === 0) return null;
    return EMAIL_REGEX.test(v) ? null : 'Format e-mail tidak valid';
}

function url(value) {
    const v = value != null ? String(value).trim() : '';
    if (v.length === 0) return null;
    return URL_REGEX.test(v) ? null : 'Format URL tidak valid';
}

/**
 * @param {Record<string, any>} formData - form object (e.g. store.data)
 * @param {Record<string, string[]>} rules - e.g. { 'form.name': ['required'], 'form.kode': ['required', 'min:5'] }
 * @param {Record<string, string>} [labels] - optional field labels for messages, e.g. { 'form.name': 'Nama' }
 * @returns {{ valid: boolean, errors: Record<string, string>, errorItems: { msg: string }[] }}
 */
export function validateForm(formData, rules, labels = {}) {
    const errors = {};
    for (const [field, ruleList] of Object.entries(rules)) {
        const value = field.startsWith('form.') ? formData[field.slice(6)] : formData[field];
        const label = labels[field] || field;
        for (const r of ruleList) {
            let msg = null;
            if (r === 'required') {
                msg = required(value);
            } else if (r.startsWith('min:')) {
                const n = parseInt(r.slice(4), 10);
                msg = minLen(value, isNaN(n) ? 1 : n);
            } else if (r === 'email') {
                msg = email(value);
            } else if (r === 'url') {
                msg = url(value);
            }
            if (msg) {
                errors[field] = msg;
                break;
            }
        }
    }
    const errorItems = Object.values(errors).map((msg) => ({ msg }));
    return {
        valid: Object.keys(errors).length === 0,
        errors,
        errorItems,
    };
}

/**
 * Build an errors API compatible with existing templates that use errors.has('form.x') and errors.first('form.x').
 * Pass the `errors` object returned from validateForm(); this returns a proxy-like object with has(), first(), any(), items.
 */
export function errorsApi(errorsObj) {
    return {
        has(field) {
            return !!(errorsObj && errorsObj[field]);
        },
        first(field) {
            return (errorsObj && errorsObj[field]) || '';
        },
        any(scope) {
            if (!errorsObj) return false;
            const prefix = scope ? scope + '.' : '';
            return Object.keys(errorsObj).some((k) => k === prefix || k.startsWith(prefix));
        },
        get items() {
            if (!errorsObj) return [];
            return Object.entries(errorsObj).map(([field, msg]) => ({ field, msg }));
        },
        collect() {
            return this.items;
        },
    };
}
