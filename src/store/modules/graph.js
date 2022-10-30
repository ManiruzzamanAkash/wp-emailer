/**
 * External dependencies.
 */
import { getRequest } from '../../utils/ajax';
import { formatDate } from '../../utils/date-formatter';

// initial state
const state = () => ({
    graphLabels    : [],
    graphDatasets  : [],
    graphLoading   : false,
    graphRefreshing: false,
});

// getters
const getters = {
    graphLabels    : state => state.graphLabels,
    graphDatasets  : state => state.graphDatasets,
    graphLoading   : state => state.graphLoading,
    graphRefreshing: state => state.graphRefreshing,
};

// actions
const actions = {
    async getGraphData({ dispatch, commit }, isRefresh = false) {
        commit('setGraphLoading', true);

        let params = `action=${'wp_emailer_get_data'}`;
        if (isRefresh) {
            params += '&refresh=1';
            commit('setGraphRefreshing', true);
        }

        await getRequest(params)
            .then(response => {
                if (response.success) {
                    const graphResponse = response?.data?.data?.graph;

                    if (graphResponse !== undefined) {
                        const graphLabels = [];
                        const graphData   = [];

                        Object.keys(graphResponse).forEach(key => {
                            const item = graphResponse[key];
                            graphLabels.push(formatDate(item.date, true));
                            graphData.push(item.value);
                        });

                        const graphDatasets = [
                            {
                                label: 'Data',
                                backgroundColor: '#ff982d',
                                data: graphData
                            }
                        ];

                        commit('setGraphLabels', graphLabels);
                        commit('setGraphDatasets', graphDatasets);

                        if (isRefresh) {
                            dispatch('setAlert', {
                                message  : 'Graph refreshed successfully.',
                                type     : 'success'
                            }, {root:true});
                        }
                    }
                }
            });

        commit('setGraphLoading', false);
        commit('setGraphRefreshing', false);
    },
};

// mutations
const mutations = {
    setGraphLabels: (state, graphLabels) => {
        state.graphLabels = graphLabels;
    },

    setGraphDatasets:(state, graphDatasets) => {
        state.graphDatasets = graphDatasets;
    },

    setGraphLoading: (state, graphLoading) => {
        state.graphLoading = graphLoading;
    },

    setGraphRefreshing: (state, graphRefreshing) => {
        state.graphRefreshing = graphRefreshing;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};