/**
 * VeeValidate 4 setup: register all available rules globally.
 * Import this once in app.js before mounting.
 */
import { defineRule } from 'vee-validate';
import {
    required,
    email,
    min,
    max,
    url,
    confirmed,
    numeric,
    integer,
    between,
    digits,
    alpha,
    alpha_num,
    alpha_dash,
    alpha_spaces,
    min_value,
    max_value,
    regex,
    length,
    one_of,
    not_one_of,
    is,
    is_not,
} from '@vee-validate/rules';

defineRule('required', required);
defineRule('email', email);
defineRule('min', min);
defineRule('max', max);
defineRule('url', url);
defineRule('confirmed', confirmed);
defineRule('numeric', numeric);
defineRule('integer', integer);
defineRule('between', between);
defineRule('digits', digits);
defineRule('alpha', alpha);
defineRule('alpha_num', alpha_num);
defineRule('alpha_dash', alpha_dash);
defineRule('alpha_spaces', alpha_spaces);
defineRule('min_value', min_value);
defineRule('max_value', max_value);
defineRule('regex', regex);
defineRule('length', length);
defineRule('one_of', one_of);
defineRule('not_one_of', not_one_of);
defineRule('is', is);
defineRule('is_not', is_not);
