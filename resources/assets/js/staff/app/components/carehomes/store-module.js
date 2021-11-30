import axios from 'axios'
import { update } from 'lodash'

const api = axios.create({
  baseURL: '/api/carehome/',
  timeout: 20000
})

export const carehome = {
  namespaced: true,
  state: {

  },
  mutations: {
  },
  actions: {
    async createCavalryAgency(context, data) {
      console.log(data.id)  
      try {
        const res = await api.post('agency/' + data.id, data)
      } catch (error) {
        throw Error(error);
      }
    }
  }
}
