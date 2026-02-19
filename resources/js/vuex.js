/**
 * Vuex module shim for backward compatibility
 * 
 * This file exports Vuex-compatible helpers that work with the existing
 * Vuex store (./store/index.js) which still exists for backward compatibility.
 * 
 * New code should use Pinia directly. This is only for legacy components
 * during the gradual migration.
 */

export { mapGetters, mapState, mapActions, mapMutations } from './helpers/vuex-compat';

// Default export for compatibility
export default {
    mapGetters,
    mapState,
    mapActions,
    mapMutations
};
