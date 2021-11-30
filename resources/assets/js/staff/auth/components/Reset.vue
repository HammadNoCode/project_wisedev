<template>
  <div class="p-3 w-100">
    <div class="mb-3 text-center">
      <a class="font-w700 font-size-h1" href="#">
        <span class="text-primary">Cavalry</span>
        <span class="text-dark">Healthcare</span>
      </a>
      <p class="text-uppercase font-w700 font-size-sm text-muted">Reset Password</p>
    </div>
    <div class="row no-gutters justify-content-center">
      <div class="col-sm-8 col-xl-6">
        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
          <form @submit.prevent="handleSubmit(submit)">
            <div class="py-3">
              <div class="form-group">
                <input
                  type="hidden"
                  class="form-control form-control-alt"
                  :class="{ 'is-invalid': custom_error !== null }"
                />
                <div class="invalid-feedback">{{ custom_error }}</div>
              </div>
              <div class="form-group">
                <input
                  type="hidden"
                  class="form-control form-control-alt"
                  :class="{ 'is-valid': custom_success !== null }"
                />
                <div class="valid-feedback">{{ custom_success }}</div>
              </div>
              <div class="form-group">
                <ValidationProvider :rules="{ required: true, email: true }" v-slot="v">
                  <input
                    type="text"
                    class="form-control form-control-alt"
                    id="Email"
                    name="Email"
                    placeholder="Email"
                    v-model="reset.email"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-block btn-hero-lg btn-hero-danger">
                <i class="fa fa-exclamation-triangle mr-1"></i> Send
                Password Reset
              </button>
              <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                <router-link
                  class="btn btn-sm btn-light d-block d-lg-inline-block mb-1"
                  to="/login"
                >
                  <i class="fa fa-sign-in-alt text-muted mr-1"></i>
                  Sign In
                </router-link>
                <router-link
                  class="btn btn-sm btn-light d-block d-lg-inline-block mb-1"
                  to="/register"
                >
                  <i class="fa fa-plus text-muted mr-1"></i> Register
                </router-link>
              </p>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
  </div>
</template>
<script>
import { extend } from "vee-validate";
import { required, email } from "vee-validate/dist/rules";

extend("email", email);
extend("required", {
  ...required,
  message: "{_field_} is required",
});

export default {
  data: function () {
    return {
      reset: {
        email: "",
      },
      custom_error: null,
      custom_success: null,
    };
  },
  methods: {
    submit() {
      axios
        .post("/auth/reset", this.reset)
        .then((response) => {
          this.custom_error = null;
          this.custom_success = response.data.message;
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.custom_success = null;
          if (error.response.data.message) {
            this.custom_error = error.response.data.message;
          } else {
            this.custom_error = null;
          }
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.$refs.form.reset();
        });
    },
  },
};
</script>
<style scoped>
.form-control.form-control-alt {
  border-color: #f4f6fa !important;
  background-color: #f4f6fa !important;
  transition: none !important;
  color: #000 !important;
}

.form-control.form-control-alt:focus {
  border-color: #e6ebf4 !important;
  background-color: #e6ebf4 !important;
  box-shadow: none !important;
}
</style>
