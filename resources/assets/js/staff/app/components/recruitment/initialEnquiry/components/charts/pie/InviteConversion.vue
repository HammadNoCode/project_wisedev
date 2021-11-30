<template>
  <div>
    <div class="bg-light p-3">
      <h4 class="block-title mb-0">Invite Conversion Tracker</h4>
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
          style="height: 303px"
        >
          <div class="mx-auto">
            <apexcharts
              type="donut"
              :options="chartOptions"
              :series="invite_conversion_series"
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
    invite_conversion_series: function () {
      return this.$store.state.invites.invite_conversion_series;
    },
  },
  data() {
    return {
      loaded: false,
      chartOptions: {
        labels: ["Converted", "Unmodified"],
        title: {
          text: "",
          align: "center",
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name: {
                  show: true,
                  fontSize: "25px",
                  fontFamily: "Helvetica, Arial, sans-serif",
                  color: "#000000",
                  offsetY: -15,
                },
                value: {
                  show: true,
                  fontSize: "30px",
                  fontFamily: "Helvetica, Arial, sans-serif",
                  color: undefined,
                  offsetY: 8,
                  formatter: function (val) {
                    return val;
                  },
                },
                total: {
                  show: true,
                  label: "Total",
                  color: "#373d3f",
                  formatter: function (w) {
                    return w.globals.seriesTotals.reduce((a, b) => {
                      return a + b;
                    }, 0);
                  },
                },
              },
            },
          },
        },
        fill: {
          type: "gradient",
          gradient: {
            shade: "dark",
            type: "horizontal",
            shadeIntensity: 0.1,
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100],
          },
        },
        colors: ["#72DF57", "#F6553A"],
        responsive: [
          {
            breakpoint: 3600,
            options: {
              chart: {
                height: "300",
                width: "420",
              },
              dataLabels: {
                style: {
                  fontSize: "13px",
                  colors: ["#ffffff"],
                },
              },
            },
          },
          {
            breakpoint: 1000,
            options: {
              chart: {
                height: "300",
                width: "300",
              },
              dataLabels: {
                style: {
                  fontSize: "10px",
                  colors: ["#ffffff"],
                },
              },
            },
          },
          {
            breakpoint: 550,
            options: {
              chart: {
                height: "300",
                width: "300",
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
    };
  },
  mounted() {
    this.getInviteConversionStats();
  },
  methods: {
    async getInviteConversionStats() {
      await this.$store.dispatch("invites/getInviteConversionStats");
      this.loaded = true;
      // axios
      //   .get("/api/recruitment/enquiry-form/pie-chart/conversion")
      //   .then((response) => {
      //     this.series = response.data.series;
      //     this.chartOptions.labels = response.data.labels;
      //     this.loaded = true;
      //   });
    },
  },
};
</script>