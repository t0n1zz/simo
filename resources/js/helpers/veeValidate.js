/**
 * VeeValidate 4 setup: define global rules so forms can use validation schemas
 * (e.g. 'required|min:5', 'email', 'url'). Add more rules from @vee-validate/rules as needed.
 * Import this once in app.js before mounting.
 */
import { defineRule } from 'vee-validate';
import { required, email, min, max, url } from '@vee-validate/rules';

defineRule('required', required);
defineRule('email', email);
defineRule('min', min);
defineRule('max', max);
defineRule('url', url);
