<script setup>
import { __ } from '@wordpress/i18n';
</script>

<template>
  <div id="wp-emailer-tabs">
    <div class="tab-item">
      <router-link to="/">
        {{ __("Settings", "wp-emailer") }}
      </router-link>
    </div>
    <div class="tab-item">
      <router-link to="/list">
        {{ __("Top Pages", "wp-emailer") }}
      </router-link>
    </div>
    <div class="tab-item">
      <router-link to="/graph">
        {{ __("Graph", "wp-emailer") }}
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
    name: "PageTabs",
};
</script>

<style lang="scss" scoped>
#wp-emailer-tabs {
  display: flex;
  flex-direction: row;
  background-color: var(--color-white);
  font-size: 14px;
  margin: 0 0 20px -20px;
  padding: 0 20px;
  position: sticky;
  top: 0px;
  z-index: 99;

  .tab-item {
    a {
      transition: all;
      box-shadow: none;
      color: #666666;
      display: inline-block;
      margin-right: 30px;
      padding: 20px 10px 18px 10px;
      border-bottom: 2px solid transparent;
      text-decoration: none;

      &:focus,
      &.router-link-active,
      &:hover {
        outline: none;
      }

      &:hover {
        border-bottom: 2px solid var(--color-secondary);
      }

      &.router-link-active {
        border-bottom: 2px solid var(--color-primary);
      }
    }
  }

  // Medium screen
  @media only screen and (min-width: 600px) {
    top: 32px;
  }
}
</style>