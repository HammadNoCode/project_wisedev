<template>
  <div>
    <div class="bg-light p-3">
      <div class="row">
        <div class="col-md col-sm-12">
          <h3 class="block-title">Application Status | Tracker</h3>
        </div>
      </div>
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
              type="pie"
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
    series: function () {
      return this.$store.state.conversion.series;
    },
    chartOptions: function () {
      return this.$store.state.conversion.chartOptions;
    },
  },
  data: function () {
    return {
      loaded: false,
    };
  },
  mounted() {
    this.getStats();
  },
  methods: {
    async getStats() {
      await this.$store.dispatch("conversion/getPieChart").then((res) => {
        this.loaded = true;
      });
    },
  },
};
</script>