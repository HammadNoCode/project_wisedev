<template>
  <div class="py-3">
    <div class="bg-light p-3">
      <h4 class="block-title mb-0">
        {{ position_filter | capitalize }} Hours Comparison
      </h4>
    </div>
    <div class="js-appear-enabled animated fadeIn" data-toggle="appear">
      <a
        class="block block-rounded height-600"
        href="javascript:void(0)"
        :class="{ 'block-mode-loading': !loaded }"
      >
        <div
          class="
            block-content block-content-full
            height-600
            d-flex
            align-items-center
            justify-content-between
          "
        >
          <div class="mx-auto">
            <apexcharts
              type="donut"
              :options="chartOptions"
              :series="series"
            ></apexcharts>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";

export default {
  components: {
    apexcharts: VueApexCharts,
  },
  computed: {
    branch: function () {
      return this.$parent.branch;
    },
    filters: function () {
      return this.$store.state.reports.filter;
    },
    position_filter: function () {
      return this.$store.state.reports.filter.position;
    },
    period_filter: function () {
      return this.$store.state.reports.filter.period;
    },
    date_from_filter: function () {
      return this.$store.state.reports.filter.date_from;
    },
    date_to_filter: function () {
      return this.$store.state.reports.filter.date_to;
    },
    chartOptions: function () {
      return this.$store.state.reports.chartOptions;
    },
    series: function () {
      return this.$store.state.reports.series;
    },
  },
  data: function () {
    return {
      loaded: false,
    };
  },
  watch: {
    position_filter: function (newVal) {
      this.$store.dispatch("reports/getPieChart", {
        branch: this.branch,
        filter: this.filters,
      });
    },
    period_filter: function (newVal) {
      this.$store.dispatch("reports/getPieChart", {
        branch: this.branch,
        filter: this.filters,
      });
    },
    date_from_filter: function (newVal) {
      this.$store.dispatch("reports/getPieChart", {
        branch: this.branch,
        filter: this.filters,
      });
    },
    date_to_filter: function (newVal) {
      this.$store.dispatch("reports/getPieChart", {
        branch: this.branch,
        filter: this.filters,
      });
    },
    branch: function (newVal) {
      this.$store.dispatch("reports/getPieChart", {
        branch: this.branch,
        filter: this.filters,
      });
    },
  },
  mounted() {
    this.getPieChart();
  },
  methods: {
    async getPieChart() {
      await this.$store.dispatch("reports/getPieChart", {
        branch: this.branch,
        filter: this.filters,
      });
      this.loaded = true;
    },
  },
};
</script>