<template>
  <div>
    <div class="form-row">
      <div class="col-12">
        <h4 class="mb-0 pt-2 pb-3">Declaration</h4>
      </div>
    </div>
    <hr />
    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <input
              type="checkbox"
              name="T and C's"
              v-model="formData.terms_and_conditions"
            />
            <label for="T and C's"
              >I (the Employee) agree to the particulars of employment outlined
              above and I have recieved a copy of the same.
              <span class="text-danger pl-1">*</span>
            </label>
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
    </div>

    <div class="form-row py-2">
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Date
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="date"
              name="Completion Date"
              class="form-control"
              v-model="formData.onboarding_date"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Print Name
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Print Name"
              class="form-control"
              v-model="formData.print_name"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
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
    formData: {
      get() {
        return this.$store.state.onboarding.formData;
      },
      set(newVal) {
        return (this.$store.state.onboarding.formData = newVal);
      },
    },
  },
};
</script>