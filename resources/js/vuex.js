/**
 * Vuex module shim for backward compatibility
 *
 * This file exports Vuex-compatible helpers that are implemented on top of
 * Pinia via ./helpers/vuex-compat. Vuex itself is no longer installed.
 *
 * New code should use Pinia directly. This is only for legacy components
 * during the gradual migration.
 */

import { mapGetters, mapState, mapActions, mapMutations } from './helpers/vuex-compat';

export { mapGetters, mapState, mapActions, mapMutations };

// Default export for compatibility
export default {
    mapGetters,
    mapState,
    mapActions,
    mapMutations
};
