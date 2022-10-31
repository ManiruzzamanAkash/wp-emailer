<template>
  <div id="wp-emailer">
    <div class="main-content">
      <h2
        role="wp-emailer-notice"
        data-text="Don't remove me, I am super important for admin notice"
      />
      <h3>{{ __("WPEmailer", "wp-emailer") }}</h3>
      <p class="desc">
        {{
          __(
            "A WordPress plugin using Vue JS framework to work with email settings.",
            "wp-emailer"
          )
        }}
      </p>

      <!-- Page tabs -->
      <PageTabs />

      <div class="main-content-section">
        <BaseAlert />
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { menuFix } from "./utils/menu-fix";
import PageTabs from "./components/tabs/PageTabs.vue";
import BaseAlert from "./components/alert/BaseAlert.vue";

export default {
    name: "App",

    components: {
        PageTabs,
        BaseAlert,
    },

    watch: {
        $route() {
            // Fix the menu to show active link
            menuFix();

            // Hide existing alerts.
            this.hideAlert();
        },
    },

    created() {
        // We need to load the settings on initialization of the app.
        this.fetchSettings();
    },

    methods: {
        ...mapActions(["fetchSettings", "hideAlert"]),
    },
};
</script>