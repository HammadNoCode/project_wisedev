<template>
  <div>
    <div class="form-row">
      <div class="col-12">
        <h4 class="mb-0 pt-2 pb-3">Personal Details</h4>
      </div>
    </div>
    <hr />
    <div class="form-row py-2">
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Full Name
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Full name"
              class="form-control"
              v-model="formData.full_name"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Email Address
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Email address"
              class="form-control"
              v-model="formData.email_address"
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
              >Address Line 1
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Address line 1"
              class="form-control"
              v-model="formData.address_line_1"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label>Address Line 2</label>
            <input
              type="text"
              name="Address line 2"
              class="form-control"
              v-model="formData.address_line_2"
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
              >Postcode
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="Postcode"
              class="form-control"
              v-model="formData.postcode"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label>Town</label>
            <input
              type="text"
              name="Town"
              class="form-control"
              v-model="formData.town"
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
            <label>Contact Number(Mobile)</label>
            <input
              type="text"
              name="Contact Number(Mobile)"
              class="form-control"
              v-model="formData.mobile_number"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label>Contact Number(Home)</label>
            <input
              type="text"
              name="Contact Number(Home)"
              class="form-control"
              v-model="formData.home_number"
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
              >Marital Status
              <span class="text-danger pl-1">*</span>
            </label>
            <select
              name="Martial status"
              class="form-control"
              v-model="formData.marital_status"
            >
              <option value="Single">Single</option>
              <option value="Married">Married</option>
              <option value="Civil Partnered">Civil Partnered</option>
              <option value="Divorced">Divorced</option>
              <option value="Widowed">Widowed</option>
            </select>
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >Gender
              <span class="text-danger pl-1">*</span>
            </label>
            <select class="form-control select" v-model="formData.gender">
              <option value="" selected disabled>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="prefer no to say">Prefer not to say</option>
            </select>
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
              >Date of Birth
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="date"
              name="Date of birth"
              class="form-control"
              v-model="formData.date_of_birth"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
      </div>
      <div class="col-md-6 col">
        <div class="form-group">
          <ValidationProvider rules="required" v-slot="{ errors }">
            <label
              >NI number
              <span class="text-danger pl-1">*</span>
            </label>
            <input
              type="text"
              name="National insurance number"
              class="form-control"
              v-model="formData.national_insurance_number"
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

import vueSignature from "vue-signature";

export default {
  components: {
    vueSignature,
  },
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
  methods: {
    async onFileChange(e) {
      let selectedFiles = e.target.files;
      // let compressedFile;

      if (e.target.files.length !== 0) {
        for (let i = 0; i < selectedFiles.length; i++) {
          // compressedFile = await this.compressFile(selectedFiles[i]);
          let img = {
            src: URL.createObjectURL(selectedFiles[i]),
            file: selectedFiles,
          };
          this.formData.images.push(img);
          // this.file = e.target.files[0];
        }
      }
    },
    removeImage(key) {
      this.formData.images.splice(key, 1);
    },
  },
};
</script>