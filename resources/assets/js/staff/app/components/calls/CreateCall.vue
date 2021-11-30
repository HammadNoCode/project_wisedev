<template lang='pug'>
.dropdown.d-inline-block.create-call
	b-dropdown.btn(variant="primary", lazy)
		template(slot="button-content")
			i.fa.fa-fw.fa-user.d-sm-none
			span.d-none.d-sm-inline-block
				| Create Call
		.input-group
			.input-group-prepend
				label.input-group-text
					| Title
			input.form-control(type="text", v-model="callback.title")
		.input-group.mt-2
			.input-group-prepend
				label.input-group-text
					| Staff
			select.custom-select(v-if="departments", v-model="callback.staff_id")
				optgroup(v-for="department in departments", :label="department.name")
					option(v-for="user in department.staff", :value="user.id") {{ user.name }}
		.input-group.mt-2
			.input-group-prepend
				label.input-group-text
					| Time
			input.form-control(
				type="datetime-local",
				v-model="callback.scheduled",
				:min="callback.scheduled"
			)
		.input-group.mt-2
			.input-group-prepend
				label.input-group-text
					| Outcome
			select.form-control(v-model="callback.outcome")
				option(value="1") Pending
				option(value="2") Successful
				option(value="3") Not Interested
				option(value="4") Further Call Required
				option(value="5") Not Available
		button.btn.btn-success.btn-block.mt-2(
			v-on:click="create_call",
			type="button",
			:disabled="disabled"
		)
			i.far.fa-fw.fa-arrow-alt-circle-left.mr-1
			| Create
</template>
<script>
import moment from "moment";

export default {
	data: function () {
		return {
			callback: {
				title: 'Call',
				staff_id: 0,
				scheduled: moment().format('YYYY-MM-DDTHH:mm'),
				path: '',
				outcome: 1,
			},
			disabled: false,
		}
	},
	computed: {
		user_id: function () {
			return this.$store.state.user.id;
		},
		departments: function () {
			return this.$store.state.callUsers || {};
		},
	},
	watch: {
		user_id: function (val) {
			this.callback.staff_id = val;
		}
	},
	methods: {
		create_call() {
			this.callback.path = this.$route.fullPath;
			var error = this.check_form();
			if (!error) {
				this.disabled = true;
				axios.patch('/api/call-schedule/create', this.callback)
					.then(response => {
						this.$root.notification('New call added to schedule', 'success');
						this.callback = {
							title: 'Call',
							staff_id: this.user_id,
							scheduled: moment().format('YYYY-MM-DDTHH:mm'),
							path: '',
							outcome: 1,
						};
					}).catch(error => {
						this.$root.notification(error.response.data.message, 'error');
					})
					.finally(() => {
						this.disabled = false;
					});
			}
		},
		check_form() {
			var error = false;

			if (!this.callback.scheduled) {
				this.$root.notification('Please enter a valid date when scheduling a call.', 'error');
				error = true;
			}
			if (!this.callback.title) {
				this.$root.notification('Please enter a title for the call.', 'error');
				error = true;
			}
			if (!this.callback.path || !this.callback.staff_id) {
				this.$root.notification('There was an issue when scheduling this call.', 'error');
				error = true;
			}
			return error;
		}
	}
}
</script>
<style>
.create-call .dropdown-menu {
	width: 305px;
}

.create-call .dropdown-toggle {
	color: #fff;
	/* background-color: #ff7714;
	border-color: #ff7714; */
}
</style>
