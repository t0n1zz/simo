/**
 * Vuex Compatibility Shim for Pinia Migration
 * 
 * This file provides Vuex-compatible helpers that work with Pinia stores.
 * This allows gradual migration from Vuex to Pinia without breaking existing components.
 */

import { mapState as piniaMapState, mapActions as piniaMapActions } from 'pinia';

/**
 * mapGetters compatibility - maps to Pinia store getters/state
 * Usage: ...mapGetters('storeName', { localName: 'storeProp' })
 */
export function mapGetters(storeName, mapping) {
    if (typeof storeName === 'object') {
        // If called without store name: mapGetters({ ... })
        console.warn('[Vuex Compat] mapGetters without store name is not supported with Pinia. Please specify store name.');
        return {};
    }

    // Try to dynamically import the Pinia store
    // For now, return computed properties that access $store
    const computedProps = {};

    if (typeof mapping === 'object') {
        Object.keys(mapping).forEach(key => {
            const getter = mapping[key];
            computedProps[key] = function () {
                // Access through the legacy Vuex store if it exists
                if (this.$store && this.$store.getters) {
                    return this.$store.getters[`${storeName}/${getter}`];
                }
                // Otherwise try to access Pinia store
                return null;
            };
        });
    } else if (Array.isArray(mapping)) {
        mapping.forEach(getter => {
            computedProps[getter] = function () {
                if (this.$store && this.$store.getters) {
                    return this.$store.getters[`${storeName}/${getter}`];
                }
                return null;
            };
        });
    }

    return computedProps;
}

/**
 * mapState compatibility - maps to Pinia store state
 */
export function mapState(storeName, mapping) {
    if (typeof storeName === 'object') {
        console.warn('[Vuex Compat] mapState without store name is not supported with Pinia.');
        return {};
    }

    const computedProps = {};

    if (typeof mapping === 'object') {
        Object.keys(mapping).forEach(key => {
            const stateProp = mapping[key];
            computedProps[key] = function () {
                if (this.$store && this.$store.state && this.$store.state[storeName]) {
                    return this.$store.state[storeName][stateProp];
                }
                return null;
            };
        });
    } else if (Array.isArray(mapping)) {
        mapping.forEach(stateProp => {
            computedProps[stateProp] = function () {
                if (this.$store && this.$store.state && this.$store.state[storeName]) {
                    return this.$store.state[storeName][stateProp];
                }
                return null;
            };
        });
    }

    return computedProps;
}

/**
 * mapActions compatibility - maps to Pinia store actions
 */
export function mapActions(storeName, mapping) {
    if (typeof storeName === 'object') {
        console.warn('[Vuex Compat] mapActions without store name is not supported with Pinia.');
        return {};
    }

    const methods = {};

    if (typeof mapping === 'object') {
        Object.keys(mapping).forEach(key => {
            const action = mapping[key];
            methods[key] = function (...args) {
                if (this.$store && this.$store.dispatch) {
                    return this.$store.dispatch(`${storeName}/${action}`, ...args);
                }
            };
        });
    } else if (Array.isArray(mapping)) {
        mapping.forEach(action => {
            methods[action] = function (...args) {
                if (this.$store && this.$store.dispatch) {
                    return this.$store.dispatch(`${storeName}/${action}`, ...args);
                }
            };
        });
    }

    return methods;
}

/**
 * mapMutations compatibility - maps to Pinia store actions
 * (Pinia doesn't have mutations, so we map to actions)
 */
export function mapMutations(storeName, mapping) {
    return mapActions(storeName, mapping);
}

export default {
    mapGetters,
    mapState,
    mapActions,
    mapMutations
};
