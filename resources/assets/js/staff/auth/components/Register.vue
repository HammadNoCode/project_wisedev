<template>
  <div class="p-3 w-100">
    <div class="mb-3 text-center">
      <a class="font-w700 font-size-h1" href="#">
        <span class="text-primary">Cavalry</span>
        <span class="text-dark">Healthcare</span>
      </a>
      <p class="text-uppercase font-w700 font-size-sm text-muted">Register</p>
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
                <ValidationProvider :rules="{ required: true }" v-slot="v">
                  <input
                    type="text"
                    class="form-control form-control-alt"
                    id="Full Name"
                    name="Full Name"
                    placeholder="Full Name"
                    v-model="register.name"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="form-group">
                <ValidationProvider :rules="{ required: true, email: true }" v-slot="v">
                  <input
                    type="text"
                    class="form-control form-control-alt"
                    id="Email"
                    name="Email"
                    placeholder="Email"
                    v-model="register.email"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="form-group">
                <ValidationProvider :rules="{ required: true, min: 6, max: 64 }" v-slot="v">
                  <input
                    type="password"
                    class="form-control form-control-alt"
                    id="Password"
                    name="Password"
                    placeholder="Password"
                    v-model="register.password_1"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="form-group">
                <ValidationProvider :rules="{ required: true, is: register.password_1 }" v-slot="v">
                  <input
                    type="password"
                    class="form-control form-control-alt"
                    id="Password confirmation"
                    name="Password confirmation"
                    placeholder="Confirm Password"
                    v-model="register.password_2"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-block btn-hero-lg btn-hero-success">
                <i class="fa fa-fw fa-plus mr-1"></i> Sign Up
              </button>
              <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                <router-link
                  class="btn btn-sm btn-light d-block d-lg-inline-block mb-1"
                  to="/login"
                >
                  <i class="fa fa-sign-in-alt text-muted mr-1"></i>
                  Sign In
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
import { required, email, is, min, max } from "vee-validate/dist/rules";

extend("email", email);
extend("min", {
  ...min,
  message: "{_field_} must be a minimum of 6 characters",
});
extend("max", {
  ...max,
  message: "{_field_} must be a maximum of 64 characters",
});
extend("required", {
  ...required,
  message: "{_field_} is required",
});
extend("is", {
  ...is,
  message: "The passwords do not match",
});
export default {
  data: function () {
    return {
      register: {
        name: "",
        email: "",
        password_1: "",
        password_2: "",
      },
      custom_error: null,
    };
  },
  methods: {
    submit() {
      this.custom_error = null;
      axios
        .post("/auth/register", this.register)
        .then((response) => {
          this.$router.push("/login");
          this.$root.notification("Registration successful", "success");
        })
        .catch((error) => {
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
