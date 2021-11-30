<template>
  <div class="p-3 w-100">
    <div class="mb-3 text-center">
      <a class="font-w700 font-size-h1" href="#">
        <span class="text-primary">Cavalry</span>
        <span class="text-dark">Healthcare</span>
      </a>
      <p class="text-uppercase font-w700 font-size-sm text-muted">Sign In</p>
    </div>
    <div class="row no-gutters justify-content-center">
      <div class="col-sm-8 col-xl-6">
        <ValidationObserver v-slot="{ handleSubmit }">
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
                <ValidationProvider :rules="{ required: true, email: true }" v-slot="v">
                  <input
                    v-model="login.email"
                    type="text"
                    class="form-control form-control-alt text-center"
                    id="Email"
                    name="Email"
                    placeholder="Email"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="form-group">
                <ValidationProvider :rules="{ required: true }" v-slot="v">
                  <input
                    v-model="login.password"
                    type="password"
                    class="form-control form-control-alt text-center"
                    id="Password"
                    name="Password"
                    placeholder="Password"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
              </button>
              <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                <router-link
                  class="btn btn-sm btn-light d-block d-lg-inline-block mb-1"
                  to="/reset"
                >
                  <i class="fa fa-exclamation-triangle text-muted mr-1"></i>
                  Forgot password
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
      login: {
        username: "",
        password: "",
      },
      custom_error: null,
    };
  },
  methods: {
    show_form(form_name) {
      this.form = form_name;
    },
    submit() {
      axios
        .post("/auth/login", this.login)
        .then((response) => {
          location.reload();
        })
        .catch((error) => {
          if (error.response.data.message) {
            this.custom_error = error.response.data.message;
          } else {
            this.custom_error = null;
          }
          this.$parent.notification(error.response.data.message, "error");
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
