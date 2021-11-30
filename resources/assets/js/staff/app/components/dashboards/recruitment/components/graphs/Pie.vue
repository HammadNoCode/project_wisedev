<template>
  <div>
    <div class="bg-light p-3">
      <div class="row">
        <div class="col-md col-sm-12">
          <h3 class="block-title">
            <span class="font-w700">{{ $parent.pie_table.toUpperCase() }}</span>
            <span class="text-muted">|</span>
            <span class="font-w500">{{ $parent.pie_label.toUpperCase() }}</span>
          </h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col js-appear-enabled animated fadeIn" data-toggle="appear">
        <a class="block block-rounded height-600" href="javascript:void(0)">
          <div
            class="block-content block-content-full height-600 d-flex align-items-center justify-content-between"
          >
            <div class="mx-auto">
              <apexcharts
                v-if="loaded"
                type="pie"
                :options="options"
                :series="series"
              ></apexcharts>
              <div class="container" v-if="!loaded">
                <div class="row h-100">
                  <div class="col-sm-12 my-auto">
                    <div class="spinner-border m-5" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
export default {
  components: {
    apexcharts: VueApexCharts,
  },
  data: () => ({
    routePrefix: "/api/dashboard/overall/",
    loaded: false,
    series: [],
    options: {
      labels: [],
      title: {
        text: "",
        align: "center",
      },
      colors: [
        "#f89e1d",
        "#154191",
        "#6e46ae",
        "#e84188",
        "#3cbf0a",
        "#9192f3",
      ],
      responsive: [
        {
          breakpoint: 2600,
          options: {
            chart: {
              height: "500",
              width: "700",
            },
            dataLabels: {
              style: {
                fontSize: "10px",
                colors: ["#304758"],
              },
            },
          },
        },
        {
          breakpoint: 1000,
          options: {
            chart: {
              height: "400",
              width: "500",
            },
            dataLabels: {
              style: {
                fontSize: "10px",
                colors: ["#304758"],
              },
            },
          },
        },
        {
          breakpoint: 550,
          options: {
            chart: {
              height: "400",
              width: "325",
            },
            dataLabels: {
              style: {
                fontSize: "10px",
                colors: ["#304758"],
              },
            },
          },
        },
      ],
    },
  }),
  mounted() {
    this.get_application_source();
    // this.options.responsive = this.$parent.graphs.responsive;
  },
  methods: {
    get_application_source() {
      axios
        .get(
          this.routePrefix +
            this.$parent.pie_table +
            "/" +
            this.$parent.time_range +
            "/pie/" +
            this.$parent.pie_query
        )
        .then((response) => {
          this.series = response.data.series;
          this.options.labels = response.data.labels;
          this.loaded = true;
        });
    },
  },
};
</script>
<style lang="scss" scoped>
@media screen and (min-width: 1700px) {
  .height-600 {
    height: 655px !important;
  }
}
</style>