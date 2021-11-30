<template>
  <div>
    <div class="form-row">
      <div class="col-12">
        <h4 class="mb-0 pt-2 pb-3">Emergency Contact Details</h4>
      </div>
    </div>
    <hr />
    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Name
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Emergency Contact Name"
              class="form-control"
              v-model="formData.emergency_contact_name"
            />
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
              >Phone Number
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Emergency Contact Phone Number"
              class="form-control"
              v-model="formData.emergency_contact_number"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Your relation with that person
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Emergency Contact Relation"
              class="form-control"
              v-model="formData.emergency_contact_relation"
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