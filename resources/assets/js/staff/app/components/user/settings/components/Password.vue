<template>
	<ValidationObserver v-slot="{ handleSubmit }" ref="form">
		<form @submit.prevent="handleSubmit(update)">
			<div class="row">
				<div class="col">
					<div class="block-title font-w700 text-dark mt-2 mb-2">
						Password
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
			<div class="js-wizard-simple block block-rounded block-bordered">
				<div class="block-content block-content-full tab-content">
					<div class="row mt-3">
						<div class="col-lg-4 col-sm-12 mx-auto form-group">
							<label for="current_password">Current Password</label>
							<ValidationProvider
								:rules="{ required: true, min: 6, max: 64 }"
								v-slot="v"
							>
								<input
									type="password"
									name="Current password"
									class="form-control"
									v-model="model.current_password"
									:disabled="!form"
								/>

								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>
						</div>
						<div class="col-lg-4 col-sm-12 mx-auto form-group">
							<label for="password_1">New Password</label>
							<ValidationProvider
								:rules="{
									required: true,
									min: 6,
									max: 64
								}"
								v-slot="v"
							>
								<input
									type="password"
									name="New password"
									class="form-control"
									v-model="model.password_1"
									:disabled="!form"
								/>
								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>
						</div>
						<div class="col-lg-4 col-sm-12 mx-auto form-group">
							<label for="password_2">Repeat New Password</label>
							<ValidationProvider
								v-slot="v"
								:rules="{ required: true, is: model.password_1 }"
							>
								<input
									type="password"
									name="Confirm password"
									class="form-control"
									v-model="model.password_2"
									:disabled="!form"
								/>
								<span class="text-danger">{{ v.errors[0] }}</span>
							</ValidationProvider>

							<div class="invalid-feedback">
								This field is required and both passwords entered must
								match.
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</ValidationObserver>
</template>
<script>
import { extend } from 'vee-validate';
import { required, min, max, is } from 'vee-validate/dist/rules';

extend('min', {
	...min,
	message: '{_field_} must be a minimum of 6 characters'
})
extend('max', {
	...max,
	message: '{_field_} must be a maximum of 64 characters'
})
extend('is', {
	...is,
	message: 'The passwords do not match'
})
extend('required', {
	...required,
	message: '{_field_} is required'
});

export default {
	data: function () {
		return {
			routePrefix: '/api/user/settings/',
			model: {
				current_password: '',
				password_1: '',
				password_2: '',
			},
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
			axios.patch(this.routePrefix + 'password', {
				password: this.model,
			})
				.then(response => {
					this.model = {};
					this.form = false;
					this.$root.notification(response.data.message, 'success');
				})
				.catch(error => {
					this.$root.notification('Error updating', 'error');
				})
				.then(() => {
					this.$refs.form.reset();
				})
		},
	}
}
</script>
