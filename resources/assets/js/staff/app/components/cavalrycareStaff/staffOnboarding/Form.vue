<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <h3>New Starter Form</h3>
      </div>
    </div>
    <div class="block block-rounded">
      <div class="block-content">
        <ValidationObserver>
          <form>
            <personal-details />

            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label class="text-left"
                      >Attached National ID Card (Front & Back)
                      <span class="text-danger pl-1">*</span>
                    </label>
                    <br />
                    <br />
                    <label for="file-upload" class="text-muted">
                      <div class="btn btn-primary text-center px-5 py-3">
                        <i class="fas fa-file-upload pr-2"></i>Upload
                      </div>
                    </label>
                    <input
                      id="file-upload"
                      class="form-control"
                      type="file"
                      ref="file"
                      enctype="multipart/form-data"
                      name="National ID"
                      multiple
                      @change="onFileChange"
                    />
                    <p class="text-danger">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div
                class="imgUpload col-lg-4 col-md-2 col-12"
                v-for="(image, key) in uploadData.images"
                :key="key"
              >
                <img :src="image.src" class="preview w-100" />
                <i
                  @click="removeImage(key)"
                  class="fas fa-times text-danger"
                ></i>
              </div>
            </div>

            <banking-details />
            <emergency-contact />
            <declaration />
            <div class="py-3">
              <button
                type="button"
                class="btn btn-primary w-100"
                @click="submit"
              >
                Submit
              </button>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
  </div>
</template>
<script>
import PersonalDetails from "./components/PersonalDetails.vue";
import BankingDetails from "./components/BankSection.vue";
import EmergencyContact from "./components/EmergencyContact.vue";
import Declaration from "./components/Declaration.vue";

import { serialize } from "object-to-formdata";

export default {
  components: {
    PersonalDetails,
    BankingDetails,
    EmergencyContact,
    Declaration,
  },
  computed: {
    uploadData: {
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
      if (e.target.files.length !== 0) {
        for (let i = 0; i < selectedFiles.length; i++) {
          let img = {
            src: URL.createObjectURL(selectedFiles[i]),
            file: selectedFiles[i],
          };
          this.uploadData.images.push(img);
          this.file = e.target.files[0];
        }
      }
    },
    removeImage(key) {
      this.uploadData.images.splice(key, 1);
    },
    submit() {
      let form_data = serialize(this.uploadData);
      axios.post("/api/staff-onboarding", form_data, {
        headers: {
          "Content-Types": "multipart/form-data",
        },
      });
    },
  },
};
</script>

<style scoped>
input[type="file"] {
  display: none;
}
</style>