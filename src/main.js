/**
 * External dependencies.
 */
import { createApp } from "vue";
import { createHooks } from "@wordpress/hooks";

/**
 * Internal dependencies.
 */
import App from "./App.vue";
import router from "./router";
import './i18n';
import "./styles/main.scss";
import i18nMixin from "./mixins/i18n";
import './utils/menu-fix';

// Create vue app instance.
const app = createApp({
    extends: App,
    mixins: [i18nMixin]
});
app.use(router);
app.config.devtools = process.env.NODE_ENV === "development";

// Finally Mount on the #wp-emailer div.
app.mount("#wp-emailer");

// Add action/filter hooks injectable
window.wpEmailerHooks = createHooks();
wpEmailerHooks.addFilter = (hookName, namespace, component, priority = 10) => {
  wpEmailerHooks.hooks.addFilter(
    hookName,
    namespace,
    components => {
      components.push(component);
      return components;
    },
    priority
  );
};
