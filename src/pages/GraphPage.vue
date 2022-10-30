<script setup>
import { __ } from '@wordpress/i18n';
import { mapActions, mapGetters } from "vuex";
</script>

<template>
  <div class="graph-page">
    <div class="flex justify-between">
      <h3>{{ __('Graph', 'wp-emailer') }}</h3>
      <div>
        <div
          v-if="!graphRefreshing"
          class="refresh-icon"
          title="Click to refresh"
          @click="refreshChart"
        >
          <!-- eslint-disable-next-line vue/max-attributes-per-line -->
          <svg xmlns="http://www.w3.org/2000/svg" data-name="Isolation Mode" viewBox="0 0 24 24" width="14" height="14"><path d="M12 2.99a9.03 9.03 0 0 1 6.36 2.65l-2.37 2.37h5.83a1.15 1.15 0 0 0 1.14-1.14V1.04l-2.49 2.49A11.98 11.98 0 0 0 0 12h2.99A9.02 9.02 0 0 1 12 2.99ZM21.01 12a9 9 0 0 1-15.37 6.36l2.37-2.37H2a.96.96 0 0 0-.95.95v6.02l2.49-2.49A11.98 11.98 0 0 0 24 12Z" /></svg>
        </div>
        <div
          v-if="graphRefreshing"
          class="text-center"
        >
          <BaseSpinner />
          {{ __("Refreshing...", "wp-emailer") }}
        </div>
      </div>
    </div>

    <BarChartLoading v-if="graphLoading" />

    <BarChart
      v-if="!graphLoading"
      :labels="graphLabels"
      :datasets="graphDatasets"
    />
  </div>
</template>

<script>
import BarChart from '../components/chart/BarChart.vue';
import BarChartLoading from '../components/chart/BarChartLoading.vue';
import BaseSpinner from '../components/spinner/BaseSpinner.vue';

export default {
    name: "GraphPage",

    components: {
        BarChart,
        BaseSpinner,
        BarChartLoading,
    },

    computed: { ...mapGetters(["graphLoading", "graphRefreshing", "graphLabels", "graphDatasets"]) },

    created() {
        this.getGraphData();
    },

    methods: {
        ...mapActions(["getGraphData"]),

        refreshChart() {
            // Hard refresh by passing true.
            this.getGraphData(true);
        }
    }
};
</script>

<style lang="scss" scoped>
.refresh-icon {
  padding: 10px;
  background: #fff;
  display: inline-block;
  border: 1px solid #E9EDF0;
  box-shadow: 0 3px 15px 0 rgba(0,0,0,.02);
  cursor: pointer;

  &:hover {
      svg {
          fill: var(--color-primary);
      }
  }

  &.active {
      svg {
          fill: var(--color-primary);
          animation: rotation 1s infinite linear;
      }
  }

  svg {
      fill: #bdc0c9;
  }
}
</style>