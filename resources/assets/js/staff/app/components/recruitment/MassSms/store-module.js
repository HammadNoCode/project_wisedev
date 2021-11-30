import axios from 'axios'

const api = axios.create({
    baseURL: '/api/recruitment/mass-sms/',
    timeout: 20000
})

export const sms = {
    namespaced: true,
    state: {
        filters: {
            status: "all",
            branch: "all",
            role: "all",
            section:"",
        },
        statuses: [
           // "pending",
           // "accepted",
           // "rejected",
           // "inexperienced",
           // "not-yet",
           // "archived",
           // "no-show",
             "Application",
            "Screening",
            "Interview",
            "Offered",
            "Onboarding",
            "Active",
            "Leaver",
            "Pipeline",
        ],
        branches: [
            "Lancashire",
            "Liverpool",
            "Warrington",
            "Crewe",
            "Manchester",
            "Leeds",
            "Shrewsbury",
            "Chester",
            "Permanent",
            "Complex Care",
            "Head Office",
        ],
        roles: [
            "Healthcare Assistant",
            "Senior Healthcare Assistant",
            "RMN",
            "RGN",
            "Support Worker"
        ],
        datatable: {
            data: {},
            current_page: 1,
            per_page: 10,
            last_page: 0,
            total: 1,
        },
        loaded: false,
    },
    mutations: {
        setData (state, result) {
            state.datatable = result
        },
        SET_USERS(state, res) {
            state.res = res
        },
        set_error(state, error) {
            state.error = error
        }
    },
    actions: {
        async getData(context, data) {
            try {
                const res = await api.get(
                    'applications?status=' + data.filters.status +
                    '&branch=' + data.filters.branch +
                    '&role=' + data.filters.role
                );
                context.commit("setData", res.data);
            } catch (error) {
                throw Error(error);
            }
        },
        async sendSms(context, data) {
            try {

                const response = await api.post('send-sms', data)
                context.commit('SET_USERS', response)


            } catch (error) {
                context.commit('set_error', error)

                throw Error(error);
            }
        }
    }
}
