<template>
  <div class="block block-rounded">
    <div class="block-content">
      <ValidationObserver v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(store)">
          <div class="form-row py-1">
            <div class="col">
              <h4 class="mb-0">Reference Invite Form</h4>
            </div>
          </div>
          <hr />
          <div class="form-row">
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Full Name</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    name="First name"
                    class="form-control"
                    rows="10" style="font-size:2vw; width:100%;"
                    v-model="formData.name"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
            <div class="col-md-6 col">
              <div class="form-group">
                <label>Reference Type</label>
                <ValidationProvider rules="required" v-slot="{ errors }">
                  <select
                    class="form-control selectpicker"
                    name="Reference Type"
                    v-model="formData.type"
                  >
                    <option disabled></option>
                    <option value="1">Professional</option>
                    <option value="2">Personal</option>
                  </select>
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
                    v-model="formData.mobile"
                  />
                  <p class="text-danger">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>
          </div>
          <div class="form-row py-3">
            <div class="col">
              <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-paper-plane pr-2"></i>Send Invite
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
      return this.$store.state.reference.formData;
    },
    positions: function () {
      return this.$store.state.reference.positions;
    },
    showForm: {
      get() {
        return this.$store.state.reference.showForm;
      },
      set(newVal) {
        return (this.$store.state.reference.showForm = newVal);
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
    async store() {
      await this.$store
        .dispatch("reference/storeInvite", {
          data: this.formData,
          id: this.$route.params.id,
        })
        .then((res) => {
          this.showForm = false;
          this.$store.dispatch("reference/readInvites", {
            id: this.$route.params.id,
          });
        });
    },
  },
};
</script>
