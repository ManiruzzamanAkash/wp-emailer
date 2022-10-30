/**
 * Internal dependencies.
 */
import { getRequest } from '../../utils/ajax';
import { formatDate } from '../../utils/date-formatter';
import { getPaginatedData } from '../../utils/pagination-response';

// initial state
const state = () => ({
    pageTitle   : '',
    headers     : [],
    rows        : {
        data       : [],
        totalPage  : 0,
        totalItems : 0,
        currentPage: 1,
        perPage    : 5,
    },
    tableLoading: false,
});

// getters
const getters = {
    pageTitle   : state => state.pageTitle,
    headers     : state => state.headers,
    rows        : state => state.rows,
    tableLoading: state => state.tableLoading,
};

// actions
const actions = {
    async getTableData({ commit, rootState }, currentPage = 1) {
        commit('setLoading', true);

        const perPage   = rootState.settings?.settings?.numrows ?? 5;
        const humandate = parseInt( rootState.settings?.settings?.humandate ?? 1 );

        await getRequest(`action=${'wp_emailer_get_data'}`)
            .then(response => {
                if (response.success) {
                    commit('setPageTitle', response?.data?.data?.table?.title);
                    commit('setHeaders', response?.data?.data?.table?.data?.headers);

                    const rows = response?.data?.data?.table?.data?.rows;

                    // Show human readable date if humandate is true.
                    const formattedRows = rows.map((row) => {
                        return {
                            ...row,
                            date: humandate ? formatDate(row.date, true) : row.date,
                            url: `<a class="page-link" href="${row.url}" target="blank">${row.url}</a>`,
                        };
                    });

                    commit('setRows', getPaginatedData(formattedRows, currentPage, perPage));
                }
            });

        commit('setLoading', false);
    },
};

// mutations
const mutations = {
    setPageTitle: (state, pageTitle) => {
        state.pageTitle = pageTitle;
    },

    setHeaders: (state, headers) => {
        state.headers = headers;
    },

    setRows: (state, rows) => {
        state.rows = rows;
    },

    setLoading: (state, loading) => {
        state.tableLoading = loading;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};