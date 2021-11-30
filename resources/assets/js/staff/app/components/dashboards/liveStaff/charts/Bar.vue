<template>
    <div class="mt-4">
        <div class="bg-light p-3">
            <div class="row">
                <div class="col-md col-sm-12">
                <h3 class="block-title">
                    <span class="font-w500">POSITION COUNT</span>
                    <span class="text-muted">|</span>
                    <span class="font-w700">BRANCHES</span>
                </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col js-appear-enabled animated fadeIn" data-toggle="appear">
                <a class="block block-rounded">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="mx-auto">
                            <VueApexCharts
                                type="bar"
                                :options="options"
                                :series="series"
                            ></VueApexCharts>
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
        VueApexCharts,
    },
    computed: {
        barQuery: function () {
            let query = this.routePrefix;
            query += "bar";
            return query;
        },
    },
    data: () => ({
        routePrefix: "/api/dashboard/live-staff/",
        loaded: false,
        series: [],
        options: {
            chart: {
                type: "bar",
                stacked: false,
                horizontal: false,
                animations: {
                speed: 2000,
                },
            },
            responsive: [{
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
                        width: "1000",
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
                        width: "750",
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
            }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "90%",
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
                    ontSize: "13px",
                },
            },
            stroke: {
                show: true,
                width: 5,
                colors: ["transparent"],
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
            colors: ["#228B22", "#e04f1a", "#154191"],
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
    },
    methods: {
        show() {
            axios.get(this.barQuery).then((response) => {
            if (response.data) {
                    this.series = response.data.series;
                    let temp = Object.assign({}, this.options);
                    temp.xaxis.categories = response.data.units;
                    this.options = temp;
                }
            })
            .catch((err) => {});
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