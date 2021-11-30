<template>
  <div>
    <div class="bg-light p-3">
      <div class="row">
        <div class="col-md col-sm-12">
          <h3 class="block-title">
            <span class="font-w700">{{ $parent.time_range.toUpperCase() }}</span>
            <span class="font-w700">{{ $parent.stacked_label.toUpperCase() }}</span>
            <span class="text-muted">|</span>
            <span class="font-w500">PROGRESS</span>
            <span class="text-muted">|</span>
            <span class="font-w500">{{ $parent.stacked_table.toUpperCase() }}</span>
          </h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col js-appear-enabled animated fadeIn" data-toggle="appear">
        <a class="block block-rounded">
          <div
            class="block-content block-content-full d-flex align-items-center justify-content-between"
          >
            <div class="mx-auto">
              <apexcharts
                width="100%"
                height="350"
                type="bar"
                :options="options"
                :series="series"
              ></apexcharts>
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
  computed: {
    stackedQuery: function () {
      let query = this.routePrefix;
      query += this.$parent.stacked_table + "/";
      query += this.$parent.time_range + "/";
      query += "stacked/" + "tracker";
      return query;
    },
    stacked_query: {
      get: function () {
        return this.$parent.stacked_query;
      },
      set: function (newValue) {
        this.$parent.stacked_query = newValue;
      },
    },
  },
  data: () => ({
    routePrefix: "/api/dashboard/overall/",
    loaded: false,
    series: [],
    options: {
      chart: {
        type: "bar",
        stacked: true,
        horizontal: true,
        animations: {
          speed: 2000,
        },
      },
      responsive: [],
      plotOptions: {
        bar: {
          horizontal: true,
          dataLabels: {
            position: "center", // top, center, bottom
          },
        },
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        style: {
          fontSize: "13px",
        },
      },
      xaxis: {
        categories: [],
        position: "bottom",
        labels: {},
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
        crosshairs: {
          fill: {
            type: "gradient",
            gradient: {
              colorFrom: "#D8E3F0",
              colorTo: "#BED1E6",
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5,
            },
          },
        },
        tooltip: {
          enabled: true,
          offsetY: -35,
        },
      },
      colors: ["#154191", "#e1b65a", "#82b54b", "#e04f1a", "#6A0DAD"],
      fill: {
        gradient: {
          shade: "light",
          type: "horizontal",
          shadeIntensity: 0.25,
          gradientToColors: undefined,
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [50, 0, 100, 100],
        },
      },
      yaxis: {
        axisBorder: {
          show: true,
        },
        axisTicks: {
          show: true,
        },
        labels: {
          show: true,
          offsetY: 3,
          formatter: function (val) {
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
      },
    },
  }),
  mounted() {
    this.show();
    let resp = Object.assign({}, this.options);
    resp.responsive = this.$parent.graphs.responsive;
    this.options = resp;
  },
  methods: {
    show() {
      axios.get(this.stackedQuery).then((response) => {
        if (response.data) {
          this.series = response.data.series;

          let temp = Object.assign({}, this.options);
          temp.xaxis.categories = response.data.units;
          this.options = temp;
        }
      })
      .catch((err) => {
        console.log(err);
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.apexcharts-text tspan {
  font-family: inherit !important;
  font-size: 12px !important;
  font-weight: 400 !important;
}
</style>