<template>
    <div id="wp-emailer">
        <div class="main-content">
            <h2 role="wp-emailer-notice" data-text="Don't remove me, I am super important for admin notice"></h2>
            <h3>{{ __('WPEmailer', 'wp-emailer') }}</h3>
            <tabs />
            <router-view />
        </div>
    </div>
</template>

<script>
import Tabs from './components/tabs/Tabs.vue';
import { menuFix } from './utils/menu-fix';

export default {
    name: 'App',
    components: {
        Tabs
    },
    watch: {
        $route() {
            menuFix();
        }
    }
};
</script>