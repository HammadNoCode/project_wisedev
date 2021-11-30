import axios from 'axios'

const api = axios.create({
  baseURL: '/api/recruitment/conversion_tracker/',
  timeout: 20000
})

export const conversion = {
  namespaced: true,
  state: {
    series: [],
    chartOptions: {
      legend: {
        fontSize: "16px",
        fontFamily: "Helvetica, Arial, sans-serif",
      },
      labels: ["Live", "Accepted", "Pending"],
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
      colors: ["#154191","#82b54b", "#f0ad4e"],
      responsive: [
        {
          breakpoint: 2600,
          options: {
            chart: {
              height: "600",
              width: "600",
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
    conversions: {
      live: "",
      accepted: "",
      pending: "",
    }
  },
  mutations: {
    setPieChartStats (state, result) {
      state.series = result;
    },
    setLiveConversionTime (state, result) {
      state.conversions.live = result;
    },
    setAcceptedConversionTime (state, result) {
      state.conversions.accepted = result;
    }
  },
  actions: {
    async getPieChart(context, state) {
      try {
        const res = await api.get('pie_chart')
          context.commit('setPieChartStats', res.data)
      } catch (error) {
        throw Error(error);
      }
    },
    async getLiveStatusConversionTime(context, state) {
      try {
        const res = await api.get('status/live')
        context.commit("setLiveConversionTime", res.data)
      } catch (error) {
        throw Error(error);
      }
    },
    async getAcceptedStatusConversionTime(context, state) {
      try {
        const res = await api.get('status/accepted')
        context.commit("setAcceptedConversionTime", res.data)
      } catch (error) {
        throw Error(error);
      }
    },
  }
}
