import axios from 'axios'

const api = axios.create({
  baseURL: '/api/branch/reporting/',
  timeout: 20000
})

export const reports = {
  namespaced: true,
  state: {
    formData: {
      position: "",
      hours_achieved: "",
      hours_lost: "",
      week_commencing: "",
      week_ending: "",
    },
    positions: [
      "Healthcare Assistant",
      "Senior Healthcare Assistant",
      "RMN",
      "RGN",
      "Support Worker",
    ],
    filter: {
      position: 'all',
      period: 'monthly',
      date_from: '',
      date_to: ''
    },
    showForm: false,
    pipeline_hours: {},
    series: [],
    chartOptions: {
      legend: {
        fontSize: "16px",
        fontFamily: "Helvetica, Arial, sans-serif",
      },
      labels: ["Hours Achieved", "Hours Lost"],
      title: {
        text: "",
        align: "center",
      },
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800,
        animateGradually: {
          enabled: true,
          delay: 150
        },
        dynamicAnimation: {
          enabled: true,
          speed: 350
        }
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
                label: "Hours",
                color: "#373d3f",
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce((a,b) => {
                    return a - b
                  })
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
      colors: ["#72DF57","#F6553A"],
      responsive: [
        {
          breakpoint: 2600,
          options: {
            chart: {
              height: "700",
              width: "700",
            },
            dataLabels: {
              style: {
                fontSize: "15px",
                colors: ["#ffffff"],
              },
            },
          },
        },
        {
          breakpoint: 1000,
          options: {
            chart: {
              height: "700",
              width: "600",
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
  },
  mutations: {
    setPieChartStats (state, result) {
      state.series = result;
    },
    setAvaliablePipelineHours (state, result) {
      state.pipeline_hours = result;
    }
  },
  actions: {
    async storeReport(context, state) {
      try {
        const res = await api.post('report', state)
        this.showForm = false 
      } catch (error) {
        throw Error(error);
      }
    },
    async getPieChart(context, state) {
      try {
        const res = await api.get(
          'pie_chart?branch=' + state.branch +
          '&position=' + state.filter.position +
          '&period=' + state.filter.period +
          '&date_from=' + state.filter.date_from +
          '&date_to=' + state.filter.date_to
          )
          context.commit('setPieChartStats', res.data)
      } catch (error) {
        throw Error(error);
      }
    },
    async getAvaliablePipelineHours(context, state) {
      try {
        const res = await api.get(
          'pipeline_hours?branch=' + state.branch +
          '&position=' + state.position
        )
        context.commit('setAvaliablePipelineHours', res.data)
      } catch (error) {
        throw Error(error);
      }
    }
  }
}
