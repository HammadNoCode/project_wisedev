import Vue from 'vue'
import Vuex from 'vuex'

import { calls } from './components/calls/store-module'
import { invites } from './components/recruitment/initialEnquiry/store-module'
import { reports } from './components/branch/reporting/store-module'
import { covid } from "./components/covidResults/store-module"
import { carehome } from "./components/carehomes/store-module"
import { pipeline } from './components/recruitment/pipeline/Store-module'
import { vaccination } from "./components/vaccinations/store-module"
import { reference } from "./components/recruitment/references/store-module"
import { conversion } from './components/recruitment/conversionTracker/store-module'
import { onboarding } from "./components/cavalrycareStaff/staffOnboarding/store-module";
import { emails } from "./components/recruitment/massEmailing/store-module";
import { sms } from "./components/recruitment/MassSms/store-module";

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		calls: calls,
		invites: invites,
		reports: reports,
		covid: covid,
		carehome: carehome,
		pipeline: pipeline,
		vaccination: vaccination,
		reference: reference,
		conversion: conversion,
		onboarding: onboarding,
		emails: emails,
        sms: sms,
	},
	state: {
		user: {
			department_array: {}
		},
		callUsers: {}
	},
	mutations: {
		mutate(state, payload) {
			state[payload.property] = payload.with;
		},
	},
	actions: {
		async showUser(context) {
			if (!context.state.userLoaded) {
				try {
					const user = await axios.get('/api/user')
					context.commit('mutate', {
						property: 'user',
						with: user.data.user
					});
					await context.dispatch('showCallUsers');
				} catch (error) {
					throw Error(error);
				} finally {
					context.commit('mutate', {
						property: 'userLoaded',
						with: true
					});
				}
			}
		},
		async showCallUsers(context) {
			try {
				const callusers = await axios.get('/api/call-schedule/staff')
				context.commit('mutate', {
					property: 'callUsers',
					with: (Array.isArray(callusers.data)) ? callusers.data : [callusers.data]
				});
			} catch (error) {
				throw Error(error);
			}
		},
	},
});
