<template>
  <div>
    <div class="bg-light p-3">
      <div class="row">
        <div class="col-md col-sm-12">
          <h3 class="block-title">
            <span class="font-w700">{{ bar_query.toUpperCase() }}</span>
            <span class="text-muted">|</span>
            <span class="font-w500">COUNTER</span>
          </h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col js-appear-enabled animated fadeIn" data-toggle="appear">
        <a class="block block-rounded">
          <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div class="mx-auto">
              <apexcharts
                v-if="loaded"
                type="bar"
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
  computed: {
    barQuery: function () {
      let query = this.routePrefix;
      query += this.$parent.bar_table + "/";
      query += this.$parent.time_range + "/";
      query += this.$parent.filter;
      query += "/bar/" + this.$parent.bar_query;
      return query;
    },
    bar_query: {
      get: function () {
        return this.$parent.bar_query;
      },
      set: function (newValue) {
        this.$parent.bar_query = newValue;
      },
    },
  },
  data: () => ({
    routePrefix: "/api/dashboard/overall/",
    loaded: false,
    staff: {},
    series: [
      {
        name: "Count",
        data: [],
      },
    ],
    options: {
      chart: {
        type: "bar",
        stacked: false,
        horizontal: false,
        animations: {
          speed: 2000,
        },
      },
      title: {
        text: "",
        align: "center",
      },
      colors: ["#164192", "#164192"],
      responsive: [
        {
          breakpoint: 2600,
          options: {
            chart: {
              height: "700",
              width: "1200",
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
          breakpoint: 2000,
          options: {
            chart: {
              height: "700",
              width: "800",
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
          breakpoint: 1499,
          options: {
            chart: {
              height: "700",
              width: "850",
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
          breakpoint: 1240,
          options: {
            chart: {
              height: "500",
              width: "650",
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
          breakpoint: 990,
          options: {
            chart: {
              height: "500",
              width: "650",
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
          breakpoint: 700,
          options: {
            chart: {
              height: "500",
              width: "450",
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
          breakpoint: 500,
          options: {
            chart: {
              height: "400",
              width: "275",
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
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top", // top, center, bottom
          },
        },
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        offsetY: -20,
        style: {
          fontSize: "12px",
          colors: ["#304758", "#304758"],
        },
      },
      xaxis: {
        categories: [],
        position: "bottom",
        labels: {
          offsetY: -5,
        },
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
          show: false,
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: false,
          formatter: function (val) {
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
      },
    },
  }),
  mounted() {
    this.show();
    this.getStaff();
  },
  methods: {
    getStaff() {
      axios.get("/api/recruitment/interviews" + "/active").then((response) => {
        this.staff = response.data;
      });
    },
    show() {
      axios.get(this.barQuery)
      .then((response) => {
        // set data to display
        if (response.data.series[0]) {
          this.series[0].data = response.data.series[0];
          this.series[0].name = (
            this.$parent.time_range +
            " " +
            this.bar_query +
            " Count"
          ).toUpperCase();
        }
        // set chart options
        this.options.xaxis.categories = response.data.units;
        this.options.title.text = (
          this.$parent.time_range.replace(/[_-]/g, " ") +
          " " +
          this.bar_query +
          " Count"
        ).toUpperCase();
        // store the query & data
        this.$store.commit("mutate", {
          with: {
            query: this.barQuery,
            series: this.series,
            options: this.options,
          },
        });
        // load the chart
        this.loaded = true;
      });
    },
  },
};
</script>
