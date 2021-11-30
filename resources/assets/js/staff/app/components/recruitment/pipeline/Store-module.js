import axios from 'axios'
import { update } from 'lodash'

const api = axios.create({
  baseURL: '/api/recruitment/pipeline/',
  timeout: 20000
})

export const pipeline = {
  namespaced: true,
  state: {
    datatable: {
      data: {},
      current_page: 1,
      per_page: 15,
      last_page: 0,
      total: 1,
    },
    hours: "",
    branches: {},
    filters: {
      search: "",
      position: "all",
      branch: "all",
      driver: "all",
      shift: "all",
      score: "all",
      favourite: "all",
      compliance: "all",
      sort: "newest",
      hourspw: "all",
    },
    missing_compliance: {},
    loaded: false,
    showFilters: false,
  },
  mutations: {
    setDatatable (state, result) {
      state.datatable = result
    },
    setBranches (state, result) {
      state.branches = result
    },
    setStats (state, result) {
      state.hours = result
    },
    setMissingCompliance (state, result) {
      state.missing_compliance = result
    }
  },
  actions: {
    async getDatatable (context, data) {
      try {
        const res = await api.get(
          'applicant?page=' + data.datatable.current_page +
          '&position=' + data.filters.position +
          '&branch=' + data.filters.branch +
          '&driver=' + data.filters.driver +
          '&shift=' + data.filters.shift +
          '&score=' + data.filters.score +
          '&favourite=' + data.filters.favourite +
          '&compliance=' + data.filters.compliance +
          '&sort=' + data.filters.sort +
          '&hours=' + data.filters.hours +
          '&search=' + data.filters.search
        )
        context.commit('setDatatable', res.data)
      } catch (error) {
        throw Error(error)
      }
    },
    async getBranches (context, data) {
      try {
        const res = await axios.get('/api/management/staff/branches/');
        context.commit('setBranches', res.data)
      } catch (error) {
        throw Error(error)
      }
    },
    async updateDatatable (context, data) {
      try {
        const res = await api.patch('applicant/' + data.id, data.favourite)
      } catch(error) {
        throw Error(error)
      }
    },
    async getStats (context, data) {
      try {
        const res = await api.get(
          'stats?position=' + data.filters.position +
          '&branch=' + data.filters.branch +
          '&driver=' + data.filters.driver +
          '&shift=' + data.filters.shift +
          '&score=' + data.filters.score +
          '&favourite=' + data.filters.favourite +
          '&compliance=' + data.filters.compliance +
          '&sort=' + data.filters.sort +
          '&hours=' + data.filters.hours +
          '&search=' + data.filters.search
        )
        context.commit('setStats', res.data)
      } catch (error) {
        throw Error(error)
      }
    },
    async getMissingCompliance (context, data) {
      try {
        const res = await api.get('missing_compliance/' + data.id)
        context.commit('setMissingCompliance', res.data);
      } catch (error) {
        throw Error(error)
      }
    }
  }
}
