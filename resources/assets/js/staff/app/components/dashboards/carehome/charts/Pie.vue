<template>
  <div>
    <div class="bg-light p-3">
      <div class="row">
        <div class="col-12">
          <h4 class="block-title mb-0">Carehome Onboarding Tracker</h4>
        </div>
      </div>
    </div>
    <div class="js-appear-enabled animated fadeIn" data-toggle="appear">
      <a class="block block-rounded height-600" href="javascript:void(0)">
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
  data() {
    return {
      routePrefix: "/api/carehome/dashboard/",
      series: [],
      chartOptions: {
        labels: [
          "Not Contacted",
          "In Orboarding Stages",
          "Has Cavalry as an Agency",
        ],
        title: {
          text: "",
          align: "center",
        },
        colors: ["#f89e1d", "#154191", "#6e46ae"],
        responsive: [
          {
            breakpoint: 3600,
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
    };
  },
  components: {
    apexcharts: VueApexCharts,
  },
  computed: {
    branch: function () {
      return this.$parent.branch;
    },
  },
  mounted() {
    this.showPie();
  },
  methods: {
    showPie() {
      axios
        .get(this.routePrefix + "pie?branch=" + this.branch)
        .then((response) => {
          this.series = response.data.series;
          this.chartOptions.labels = response.data.labels;
        });
    },
  },
};
</script>