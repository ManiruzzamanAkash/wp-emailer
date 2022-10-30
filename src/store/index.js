/**
 * External dependencies.
 */
import { createStore, createLogger } from "vuex";

/**
 * Internal dependencies.
 */
import global from "./modules/global";
import settings from "./modules/settings";
import tables from "./modules/tables";
import graph from "./modules/graph";

const debug = process.env.NODE_ENV !== "production";

const store = createStore({
    modules: {
        global,
        settings,
        tables,
        graph,
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
});

export default store;
