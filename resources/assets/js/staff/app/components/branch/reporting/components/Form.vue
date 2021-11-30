<template>
  <div class="block block-rounded">
    <div class="block-content">
      <ValidationObserver v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(store)">
          <div class="form-row py-1">
            <div class="col">
              <h4>Title Goes Here</h4>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Select role data is regarding</label>
                <select
                  class="form-control selectpicker"
                  name="Position"
                  v-model="formData.position"
                >
                  <option v-for="(position, key) in positions" :key="key">
                    {{ position }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <ValidationProvider rules="required" v-slot="{ errors }">
                <label>Hours Achieved</label>
                <input
                  type="text"
                  name="Hours achieved"
                  class="form-control"
                  v-model="formData.hours_achieved"
                />
                <p class="text-danger">{{ errors[0] }}</p>
              </ValidationProvider>
            </div>
            <div class="col-md-6 col">
              <ValidationProvider rules="required" v-slot="{ errors }">
                <label>Hours Lost</label>
                <input
                  type="text"
                  name="Hours lost"
                  class="form-control"
                  v-model="formData.hours_lost"
                />
                <p class="text-danger">{{ errors[0] }}</p>
              </ValidationProvider>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <ValidationProvider rules="required" v-slot="{ errors }">
                <label>Week Commencing</label>
                <input
                  type="date"
                  name="Week commencing"
                  class="form-control"
                  v-model="formData.week_commencing"
                />
                <p class="text-danger">{{ errors[0] }}</p>
              </ValidationProvider>
            </div>
            <div class="col-md-6 col">
              <ValidationProvider rules="required" v-slot="{ errors }">
                <label>Week Ending</label>
                <input
                  type="date"
                  name="End of week"
                  class="form-control"
                  v-model="formData.week_ending"
                />
                <p class="text-danger">{{ errors[0] }}</p>
              </ValidationProvider>
            </div>
          </div>
          <div class="form-row py-3">
            <div class="col">
              <button type="submit" class="btn btn-success w-100">
                Save Report
              </button>
            </div>
          </div>
        </form>
      </ValidationObserver>
    </div>
  </div>
</template>
<script>
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";
extend("required", {
  ...required,
  message: "{_field_} field is required",
});

export default {
  computed: {
    formData: function () {
      return this.$store.state.reports.formData;
    },
    positions: function () {
      return this.$store.state.reports.positions;
    },
    branch: function () {
      return this.$parent.branch;
    },
    showForm: {
      get() {
        return this.$parent.showForm;
      },
      set(newValue) {
        this.$parent.showForm = newValue;
      },
    },
  },
  data: function () {
    return {};
  },
  methods: {
    store() {
      this.$store.dispatch("reports/storeReport", {
        branch: this.branch,
        data: this.formData,
      });
      this.showForm = false;
    },
  },
};
</script>