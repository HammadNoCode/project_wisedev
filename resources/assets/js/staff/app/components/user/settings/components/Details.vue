<template>
	<ValidationObserver v-slot="{ handleSubmit }">
		<form @submit.prevent="handleSubmit(update)">
			<div class="row">
				<div class="col">
					<div class="block-title font-w700 text-dark mt-2 mb-2">
						Details
						<button
							type="button"
							class="btn btn-sm btn-outline-secondary float-right"
							v-on:click="form = true"
							v-show="!form"
						>
							<i class="fa fa-edit"></i> Edit
						</button>
						<button
							class="btn btn-sm btn-outline-success float-right"
							type="submit"
							v-show="form"
						>
							<i class="fa fa-check"></i> Save
						</button>
					</div>
				</div>
			</div>
			<div class="js-wizard-simple block block-rounded">
				<div class="block-content block-content-full tab-content">
					<div class="row mt-2">
						<div class="col-md col-sm-12 mx-auto form-group">
							<label for="name">Name</label>
							<ValidationProvider
								:rules="{ required: true, alpha_spaces: true }"
								v-slot="v"
							>
								<input
									type="text"
									name="Full name"
									class="form-control"
									v-model="user.name"
									:disabled="!form"
								/>
								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>
						</div>
						<div class="col-md col-sm-12 mx-auto form-group">
							<label for="name">Position</label>
							<ValidationProvider
								:rules="{ alpha_spaces: true }"
								v-slot="v"
							>
								<input
									type="text"
									name="Position"
									class="form-control"
									v-model="user.position"
									:disabled="!form"
								/>
								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>
						</div>
					</div>
					<div class="row">
						<div class="col-md col-sm-12 mx-auto form-group">
							<label for="email">Email</label>
							<ValidationProvider
								:rules="{ required: true, email: true }"
								v-slot="v"
							>
								<input
									type="text"
									name="Email"
									class="form-control"
									v-model="user.email"
									:disabled="!form"
								/>
								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>
						</div>
						<div class="col-md col-sm-12 mx-auto form-group">
							<label for="telephone">Phone</label>
							<ValidationProvider :rules="{ numeric: true }" v-slot="v">
								<input
									type="text"
									name="Phone"
									class="form-control"
									v-model="user.phone"
									:disabled="!form"
								/>
								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>
						</div>
					</div>
				</div>
			</div>
		</form>
	</ValidationObserver>
</template>
<script>
import { extend } from 'vee-validate';
import { required, alpha_spaces, numeric, email } from 'vee-validate/dist/rules';

extend('email', email)
extend('numeric', numeric)
extend('alpha_spaces', alpha_spaces)
extend('required', {
	...required,
	message: '{_field_} is required'
});

export default {
	data: function () {
		return {
			routePrefix: '/api/user/settings/',
			form: false,
		}
	},
	computed: {
		user: function () {
			return this.$store.state.user
		},
	},
	methods: {
		update() {
			this.disabled === true;
			axios.patch(this.routePrefix + 'update', {
				user: this.user,
			})
				.then(response => {
					this.form = false;
					this.$root.notification(response.data.message, 'success');
					this.$root.read_user();
				})
				.catch(error => {
					this.$root.notification('Error updating', 'error');
				})
		},
	}
}
</script>
