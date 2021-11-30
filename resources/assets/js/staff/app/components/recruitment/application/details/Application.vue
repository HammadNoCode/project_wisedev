<template>
  <div>
    <div class="row mt-3">
      <div class="col-auto ml-auto">
        <button
          type="button"
          name="button"
          class="btn btn-success btn-sm float-right mb-2"
          v-show="edit"
          :disabled="disabled"
          @click="update(applicant)"
        >
          <i class="fa fa-check mx-1"></i>
          <span class="mr-1">Save</span>
        </button>
        <button
          type="button"
          name="button"
          class="btn btn-secondary btn-sm float-right mb-2"
          v-on:click="edit = true"
          v-show="!edit"
        >
          <i class="fa fa-edit mx-1"></i>
          <span class="mr-1">Edit</span>
        </button>
      </div>
    </div>

    <div class="row">
      <div class="col-12" v-if="applicant.latest_test">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12 my-auto">
                <span class="h6">Latest Covid Test Details</span>
              </div>
            </div>
            <hr />
            <div class="row">
              <div
                class="col-lg-6 col-12 form-group"
                v-if="applicant.latest_test.covid_result == 0"
              >
                <label for="telephone">Covid Result</label>
                <input
                  type="text"
                  name="result"
                  id="result"
                  style="background-color: #82b54b"
                  class="form-control"
                  disabled
                  placeholder="Negative"
                />
              </div>
              <div class="col-lg-6 col-12 form-group" v-else>
                <label for="telephone">Covid Result</label>
                <input
                  type="text"
                  name="result"
                  id="result"
                  style="background-color: #e04f1a"
                  class="form-control"
                  disabled
                  placeholder="Positive"
                />
              </div>
              <div class="col-lg-6 col-12 form-group">
                <label for="position">Date of Test</label>
                <input
                  type="date"
                  name="DoT"
                  id="DoT"
                  class="form-control"
                  disabled
                  v-model="applicant.latest_test.test_date"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12 my-auto">
                <span class="h6">Application Details</span>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="telephone">Applicant Status</label>
                <select
                  v-if="applicant.hired == 1"
                  class="form-control"
                  name="application-hired"
                  v-model="applicant.hired"
                  v-bind:class="{
                    accepted: applicant.hired == '1',
                  }"
                  :disabled="!edit"
                >
                  <option value="NULL" selected>Pending</option>
                  <option value="1">Hired</option>
                </select>
                <select
                  v-else
                  class="form-control"
                  name="application-status"
                  v-model="applicant.status"
                  v-bind:class="{
                    Application: applicant.status == '0',
                    Screening: applicant.status == '1',
                    Interview: applicant.status == '2',
                    Offered: applicant.status == '3',
                    Onboarding: applicant.status == '4',
                    Active: applicant.status == '5',
                    Leaver: applicant.status == '6',
                    Pipeline: applicant.status == '7',
                  }"
                  :disabled="!edit"
                >
                  <option value="0" selected>Application</option>
                  <option value="1">Screening</option>
                  <option value="2">Interview</option>
                  <option value="3">Offered</option>
                  <option value="4">Onboarding</option>
                  <option value="5">Active</option>
                  <option value="6">Leaver</option>
                    <option value="7">Pipeline</option>
                </select>
              </div>
          <!--      <div class="col-lg-4 col-sm-12 form-group">
                    <label for="telephone">Sub Status</label>
                    <select
                        v-if="applicant.hired == 1"
                        class="form-control"
                        name="application-hired"
                        v-model="applicant.hired"
                        v-bind:class="{
                    accepted: applicant.hired == '1',
                  }"
                        :disabled="!edit"
                    >
                        <option value="NULL" selected>Pending</option>
                        <option value="1">Hired</option>
                    </select>
                    <select
                        v-else
                        class="form-control"
                        name="application-status"
                        v-model="applicant.sub_status"
                        v-bind:class="{
                    Application: applicant.sub_status == '1',
                    Screening: applicant.sub_status == '10',
                    Interview: applicant.sub_status == '11',
                    Offered: applicant.sub_status == '12',
                    Onboarding: applicant.sub_status == '13',
                    Active: applicant.sub_status == '14',
                    Leaver: applicant.sub_status == '15',
                    Pipeline: applicant.sub_status == '16',
                    Pipeliness: applicant.sub_status == '56',
                  }"
                        :disabled="!edit"
                    >
                        <option value="1" selected>Application</option>
                        <option value="10">Screening</option>
                        <option value="11">Interview</option>
                        <option value="12">Offered</option>
                        <option value="13">Onboarding</option>
                        <option value="14">Active</option>
                        <option value="15">Leaver</option>
                        <option value="16">Pipeline</option>
                        <option value="56">Pipe</option>
                    </select>
                </div> -->
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="position">Branch</label>
                <select
                  class="form-control selectpicker"
                  name="branch"
                  :disabled="!edit"
                  v-model="applicant.branch_id"
                >
                  <option value selected>Don't Assign</option>
                  <option
                    class="optionpicker"
                    v-for="branch in branches"
                    v-bind:key="branch.id"
                    :value="branch.id"
                  >
                    {{ branch.name }}
                  </option>
                </select>
              </div>
                <div class="col-lg-4 col-sm-12 form-group">
                    <label for="position">Sub Status</label>
                    <select
                        class="form-control selectpicker"
                        name="application-sub-status"
                        :disabled="!edit"
                        v-model="applicant.sub_status"
                    >
                        <option value selected>Don't Assign</option>
                        <option
                            class="optionpicker"
                            v-for="data in subStatus"
                            v-bind:key="data.id"
                            :value="data.id"
                        >
                            {{ data.sub_status_name }}
                        </option>
                    </select>
                </div>
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="source">Source</label>
                <ValidationProvider :rules="{ required: false }" v-slot="v">
                  <input
                    type="text"
                    name="source"
                    class="form-control"
                    v-model="applicant.source"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>

                <div class="invalid-feedback">
                  This field requires a valid email address.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="position">Position</label>
                <ValidationProvider :rules="{ required: true }" v-slot="v">
                  <select
                    class="form-control selectpicker"
                    name="position"
                    :disabled="!edit"
                    v-model="applicant.position"
                  >
                    <option class="optionpicker" value="Healthcare Assistant">
                      Healthcare Assistant
                    </option>
                    <option
                      class="optionpicker"
                      value="Senior Healthcare Assistant"
                    >
                      Senior Healthcare Assistant
                    </option>
                    <option class="optionpicker" value="RGN">RGN</option>
                    <option class="optionpicker" value="RMN">RMN</option>
                    <option class="optionpicker" value="Support Worker">
                      Support Worker
                    </option>
                  </select>
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
                <div class="invalid-feedback">
                  This field is required and must contain only letters.
                </div>
              </div>
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="first_name">First Name</label>
                <ValidationProvider :rules="{ required: true }" v-slot="v">
                  <input
                    type="text"
                    name="first_name"
                    class="form-control"
                    v-model="applicant.first_name"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
                <div class="invalid-feedback">
                  This field is required and must contain only letters.
                </div>
              </div>
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="last_name">Last Name</label>
                <ValidationProvider :rules="{ required: true }" v-slot="v">
                  <input
                    type="text"
                    name="last_name"
                    class="form-control"
                    v-model="applicant.last_name"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
                <div class="invalid-feedback">
                  This field is required and must contain only letters.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="email">Email</label>
                <ValidationProvider :rules="{ email: true }" v-slot="v">
                  <input
                    type="text"
                    name="email"
                    class="form-control"
                    v-model="applicant.email"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
                <div class="invalid-feedback">
                  This field requires a valid email address.
                </div>
              </div>
              <div class="col-lg-3 col-sm-12 form-group">
                <label for="telephone">Landline</label>
                <ValidationProvider
                  :rules="{ min: 9, max: 12, numeric: true }"
                  v-slot="v"
                >
                  <input
                    type="tel"
                    name="Telephone"
                    class="form-control"
                    v-model="applicant.landline"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="col-lg-3 col-sm-12 form-group">
                <label for="telephone">Mobile</label>
                <ValidationProvider
                  :rules="{ min: 9, max: 12, numeric: true }"
                  v-slot="v"
                >
                  <input
                    type="tel"
                    name="Mobile"
                    class="form-control"
                    v-model="applicant.mobile"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="experience">Six months of experience (Paid)</label>
                <select
                  name="experience"
                  class="form-control"
                  v-model="applicant.experience"
                  :disabled="!edit"
                >
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="shifts">Weekly shifts No.</label>
                <select
                  name="shifts"
                  class="form-control"
                  v-model="applicant.shifts"
                  :disabled="!edit"
                >
                  <option value="1">1 or less</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                </select>
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 form-group">
                <label for="telephone">Declaration</label>
                <ValidationProvider v-slot="v">
                  <input
                    type="tel"
                    name="Declaration"
                    class="form-control"
                    v-model="applicant.declaration"
                    :disabled="!edit"
                  />
                  <span class="text-danger">{{ v.errors[0] }}</span>
                </ValidationProvider>
              </div>
            </div>
              <div class="row">
                  <div class="col-12 form-group">
                      <label for="telephone">Resume</label>
                          <input  id="file" class="form-control" type="file" ref="file" enctype="multipart/form-data" @change="handleFileObject()" :disabled="!edit"/>
                  </div>
                  <div v-if="applicant.resume_url" class="row">
                      <div  class="col-12 form-group">
                          <a :href="'/' + applicant.resume_url" target="_blank" class="mb-2">
                              <i class="fas fa-file-download fa-xl mr-2 mb-3" onclick="myFunction()"></i> Resume
                          </a>
                      </div>
                  </div>
                  <div v-else class="row">
                      <div class="col-11">
                          <i class="fas fa-file-download fa-xl mr-2 mb-3" ></i> Upload Resume
                      </div>
                  </div>
              </div>
              </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-10 my-auto">
                <span class="h6">Address Details</span>
              </div>
              <div class="col-2 my-auto">
                <div v-show="show.address == false">
                  <button
                    class="btn btn-md float-right"
                    @click="show.address = true"
                  >
                    <i class="fas fa-plus"></i> Expand
                  </button>
                </div>
                <div v-show="show.address == true">
                  <button
                    class="btn btn-md float-right"
                    @click="show.address = false"
                  >
                    <i class="fas fa-minus"></i> Minimise
                  </button>
                </div>
              </div>
            </div>
            <hr />
            <div class="row" v-show="show.address == true">
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="address_1">Address 1</label>
                <input
                  type="text"
                  name="address-1"
                  class="form-control"
                  v-model="applicant.address_line_1"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 form-group">
                <label for="address_1">Address 2</label>
                <input
                  type="text"
                  name="address-2"
                  class="form-control"
                  v-model="applicant.address_line_2"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
            </div>
            <div class="row" v-show="show.address == true">
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="address_2">City</label>
                <input
                  type="text"
                  name="city"
                  class="form-control"
                  v-model="applicant.city"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters.
                </div>
              </div>
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="county">County</label>
                <input
                  type="text"
                  name="county"
                  class="form-control"
                  v-model="applicant.county"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters.
                </div>
              </div>
              <div class="col-lg-4 col-sm-12 form-group">
                <label for="postcode">Postcode</label>
                <input
                  type="text"
                  name="postcode"
                  class="form-control"
                  v-model="applicant.postcode"
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

    <div class="row">
      <div class="col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-10 my-auto">
                <span class="h6">Other</span>
              </div>
              <div class="col-2 my-auto">
                <div v-show="show.other == false">
                  <button
                    class="btn btn-md float-right"
                    @click="show.other = true"
                  >
                    <i class="fas fa-plus"></i> Expand
                  </button>
                </div>
                <div v-show="show.other == true">
                  <button
                    class="btn btn-md float-right"
                    @click="show.other = false"
                  >
                    <i class="fas fa-minus"></i> Minimise
                  </button>
                </div>
              </div>
            </div>
            <hr />
            <div class="row" v-show="show.other == true">
              <div class="col-lg-3 col-sm-12 form-group">
                <label for="postcode">NiN</label>
                <input
                  type="text"
                  name="NiN"
                  class="form-control"
                  v-model="applicant.national_insurance_number"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-3 col-sm-12 form-group">
                <label for="postcode">Nurse pin</label>
                <input
                  type="text"
                  name="nurse_pin"
                  class="form-control"
                  v-model="applicant.nurse_pin_number"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-3 col-sm-12 form-group">
                <label for="postcode">Right to work</label>
                <input
                  type="text"
                  name="Right_to_work"
                  class="form-control"
                  v-model="applicant.right_to_work"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-3 col-sm-12 form-group">
                <label for="name">Drivers License</label>
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  v-model="applicant.drivers_licence"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-10 my-auto">
                <span class="h6">Skill & Qualifications</span>
              </div>
              <div class="col-2 my-auto">
                <div v-show="show.skills == false">
                  <button
                    class="btn btn-md float-right"
                    @click="show.skills = true"
                  >
                    <i class="fas fa-plus"></i> Expand
                  </button>
                </div>
                <div v-show="show.skills == true">
                  <button
                    class="btn btn-md float-right"
                    @click="show.skills = false"
                  >
                    <i class="fas fa-minus"></i> Minimise
                  </button>
                </div>
              </div>
            </div>
            <hr />
            <div class="row" v-show="show.skills == true">
              <div class="col-lg-12 form-group">
                <label for="skills">Skills</label>
                <textarea
                  type="text"
                  name="skills"
                  class="form-control"
                  v-model="applicant.skills"
                  rows="5"
                  :disabled="!edit"
                ></textarea>
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
            </div>
            <div class="row" v-show="show.skills == true">
              <div class="col-lg-12 form-group">
                <label for="qualifications">Qualifications</label>
                <textarea
                  type="text"
                  name="qualifications"
                  class="form-control"
                  v-model="applicant.qualifications"
                  rows="5"
                  :disabled="!edit"
                ></textarea>
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
            </div>
            <div class="row" v-show="show.skills == true">
              <div class="col-lg-12 form-group">
                <label for="skills">Relevant skills</label>
                <textarea
                  type="text"
                  name="skills"
                  class="form-control"
                  v-model="applicant.relevant_skills"
                  rows="5"
                  :disabled="!edit"
                ></textarea>
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

    <div class="row">
      <div class="col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-10 my-auto">
                <span class="h6">Health & Offender Information</span>
              </div>
              <div class="col-2 my-auto">
                <div v-show="show.health == false">
                  <button
                    class="btn btn-md float-right"
                    @click="show.health = true"
                  >
                    <i class="fas fa-plus"></i> Expand
                  </button>
                </div>
                <div v-show="show.health == true">
                  <button
                    class="btn btn-md float-right"
                    @click="show.health = false"
                  >
                    <i class="fas fa-minus"></i> Minimise
                  </button>
                </div>
              </div>
            </div>
            <hr />
            <div class="row" v-show="show.health == true">
              <div class="col-lg-2 col-sm-12 form-group">
                <label for="health">Good health?</label>
                <input
                  type="text"
                  name="good_health"
                  class="form-control"
                  v-model="applicant.in_good_health"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-10 col-sm-12 form-group">
                <label for="health_info">Details</label>
                <textarea
                  type="text"
                  name="good_health"
                  class="form-control"
                  v-model="applicant.good_health_information"
                  rows="5"
                  :disabled="!edit"
                ></textarea>
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
            </div>
            <div class="row" v-show="show.health == true">
              <div class="col-lg-2 col-sm-12 form-group">
                <label for="offender">Offences?</label>
                <input
                  type="text"
                  name="good_health"
                  class="form-control"
                  v-model="applicant.offender"
                  rows="5"
                  :disabled="!edit"
                />
                <div class="invalid-feedback">
                  This field is required and must contain only letters &
                  numbers.
                </div>
              </div>
              <div class="col-lg-10 col-sm-12 form-group">
                <label for="offence_details">Details</label>
                <textarea
                  type="text"
                  name="good_health"
                  class="form-control"
                  v-model="applicant.offender_information"
                  rows="5"
                  :disabled="!edit"
                ></textarea>
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
</template>
<script>
export default {
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },

    employment: function () {
      return this.$parent.employment;
    },
  },

  data: function () {
    return {
      routePrefix: "/api/recruitment/applications/",
      newApplicant: {},
      branches: {},
      subStatus:{},
        upload: null,
      show: {
        address: false,
        other: false,
        skills: false,
        health: false,
      },
      edit: false,
      disabled: false,
        file: null,
    };
  },
  mounted() {
    this.getBranches();
  },

    watch:{
        'applicant.status': function(value){
            console.log(this.applicant.status);
            axios.get("/api/recruitment/applications/sub_status/" + this.applicant.status ).then((response)=>{
                this.subStatus = response.data;

            })

        }

    },

    methods: {
    update(applicant) {
      this.disabled = true;
      let file_data = this.file;
      console.log(this.applicant);
        let formData = new FormData();
        formData.append('file', file_data);
        formData.append('position', this.applicant.position);
        formData.append('first_name', this.applicant.first_name);
        formData.append('last_name', this.applicant.last_name);
        formData.append('email', this.applicant.email);
        formData.append('address_line_1', this.applicant.address_line_1);
        formData.append('address_line_2', this.applicant.address_line_2);
        formData.append('city', this.applicant.city);
        formData.append('county', this.applicant.county);
        formData.append('postcode', this.applicant.postcode);
        formData.append('mobile', this.applicant.mobile);
        formData.append('landline', this.applicant.landline);
        formData.append('national_insurance_number', this.applicant.national_insurance_number);
        formData.append('nurse_pin_number', this.applicant.nurse_pin_number);
        formData.append('right_to_work', this.applicant.right_to_work);
        formData.append('qualifications', this.applicant.qualifications);
        formData.append('most_recent_work', file_data);
        formData.append('relevant_skills', this.applicant.relevant_skills);
        formData.append('drivers_license', this.applicant.drivers_licence);
        formData.append('in_good_health', this.applicant.in_good_health);
        formData.append('good_health_information', this.applicant.good_health_information);
        formData.append('offender', this.applicant.offender);
        formData.append('offender_information', this.applicant.offender_information);
        formData.append('status', this.applicant.status);
        formData.append('source', this.applicant.source);
        formData.append('branch_id', this.applicant.branch_id);
        formData.append('hired', this.applicant.hired);
        formData.append('declaration', this.applicant.declaration);
        formData.append('skills', this.applicant.relevant_skills);
        formData.append('shifts', this.applicant.shifts);
        formData.append('experience', this.applicant.experience);
        formData.append('sub_status', this.applicant.sub_status);

      axios
        .post(this.routePrefix + this.applicant.id, formData)
        .then((response) => {
          this.edit = false;
          this.disabled = false;
          this.$parent.showApplication();
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then((response) => {
          this.disabled = false;
        });
    },
    getBranches() {
      axios.get("/api/management/staff/branches/").then((response) => {
        this.branches = response.data;
      });

    },
        handleFileObject() {
            this.file = this.$refs.file.files[0]
        },




    },
};
</script>
<style scoped>
textarea {
  resize: both;
  overflow: auto;
}
::placeholder {
  /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #ffffff;
  opacity: 1; /* Firefox */
}
.accepted {
  background-color: #82b54b;
  opacity: 1;
  color: #ffffff;
}
.rejected {
  background-color: #e04f1a;
  opacity: 1;
  color: #ffffff;
}
.inexperienced {
  background-color: #154191;
  opacity: 1;
  color: #ffffff;
}
.archived {
  background-color: #3c90df;
  opacity: 1;
  color: #ffffff;
}
.notYet {
  background-color: #e1b65a;
  opacity: 1;
  color: #ffffff;
}
.no_show {
  background-color: #e04f1a;
  opacity: 1;
  color: #ffffff;
}
</style>
