<template>
  <div class="block block-rounded">
    <div class="block-content">
      <ValidationObserver v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(submit)">
          <div class="form-row py-1">
            <div class="col">
              <h4>Invite Form</h4>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Referral</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <select
                    class="form-control selectpicker"
                    name="Referral"
                    v-model="formData.referral"
                  >
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Position Appying For</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <select
                    class="form-control selectpicker"
                    name="Position"
                    v-model="formData.position"
                  >
                    <option v-for="(option, key) in positions" :key="key">
                      {{ option }}
                    </option>
                  </select>
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Source</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    name="Source"
                    class="form-control"
                    v-model="formData.source"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <div class="form-group">
                <label>First Name</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    name="First name"
                    class="form-control"
                    v-model="formData.first_name"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Surname</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    name="Surname"
                    class="form-control"
                    v-model="formData.last_name"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Email Address</label>
                <ValidationProvider rules="required|email" v-slot="{ errors }">
                  <input
                    type="text"
                    name="Email address"
                    class="form-control"
                    v-model="formData.email"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Telephone No.</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    name="Telephone"
                    class="form-control"
                    v-model="formData.telephone"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Address Line 1</label>
                <input
                  type="text"
                  name="Address line 1"
                  class="form-control"
                  v-model="formData.address_line_1"
                />
              </div>
            </div>
            <!-- <div class="col-md-6 col">
              <div class="form-group">
                <label>Address Line 2</label>
                <input
                  type="text"
                  name="Address line 2"
                  class="form-control"
                  v-model="formData.address_line_2"
                />
              </div>
            </div> -->
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <div class="form-group">
                <label>City</label>
                <input
                  type="text"
                  name="City"
                  class="form-control"
                  v-model="formData.city"
                />
              </div>
            </div>
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Postcode</label>
                <input
                  type="text"
                  name="Postcode"
                  class="form-control"
                  v-model="formData.postcode"
                />
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Hours Per Week</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    name="Hours p/w"
                    class="form-control"
                    v-model="formData.hours_pw"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Driving Licence</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <select
                    name="Driving licence"
                    class="form-control selectpicker"
                    v-model="formData.driving_licence"
                  >
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
          </div>
          <div class="form-row py-3">
            <div class="col">
              <button type="submit" class="btn btn-success w-100">
                Submit
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
      return this.$store.state.invites.formData;
    },
    positions: function () {
      return this.$store.state.invites.positions;
    },
    showForm: {
      get() {
        return this.$parent.showForm;
      },
      set(newValue) {
        this.$parent.showForm = newValue;
      },
    },
    datatable: {
      get() {
        return this.$store.state.datatable;
      },
      set(newValue) {
        this.$store.state.datatable = newValue;
      },
    },
  },
  methods: {
    submit() {
      this.$store.dispatch("invites/createInvite", this.formData);
      this.showForm = false;
    },
  },
};
</script>