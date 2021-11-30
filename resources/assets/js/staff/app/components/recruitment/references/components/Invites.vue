<template>
  <div>
    <div class="row mt-3 mb-4">
      <div class="col">
        <div class="block-title">
          <span class="font-w700">Referees</span>
        </div>
      </div>
      <div class="col-auto" v-if="applicant.contact_referee == 1">
        <button
          type="button"
          class="btn btn-success btn-sm mx-1"
          data-original-title="View"
          :disabled="true"
        >
          <i class="fas fa-check pr-2"></i>Consent to contact referees
          autherised referees
        </button>
      </div>
      <div class="col-auto" v-else>
        <button
          type="button"
          class="btn btn-danger btn-sm mx-1"
          data-original-title="View"
          :disabled="true"
        >
          <i class="fas fa-times pr-2"></i>Consent to contact referees denied
        </button>
      </div>
      <div class="col-auto">
        <button
          type="button"
          class="btn btn-secondary btn-sm mx-1"
          v-on:click="newRequest = true"
        >
          <i class="fas fa-plus pr-1"></i> New Request
        </button>
      </div>
    </div>
    <div
      class="
        js-wizard-simple
        block block-rounded
        js-appear-enabled
        animated
        fadeIn
      "
      v-if="applicant.referees"
    >
      <div class="block-content block-content-full tab-content">
        <label>Applicant Referees</label>
        <div class="h5">{{ applicant.referees }}</div>
      </div>
    </div>
    <div v-if="newRequest">
      <div
        class="
          js-wizard-simple
          block block-rounded
          js-appear-enabled
          animated
          fadeIn
          mt-4
        "
      >
        <div class="block-content block-content-full tab-content">
          <ValidationObserver v-slot="{ handleSubmit }" :key="1">
            <form
              class="interview-request-form"
              @submit.prevent="handleSubmit(store)"
              method="post"
            >
              <div class="row">
                <div class="col-md-8 my-auto">
                  <span class="h6">New Referee</span>
                </div>
                <div class="col-md-4 my-auto">
                  <button
                    class="btn btn-success float-right"
                    type="submit"
                    name="button"
                  >
                    <i class="fa fa-paper-plane mr-1"></i> Send Request
                  </button>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-lg-3 col-xs-12">
                  <div class="input-group mt-2 mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        Name
                      </span>
                    </div>
                    <input
                      type="text"
                      name="referee_name"
                      class="form-control"
                      v-model="request.name"
                    />
                  </div>
                </div>
                <div class="col-lg-3 col-xs-12">
                  <div class="input-group mt-2 mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        Email
                      </span>
                    </div>
                    <input
                      type="text"
                      name="referee_email"
                      class="form-control"
                      v-model="request.email"
                    />
                  </div>
                </div>
                <div class="col-lg-3 col-xs-12">
                  <div class="input-group mt-2 mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        Mobile
                      </span>
                    </div>
                    <input
                      type="text"
                      name="referee_mobile"
                      class="form-control"
                      v-model="request.mobile"
                    />
                  </div>
                </div>
                <div class="col-lg-3 col-xs-12">
                  <div class="input-group mt-2 mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        Type
                      </span>
                    </div>
                    <select
                      name="Type"
                      class="form-control"
                      v-model="request.type"
                    >
                      <option value="1">Professional</option>
                      <option value="2">Personal</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
    <div
      class="
        js-wizard-simple
        block block-rounded
        js-appear-enabled
        animated
        fadeIn
        mt-4
      "
      v-for="(referee, key) in referees"
      :key="key"
    >
      <div class="block-content block-content-full tab-content">
        <div class="row">
          <div class="col-md-4 my-auto">
            <span class="h6">Referee Details</span>
          </div>
          <div class="col-md-4 my-auto">
            <div
              v-bind:class="{
                limit: referee.reminder_count == 5,
                remaining: referee.reminder_count < 5,
              }"
            >
              <b>Reminder Count: {{ referee.reminder_count }}</b>
            </div>
          </div>
          <div class="col-md-4 my-auto">
            <div class="col-auto my-auto float-right">
              <b-dropdown
                id="action"
                variant="primary"
                text="Reference Actions"
              >
                <b-dropdown-item
                  v-if="(referee.status == null) & (referee.status != 2)"
                >
                  <button
                    class="btn btn-success btn-xs"
                    type="submit"
                    data-original-title="View"
                    v-on:click="requestReference(referee.id)"
                    :disabled="disabled"
                  >
                    <i class="fa fa-paper-plane mr-1"></i>
                    Request
                  </button>
                </b-dropdown-item>
                <b-dropdown-item v-if="referee.status == 1">
                  <button
                    class="btn btn-info btn-xs"
                    type="submit"
                    data-original-title="View"
                    v-on:click="remindReference(referee.id)"
                    :disabled="disabled"
                  >
                    <i class="fa fa-paper-plane mr-1"></i>
                    Remind
                  </button>
                </b-dropdown-item>
                <b-dropdown-item v-if="referee.status > 0">
                  <button
                    type="button"
                    class="btn btn-secondary btn-xs"
                    data-original-title="View"
                    v-on:click="edit = referee.id"
                    v-if="edit != referee.id"
                  >
                    <i class="fa fa-edit mr-1"></i> Edit
                  </button>
                  <button
                    type="button"
                    class="btn btn-success btn-xs"
                    data-original-title="View"
                    v-on:click="update(referee)"
                    v-if="edit == referee.id"
                  >
                    <i class="fa fa-check mr-1"></i> Save
                  </button>
                </b-dropdown-item>
                <b-dropdown-item>
                  <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    data-original-title="View"
                    v-on:click="destroyReference(referee.id)"
                    :disabled="disabled"
                  >
                    <i class="fa fa-trash"></i> Delete
                  </button>
                </b-dropdown-item>
              </b-dropdown>
            </div>
          </div>
        </div>
        <hr />
        <div>
          <div class="row mb-3">
            <div class="col-12 col-xs-12">
              <div class="row mb-3">
                <div class="col-md col-xs-12">
                  <button
                    v-if="referee.manually == 1"
                    class="btn btn-info btn-sm"
                    :disabled="true"
                  >
                    <i class="fas fa-info-circle"></i>
                    Manually inputted
                  </button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <label>Name</label>
                  <div class="h5">{{ referee.name }}</div>
                </div>
                <div class="col-md-5 col-xs-12">
                  <label>Email</label>
                  <div class="h5">{{ referee.email }}</div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <label>Mobile</label>
                  <div class="h5">{{ referee.mobile }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <label>Type</label>
                  <div v-if="referee.type == 1" class="h5">Professional</div>
                  <div v-else class="h5">Personal</div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <label>Status</label>
                  <div v-if="referee.status == null" class="h5">
                    Not Requested
                  </div>
                  <div v-if="referee.status == 1" class="h5">
                    Awaiting Response
                  </div>
                  <div v-if="referee.status == 2" class="h5">Completed</div>
                  <div v-if="referee.status == 3" class="h5">Declined</div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="referee.type == 1">
            <div v-if="edit == false">
              <div v-if="referee.status == 2">
                <hr />
                <div class="row mb-1 mt-4">
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Occupation</label>
                    <div class="h5">{{ referee.occupation }}</div>
                  </div>
                  <div
                    class="col-lg col-md-6 col-xs-12"
                    v-if="referee.safeguard_check == 1"
                  >
                    <label>Safeguarding issues</label>
                    <div class="h5">YES</div>
                  </div>
                  <div
                    class="col-lg col-md-6 col-xs-12"
                    v-if="referee.safeguard_check == 2"
                  >
                    <label>Safeguarding issues</label>
                    <div class="h5">NO</div>
                  </div>
                  <div
                    class="col-lg col-md-6 col-xs-12"
                    v-if="referee.employed_to == null"
                  >
                    <label>Employment Dates:</label>
                    <div class="h5">
                      {{ referee.employed_from | date }} - Present
                    </div>
                  </div>
                  <div class="col-lg col-md-6 col-xs-12" v-else>
                    <label>Employment Dates:</label>
                    <div class="h5">
                      {{ referee.employed_from | date }} -
                      {{ referee.employed_to | date }}
                    </div>
                  </div>
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Completed at</label>
                    <div class="h5">{{ referee.completed_at }}</div>
                  </div>
                </div>
                <div class="row" v-if="referee.staff_note != null">
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Staff notes</label>
                    <div class="h5">{{ referee.staff_note }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div v-else>
              <div class="row mb-1 mt-4">
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Occupation</label>
                  <input
                    class="form-control h5"
                    v-model="referee.occupation"
                    :disabled="edit !== referee.id"
                  />
                </div>
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Safeguarding issues</label>
                  <select
                    class="optionpicker form-control"
                    v-model="referee.safeguard_check"
                    :disabled="edit !== referee.id"
                  >
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                  </select>
                </div>
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Employment Start:</label>
                  <input
                    type="date"
                    class="form-control h5"
                    v-model="referee.employed_from"
                    :disabled="edit !== referee.id"
                  />
                </div>
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Employment End:</label>
                  <input
                    type="date"
                    class="form-control h5"
                    v-model="referee.employed_to"
                    :disabled="edit !== referee.id"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Notes</label>
                  <input
                    class="form-control h5"
                    v-model="referee.note"
                    :disabled="edit !== referee.id"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Staff Notes</label>
                  <input
                    class="form-control h5"
                    v-model="referee.staff_note"
                    :disabled="edit !== referee.id"
                  />
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12 my-auto ml-auto">
                  <input
                    type="checkbox"
                    id="exampleCheck1"
                    v-model="referee.manually"
                    :disabled="edit !== referee.id"
                  />
                  <label class="form-check-label" for="exampleCheck1"
                    >Please check if these details have been manually
                    inputted</label
                  >
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div v-if="edit == false">
              <div v-if="referee.status == 2">
                <hr />
                <div class="row mb-1 mt-4">
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Occupation</label>
                    <div class="h5">{{ referee.occupation }}</div>
                  </div>
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Known for</label>
                    <div class="h5">{{ referee.known_since }}</div>
                  </div>
                  <div
                    class="col-lg col-md-6 col-xs-12"
                    v-if="referee.related == 1"
                  >
                    <label>Related?</label>
                    <div class="h5">YES</div>
                  </div>
                  <div
                    class="col-lg col-md-6 col-xs-12"
                    v-if="referee.related == 2"
                  >
                    <label>Related?</label>
                    <div class="h5">NO</div>
                  </div>
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Capacity</label>
                    <div class="h5">{{ referee.capacity }}</div>
                  </div>
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Completed at</label>
                    <div class="h5">{{ referee.completed_at }}</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Applicant suitability</label>
                    <div class="h5">{{ referee.note }}</div>
                  </div>
                </div>
                <div class="row" v-if="referee.staff_note != null">
                  <div class="col-lg col-md-6 col-xs-12">
                    <label>Staff notes</label>
                    <div class="h5">{{ referee.staff_note }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div v-else>
              <div class="row mb-1 mt-4">
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Occupation</label>
                  <input
                    class="form-control h5"
                    v-model="referee.occupation"
                    :disabled="edit !== referee.id"
                  />
                </div>
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Known for</label>
                  <input
                    class="form-control h5"
                    v-model="referee.known_since"
                    :disabled="edit !== referee.id"
                  />
                </div>
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Related</label>
                  <select
                    class="optionpicker form-control"
                    v-model="referee.related"
                    :disabled="edit !== referee.id"
                  >
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                  </select>
                </div>
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Capacity</label>
                  <input
                    class="form-control h5"
                    v-model="referee.capacity"
                    :disabled="edit !== referee.id"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Applicant suitability</label>
                  <input
                    class="form-control h5"
                    v-model="referee.note"
                    :disabled="edit !== referee.id"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg col-md-6 col-xs-12">
                  <label>Staff Notes</label>
                  <input
                    class="form-control h5"
                    v-model="referee.staff_note"
                    :disabled="edit !== referee.id"
                  />
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12 my-auto ml-auto">
                  <input
                    type="checkbox"
                    id="exampleCheck1"
                    v-model="referee.manually"
                    :disabled="edit !== referee.id"
                  />
                  <label class="form-check-label"
                    >Please check if these details have been manually
                    inputted</label
                  >
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
      return this.$parent.applicant || { referees: false };
    },
    refereesLength: function () {
      return _.size(this.referees);
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/references/",
      edit: false,
      success: false,
      disabled: false,
      request: {},
      referees: {},
      newRequest: false,
    };
  },
  mounted() {
    this.show();
  },
  methods: {
    show() {
      axios.get(this.routePrefix + this.$route.params.id).then((response) => {
        this.referees = response.data;
      });
    },
    store() {
      axios
        .post(this.routePrefix + this.applicant.id, this.request)
        .then((response) => {
          this.newRequest = false;
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.message = "Oops, an error occurred!";
        })
        .then(() => {
          this.show();
        });
    },
    update(referee) {
      this.edit = false;
      axios
        .patch(this.routePrefix + "update/" + referee.id, referee)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.show();
        });
    },
    destroyReference(id) {
      axios
        .delete(this.routePrefix + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.show();
        });
    },
    requestReference(id) {
      axios
        .patch(this.routePrefix + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.show();
        });
    },
    remindReference(id) {
      axios
        .put(this.routePrefix + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.show();
        });
    },
  },
};
</script>
<style scoped>
.btn-xs,
.btn-group-sm > .btn {
  width: 150px !important;
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  line-height: 1.5;
  border-radius: 0.2rem;
}
.limit {
  color: #e04f1a;
  font-weight: 900;
  text-decoration: underline;
}
.remaining {
  color: #82b54b;
  font-weight: 900;
  text-decoration: underline;
}
</style>