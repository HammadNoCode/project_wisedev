import axios from 'axios'

const api = axios.create({
  baseURL: '/api/recruitment/interview/',
  timeout: 20000
})

export const interview = {
  namespaced: true,
  state: {
    formData: {
      name: "",
      type: "",
      email: "",
      mobile: "",
    },
    invites: {},
    editInvite: false,
    showForm: false,
    loaded: false,
  },
  mutations: {
    setReadInvites(state, result) {
      state.invites = result
    }
  },
  actions: {
    async storeInvite(context, data) {
      try {
        const res = await api.post('invites', data)
      } catch (error) {
        throw Error(error)
      }
    },
    async readInvites(context, data) {
      try {
        const res = await api.get('invites/' + data.id)
        context.commit('setReadInvites', res.data)
      } catch (error) {
        throw Error(error)
      }
    },
    async patchInvite(context, data) {
      try {
        const res = await api.patch('invites/' + data.id, data)
      } catch (error) {
        throw Error(error)
      }
    },
    async destroyInvite(context, data) {
      try {
        const res = await api.delete('invites/' + data.id)
      } catch (error) {
        throw Error(error)
      }
    },
    async reminder(context, data) {
      try {
        const res = await api.post('invite/reminder/' + data.id, data)
      } catch (error) {
        throw Error(error)
      }
    },
    async request(context, data) {
      try {
        const res = await api.post('invite/request/' + data.id, data)
      } catch (error) {
        throw Error(error)
      }
    }
  }
}
