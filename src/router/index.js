/**
 * External dependencies.
 */
import { createRouter, createWebHistory } from "vue-router";

/**
 * Internal dependencies.
 */
import ListPage from "../pages/ListPage.vue";
import SettingPage from "../pages/SettingPage.vue";
import GraphPage from "../pages/GraphPage.vue";

const routes = [
    {
        path: "/",
        name: "SettingPage",
        component: SettingPage,
        alias: '/settings'
    },
    {
        path: "/list",
        name: "ListPage",
        component: ListPage,
    },
    {
        path: "/graph",
        name: "GraphPage",
        component: GraphPage
    }
];

const router = createRouter({
    history: createWebHistory(wpEmailer.site.base_url),
    routes
});

export default router;
