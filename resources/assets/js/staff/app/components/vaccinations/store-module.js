import axios from 'axios'

const api = axios.create({
  baseURL: '/api/covid/vaccination/',
  timeout: 20000
})

export const vaccination = {
  namespaced: true,
  state: {
    datatable: {
      data: {},
      current_page: 1,
      per_page: 15,
      last_page: 0,
      total: 1,
    },
    filters: {
      archived: "no",
      search: "",
      no_vaccinations: "all",
    },
    vaccinations: {},
    loaded: false,
  },
  mutations: {
    setVaccinations (state, result) {
      state.datatable = result;
    },
    setShowVaccination (state, result) {
      state.vaccinations = result;
    }
  },
  actions: {
    async getVaccinations(context, data) {
      try {
        const res = await api.get(
          'uploads?page=' + data.datatable.current_page +
          '&search=' + data.filters.search +
          '&archived=' + data.filters.archived +
          '&no_vaccinations' + data.filters.no_vaccinations
          )
        context.commit('setVaccinations', res.data)
      } catch (error) {
        throw Error(error)
      }
    },
    async showVaccination(context, data) {
      vaccination.loaded = false;
      try {
        const res = await api.get(data.id)
        context.commit('setShowVaccination', res.data);
      } catch (error) {
        throw Error(error)
      }
    }
  }
}
