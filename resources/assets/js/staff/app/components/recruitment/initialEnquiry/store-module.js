import axios from 'axios'

const api = axios.create({
  baseURL: '/api/recruitment/enquiry-form/',
  timeout: 20000
})

export const invites = {
  namespaced: true,
  state: {
    formData: {
      referal: "",
      position: "",
      first_name: "",
      last_name: "",
      email: "",
      telephone: "",
      address_line_1: "",
      address_line_2: "",
      city: "",
      postcode: "",
      hours_pw: "",
      driving_licence: "",
    },
    positions: [
      "Healthcare Assistant",
      "Senior Healthcare Assistant",
      "RMN",
      "RGN",
      "Support Worker",
    ],
    datatable: {
      data: {},
      current_page: 1,
      per_page: 15,
      last_page: 0,
      total: 1,
    },
    invite_conversion_series: [],
    conversion_time_series: [],
    leaderboard: [],
    showForm: false,
  },
  mutations: {
    setInvites (state, result) {
      state.datatable = result
    },
    setInviteConversionStats (state, result) {
      state.invite_conversion_series = result
    },
    setConversionTimeStats (state, result) {
      state.conversion_time_series = result
    },
    setReferralsLeaderboard (state, result) {
      state.leaderboard = result
    }
  },
  actions: {
    async createInvite(context, state) {
      try {
        const res = await api.post('invite', state)
        context.dispatch('getInvites');
        context.dispatch('getInviteConversionStats');
        context.dispatch('getConversionTimeStats');
        this.showForm = false 
      } catch (error) {
        throw Error(error);
      }
    },
    async getInvites(context) {
      try {
        const res = await api.get('invite?page=' + context.state.datatable.current_page)
        context.commit('setInvites', res.data)
      } catch (error) {
        throw Error(error);
      }
    },
    async getInviteConversionStats(context, state) {
      try {
        const res = await api.get('reporting/conversion')
        context.commit('setInviteConversionStats', res.data)
      } catch (error) {
        throw Error(error);
      }
    },
    async getConversionTimeStats(context, state) {
      try {
        const res = await api.get('reporting/average-time')
        context.commit('setConversionTimeStats', res.data)
      } catch (error) {
        throw Error(error);
      }
    },
    async getReferralsLeaderboard(context, state) {
      try {
        const res = await api.get('reporting/leaderboard')
        context.commit('setReferralsLeaderboard', res.data)
      } catch (error) {
        throw Error(error);
      }
    }
  }
}
