export const calls = {
	namespaced: true,
	state: {
		call: {
			user: '',
			time: '',
		},
		filters: {
			outcome: 0,
			from: '',
			to: '',
			user: 0
		},
		overview: {},
		results: {},
		departmentStaff: {}
	},
	mutations: {
		storeCallUser(state, val) {
			state.call.user = val;
		},
		storeCallsOutcomeFilter(state, val) {
			state.filters.outcome = val;
		},
		storeCallsFromFilter(state, val) {
			state.filters.from = val;
		},
		storeCallsToFilter(state, val) {
			state.filters.to = val;
		},
		storeCallsFilter(state, val) {
			state.filters = val;
		},
		storeCallsUserFilter(state, val) {
			state.filters.user = val;
		},
		storeCallsQueryResults(state, val) {
			state.results = val;
		},
		storeDepartmentStaffQueryResults(state, val) {
			state.departmentStaff = val;
		},
		storeCallsOverview(state, val) {
			state.overview = val;
		}
	},
}
