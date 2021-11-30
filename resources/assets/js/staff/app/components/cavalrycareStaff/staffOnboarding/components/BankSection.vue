<template>
  <div>
    <div class="form-row">
      <div class="col-12">
        <h4 class="mb-0 pt-2 pb-3">Bank Details</h4>
      </div>
    </div>
    <hr />
    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Bank
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Bank"
              class="form-control"
              v-model="formData.bank"
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
              >Account Title
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Account Title"
              class="form-control"
              v-model="formData.account_title"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Account Number
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Account Number"
              class="form-control"
              v-model="formData.account_number"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
    </div>

    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Passport Number
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Passport Number"
              class="form-control"
              v-model="formData.passport_number"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
    </div>

    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Sort Code
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Sort Code"
              class="form-control"
              v-model="formData.sort_code"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
    </div>

    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Password to access payslip
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Payslip Password"
              class="form-control"
              v-model="formData.payslip_access_password"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
    </div>

    <div class="form-row py-2">
      <div class="col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Email address you wish your payslip sending to
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Payslip Password"
              class="form-control"
              v-model="formData.payslip_access_email"
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