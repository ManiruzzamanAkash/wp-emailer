/**
 * External dependencies.
 */
import { createRouter, createWebHistory } from "vue-router";

/**
 * Internal dependencies.
 */
import List from "../pages/List.vue";
import Settings from "../pages/Settings.vue";
import Graph from "../pages/Graph.vue";

const routes = [
  {
    path: "/",
    name: "List",
    component: List,
    alias: '/list'
  },
  {
    path: "/settings",
    name: "Settings",
    component: Settings
  },
  {
    path: "/graph",
    name: "Graph",
    component: Graph
  }
];

console.log('base_url', wpEmailer.site.base_url);

const router = createRouter({
    // history: createWebHistory('/wpvue/wp-admin/admin.php?page=wp-emailer#'),
    history: createWebHistory(wpEmailer.site.base_url),
    routes
});

export default router;
