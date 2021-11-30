import axios from 'axios'

const api = axios.create({
  baseURL: '/api/covid/test/',
  timeout: 20000
})

export const covid = {
  namespaced: true,
  state: {
    datatable: {
      data: {},
      current_page: 1,
      per_page: 15,
      last_page: 0,
      total: 1,
    },
    filter: "all",
    search: "",
    archived: "no",
    loaded: false,
  },
  mutations: {
    setUploads (state, result) {
      state.datatable = result;
    }
  },
  actions: {
    async getUploads(context, state) {
      try {
         const res = await api.get(
           'uploads?page=' + state.current_page +
           '&filter=' + state.filter +
           '&search=' + state.search +
           '&archived=' + state.archived
         )
         context.commit('setUploads', res.data)
      } catch (error) {
        throw Error(error);
      }
    }
  }

}
