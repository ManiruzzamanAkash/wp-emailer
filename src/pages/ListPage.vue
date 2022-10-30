<script setup>
import { __ } from '@wordpress/i18n';
import { mapActions, mapGetters } from "vuex";
</script>

<template>
  <div class="list-page">
    <h3>{{ pageTitle }}</h3>
    <BaseTable
      :loading="tableLoading"
      :headers="headers"
      :rows="rows"
      :html-columns="htmlColumns"
    />
    <div>
      <BasePagination
        v-if="!tableLoading"
        :total-pages="rows.totalPage"
        :total-items="rows.totalItems"
        :per-page="rows.perPage"
        :current-page="currentPage"
        @pagechanged="onPageChange"
      />
      <PaginationLoader v-if="tableLoading" />
    </div>

    <div>
      <h3>{{ __("Emails", "wp-emailer") }}</h3>
      <ul>
        <li
          v-for="(email, index) in settings?.emails"
          :key="index"
        >
          {{ email }}
        </li>

        <li v-if="!settings?.emails?.length">
          <span class="no-emails">
            {{ __("Sorry, No emails added yet. Please add email from Settings page.", "wp-emailer") }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import BaseTable from "../components/tables/BaseTable.vue";
import BasePagination from "../components/pagination/BasePagination.vue";
import PaginationLoader from '../components/pagination/PaginationLoader.vue';

export default {
    name: "ListPage",

    components: {
        BaseTable,
        BasePagination,
        PaginationLoader
    },

    data() {
        return {
            currentPage: 1,
            htmlColumns: ['url']
        };
    },

    computed: { ...mapGetters(["tableLoading", "pageTitle", "headers", "rows", "settings"]) },

    watch: {
        settings() {
            this.getTableData(this.currentPage);
        },
    },

    created() {
        this.getTableData();
    },

    methods: {
        ...mapActions(["getTableData"]),

        onPageChange(page) {
            this.currentPage = page;
            this.getTableData(page);
        },
    },
};
</script>

<style lang="scss" scoped>
.no-emails {
  background: var(--color-white);
  border: 1px solid #ccc;
  padding: 10px 20px;
  color: var(--color-danger);
}
</style>