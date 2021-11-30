<template>
  <div class="mt-4">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Interview Notes</h3>
      </div>
      <div class="block-content">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form
            class="interview-request-form"
            @submit.prevent="handleSubmit(store)"
          >
            <div class="row mb-2">
              <div class="col-md my-auto">
                <label
                  >Can you tell us what first made you first decide to become an
                  HCA/Nurse/Support Worker? Could you say a bit about where
                  you’ve worked and what sort of experience you’ve had? (Your
                  care work story)</label
                >
                <span class="text-danger"
                  >To interviewer: check their employment history with them as
                  you go through and add details of any gaps.</span
                >
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-auto" v-if="data.experience == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="experience"
                    class="form-control"
                    rows="3"
                    v-model="question.experience"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-12 my-auto" v-else>
                <textarea
                  name="experience"
                  class="form-control"
                  rows="3"
                  v-model="data.experience"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="row mb-2">
              <div class="col-md my-auto">
                <label
                  >What do you think your strengths are and what do you find
                  more challenging?</label
                >
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-auto" v-if="data.strengths == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="strengths"
                    class="form-control"
                    rows="3"
                    v-model="question.strengths"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-12 my-auto" v-else>
                <textarea
                  name="strengths"
                  class="form-control"
                  rows="3"
                  v-model="data.strengths"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="row mb-2">
              <div class="col-md my-auto">
                <label
                  >Could you talk about a time when you’ve gone above and beyond
                  in your role as an HCA/Nurse/Support Worker?</label
                >
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-auto" v-if="data.exceed_example == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="exceed_example"
                    class="form-control"
                    rows="3"
                    v-model="question.exceed_example"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-12 my-auto" v-else>
                <textarea
                  name="exceed_example"
                  class="form-control"
                  rows="3"
                  v-model="data.exceed_example"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="row mb-2">
              <div class="col-md my-auto">
                <label
                  >Can you tell us about any training or particular skills you
                  have?</label
                >
                <br />
                <span class="text-danger"
                  >To Interviewer: use the answer to this question to
                  edit/expand the answer they have given on the Profile section
                  of their form.</span
                >
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-auto" v-if="data.skills == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="skills"
                    class="form-control"
                    rows="3"
                    v-model="question.skills"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-12 my-auto" v-else>
                <textarea
                  name="skills"
                  class="form-control"
                  rows="3"
                  v-model="data.skills"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="row mb-2">
              <div class="col-md my-auto">
                <label>Scenario 1: </label>
                <br />
                <label
                  >You’re on shift in a nursing home and you go into a
                  resident’s room and you see another member of staff abusing
                  the resident: what actions would you take?</label
                >
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-auto" v-if="data.scenario_one == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="scenario_one"
                    class="form-control"
                    rows="3"
                    v-model="question.scenario_one"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-12 my-auto" v-else>
                <textarea
                  name="scenario_one"
                  class="form-control"
                  rows="3"
                  v-model="data.scenario_one"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="row mb-2">
              <div class="col-md my-auto">
                <label>Scenario 2: </label>
                <br />
                <label
                  >Again, you’re on shift in a nursing home and you go into a
                  resident’s room and you spot a pill lying on the carpet: what
                  actions would you take?</label
                >
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-auto" v-if="data.scenario_two == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="scenario_two"
                    class="form-control"
                    rows="3"
                    v-model="question.scenario_two"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-12 my-auto" v-else>
                <textarea
                  name="scenario_two"
                  class="form-control"
                  rows="3"
                  v-model="data.scenario_two"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col-md-6">
                <label
                  >What would you like to get out of working with Cavalry
                  Healthcare</label
                >
              </div>
              <div class="col-md-3 my-auto">
                <label>Shift Type</label>
              </div>
              <div class="col-md-3 my-auto">
                <label>Shifts p/w</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" v-if="data.outcome == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <textarea
                    name="outcome"
                    class="form-control"
                    rows="3"
                    v-model="question.outcome"
                    required
                  ></textarea>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-md-6" v-else>
                <textarea
                  name="outcome"
                  class="form-control"
                  rows="3"
                  v-model="data.outcome"
                ></textarea>
              </div>
              <div class="col-md-3" v-if="data.shift_type == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <select
                    name="shift_type"
                    class="form-control"
                    v-model="question.shift_type"
                    required
                  >
                    <option selected disabled>
                      Please select a shift type
                    </option>
                    <option value="0">Days</option>
                    <option value="1">Nights</option>
                    <option value="2">No Preference</option>
                  </select>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-md-3" v-else>
                <select
                  name="shift_type"
                  class="form-control"
                  v-model="data.shift_type"
                >
                  <option selected disabled>Please select a shift type</option>
                  <option value="0">Days</option>
                  <option value="1">Nights</option>
                  <option value="2">No Preference</option>
                </select>
              </div>
              <div class="col-md-3" v-if="data.shifts == null">
                <validation-provider rules="required" v-slot="{ errors }">
                  <select
                    name="shifts"
                    class="form-control"
                    v-model="question.shifts"
                    required
                  >
                    <option value="1">1 or less</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                  </select>
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="col-md-3" v-else>
                <select
                  name="shifts"
                  class="form-control"
                  v-model="data.shifts"
                >
                  <option value="1">1 or less</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                </select>
              </div>
            </div>
            <div class="row pt-5 pb-2">
              <div class="col-auto ml-auto">
                <div class="form-group form-inline input-group">
                  <label for="overallScore" class="mr-1"
                    >Please score this interview (out of 10)</label
                  >
                  <validation-provider rules="required" v-slot="{ errors }">
                    <input
                      type="text"
                      class="form-control"
                      id="overallScore"
                      v-model="question.overall_score"
                      required
                    />
                    <span class="text-danger">{{ errors[0] }}</span>
                  </validation-provider>
                  <div class="input-group-append">
                    <span class="input-group-text">/ 10</span>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <div v-if="data.experience == null">
                  <button
                    class="btn btn-primary float-right"
                    type="submit"
                    name="button"
                  >
                    <i class="fa fa-paper-plane mr-1"></i> Submit
                  </button>
                </div>
                <div v-else>
                  <button
                    class="btn btn-primary float-right"
                    type="button"
                    @click="update(data)"
                    name="button"
                  >
                    <i class="fa fa-paper-plane mr-1"></i> Update
                  </button>
                </div>
              </div>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <instructions />
      </div>
    </div>
  </div>
</template>
<script>
import { ValidationProvider, extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "This field is required",
});

import Instructions from "./Instructions";

export default {
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },
    user: function () {
      return this.$store.state.user;
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/interviews/questionnaire/",
      question: {},
      data: {},
      success: false,
    };
  },
  components: {
    ValidationProvider,
    Instructions,
  },
  mounted() {
    this.show();
  },
  methods: {
    store() {
      axios
        .post(this.routePrefix + this.applicant.id, this.question)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    show() {
      axios
        .get(this.routePrefix + this.applicant.id)
        .then((response) => {
          this.data = response.data;
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    update(data) {
      axios
        .patch(this.routePrefix + this.applicant.id, this.data)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
  },
};
</script>