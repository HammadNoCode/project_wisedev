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
          <form class="js-validation-reminder" @submit.prevent="handleSubmit(submit)">
            <div class="form-group">
              <ValidationProvider :rules="{ required: true, min: 6, max: 64 }" v-slot="v">
                <input
                  type="password"
                  class="form-control form-control-alt"
                  id="Password"
                  name="Password"
                  placeholder="Password"
                  v-model="reset.password_1"
                />
                <span class="text-danger">{{ v.errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group">
              <ValidationProvider :rules="{ required: true, is: reset.password_1 }" v-slot="v">
                <input
                  type="password"
                  class="form-control form-control-alt"
                  id="Password confirmation"
                  name="Password confirmation"
                  placeholder="Confirm Password"
                  v-model="reset.password_2"
                />
                <span class="text-danger">{{ v.errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-block btn-hero-lg btn-hero-danger">
                <i class="fa fa-fw fa-reply mr-1"></i> Password Reset
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
import { required, is, min, max } from "vee-validate/dist/rules";

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
      reset: {
        password_1: "",
        password_2: "",
      },
    };
  },
  computed: {
    token: function () {
      return this.$route.params.token;
    },
  },
  mounted() {
    this.validate();
  },
  methods: {
    validate() {
      axios
        .post("/auth/recover", {
          token: this.token,
        })
        .catch((error) => {
          this.$router.push("/login");
          this.$root.notification(error.response.data.message, "error");
        });
    },
    submit() {
      axios
        .patch("/auth/recover", {
          token: this.token,
          password: this.reset.password_1,
        })
        .then((response) => {
          this.$root.notification(response.data.message, "success");
          this.$router.push("/login");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
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