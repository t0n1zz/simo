/**
 * $filters global compatibility wrapper.
 *
 * Re-exports all functions from filterHelpers.js as an object so that
 * app.js can register them as app.config.globalProperties.$filters.
 *
 * filterHelpers.js is the single source of truth — edit functions there.
 */
import filterHelpers from './filterHelpers.js';

export const filters = filterHelpers;
export default filters;
