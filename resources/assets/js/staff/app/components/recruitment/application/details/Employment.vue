<template>
  <div>
    <div class="row mt-3 mb-1">
      <div class="col-auto ml-auto">
        <button
          type="button"
          name="button"
          class="btn btn-danger btn-sm float-right mb-1"
          v-show="newEmployment"
          @click="newEmployment = false"
        >
          <i class="fa fa-minus mx-1"></i>
          <span class="mr-1">Cancel</span>
        </button>
        <button
          type="button"
          name="button"
          class="btn btn-primary btn-sm float-right mb-1"
          v-show="!newEmployment"
          @click="newEmployment = true"
        >
          <i class="fa fa-plus mx-1"></i>
          <span class="mr-1">Add employment</span>
        </button>
      </div>
    </div>
    <div v-if="newEmployment == true">
      <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
        <div class="block-content block-content-full tab-content">
          <div>
            <div class="row">
                <div class="col-8 my-auto">
                    <span class="h6">New Employment Record</span>
                </div>
                <div class="col-4 my-auto my-auto">
                    <button
                    type="button"
                    name="button"
                    class="btn btn-sm btn-success float-right"
                    @click="store"
                    >
                    <i class="far fa-save mr-1"></i>Save
                    </button>
                </div>
            </div>
            <hr/>
            <div class="row mt-3">
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="jobs">Company</label>
                <input
                  type="text"
                  name="company"
                  class="form-control"
                  v-model="newEmployer.name"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="postcode">Role</label>
                <input
                  type="text"
                  name="role"
                  class="form-control"
                  v-model="newEmployer.role"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="skills">Employment Start</label>
                <input
                  type="date"
                  name="employment_end"
                  class="form-control"
                  v-model="newEmployer.employed_from"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="skills">Employment End <span style="color:red; font-size:12px;">(Leave empty if still employed to this company)</span></label>
                  <input
                    type="date"
                    name="employment_to"
                    class="form-control"
                    v-model="newEmployer.employed_to"
                  />
                  <div class="invalid-feedback">
                    This field is required and must contain only letters &
                    numbers.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="employerCount > 0">
      <div v-for="(employment, key) in employment" :key="key">
        <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
          <div class="block-content block-content-full tab-content">
            <div>
              <label>Employment {{ key + 1 }}</label>
              <hr/>
              <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 form-group">
                  <label for="jobs">Company</label>
                  <input
                    type="text"
                    name="company"
                    class="form-control"
                    v-model="employment.name"
                    :disabled="!edit"
                  />
                  <div class="invalid-feedback">
                    This field is required and must contain only letters &
                    numbers.
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                  <label for="postcode">Role</label>
                  <input
                    type="text"
                    name="role"
                    class="form-control"
                    v-model="employment.role"
                    :disabled="!edit"
                  />
                  <div class="invalid-feedback">
                    This field is required and must contain only letters &
                    numbers.
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-sm-12 form-group">
                  <label for="skills">Employment Start</label>
                  <input
                    type="date"
                    name="employment_end"
                    class="form-control"
                    v-model="employment.employed_from"
                    :disabled="!edit"
                  />
                  <div class="invalid-feedback">
                    This field is required and must contain only letters &
                    numbers.
                  </div>
                </div>
                <div class="col-lg-6" v-if="employment.employed_to == null">
                  <div class="form-group">
                    <label for="skills">Currently Working</label>
                    <input
                      name="employment_to"
                      class="form-control"
                      value="Present"
                      :disabled="!edit"
                    />
                    <div class="invalid-feedback">
                      This field is required and must contain only letters &
                      numbers.
                    </div>
                  </div>
                </div>
                <div class="col-lg-6" v-else>
                  <div class="form-group">
                    <label for="skills">Employment End</label>
                    <input
                      type="date"
                      name="employment_to"
                      class="form-control"
                      v-model="employment.employed_to"
                      :disabled="!edit"
                    />
                    <div class="invalid-feedback">
                      This field is required and must contain only letters &
                      numbers.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
        <div class="block-content block-content-full tab-content">
          <div class="col-12 form-group">
            <label for="jobs">Reason for gaps between employment</label>
            <textarea
              type="text"
              name="employment_gaps"
              class="form-control"
              v-model="applicant.employment_gaps"
              :disabled="!edit"
            ></textarea>
            <div
              class="invalid-feedback"
            >This field is required and must contain only letters & numbers.</div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-center mt-5">
      <i class="fas fa-times fa-3x" style="color:#e04f1a"></i>
      <h2 class="text-muted text-center mt-4">No employment history provided</h2>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },
    employerCount: function () {
      return _.size(this.employment);
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/employment/",
      edit: false,
      disabled: false,
      newEmployment: false,
      newEmployer: {},
      employment: {},
    };
  },
  mounted() {
    this.showEmployment();
  },
  methods: {
      showEmployment() {
        axios
          .get(this.routePrefix + this.$route.params.id)
          .then((response) => {
            this.employment = response.data;
          });
      },
      store() {
      this.disabled = true;
      axios
        .patch(this.routePrefix + this.applicant.id, this.newEmployer)
        .then((response) => {
          this.newEmployment = false;
          this.showEmployment();
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
    },
  }
};
</script>
