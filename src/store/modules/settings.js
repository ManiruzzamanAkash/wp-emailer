/**
 * External dependencies.
 */
import { getRequest, postRequest } from '../../utils/ajax';

// initial state
const state = () => ({
    settings         : {},
    isSettingsLoading: false,
    isSettingsSaving : false,
});

// getters
const getters = {
    settings         : state => state.settings,
    isSettingsLoading: state => state.isSettingsLoading,
    isSettingsSaving : state => state.isSettingsSaving,
};

// actions
const actions = {
    async fetchSettings({ commit }) {
        commit('setSettingsLoading', true);

        await getRequest(`action=${'wp_emailer_get_settings'}`)
            .then(response => {
                if ( response.success ) {
                    commit('storeAllSettings', response.data.data);
                    commit('setSettingsLoading', false);
                }
            });

        commit('setSettingsLoading', false);
    },

    async storeSettings({ dispatch, commit }, input) {
        commit('setSettingsSaving', true);

        const postData = {
            key   : input.key,
            value : input.value,
            action: 'wp_emailer_update_setting'
        };

        await postRequest(postData)
            .then(response => {
                if ( response?.success ) {
                    commit('storeSettingItem', input);

                    dispatch('setAlert', {
                        message  : response?.data?.message,
                        type     : 'success'
                    }, {root:true});
                }
            }).catch(error => {
                const errorResponse = JSON.parse(error.responseText);
                if (errorResponse?.data?.message) {
                    dispatch('setAlert', {
                        message  : errorResponse?.data?.message,
                        type     : 'error'
                    }, {root:true});
                }
            });

        commit('setSettingsSaving', false);
    },
};

// mutations
const mutations = {
    storeAllSettings: (state, settings) => {
        state.settings = settings;
    },

    storeSettingItem: (state, input) => {
        state.settings = {
            ...state.settings,
            [input.key] : input?.value
        };
    },

    setSettingsLoading: (state, isSettingsLoading) => {
        state.isSettingsLoading = isSettingsLoading;
    },

    setSettingsSaving: (state, isSettingsSaving) => {
        state.isSettingsSaving = isSettingsSaving;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
