<template>
  <div class="mt-4">
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
        <form class="interview-request-form">
          <div class="row">
            <div class="col-12 my-auto">
              <span class="h6">Contact Details</span>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-md my-auto">
              <label>Email</label>
              <div class="h5">{{ applicant.email }}</div>
            </div>
            <div class="col-md my-auto">
              <label>Mobile</label>
              <div class="h5">{{ applicant.mobile }}</div>
            </div>
            <div
              class="col-md-auto my-auto"
              v-show="applicant.declaration == null"
            >
              <button
                class="btn btn-info float-right"
                type="button"
                name="button"
                @click="updateContacted(applicant)"
              >
                <i class="fas fa-phone mr-1"></i> Phoned
              </button>
            </div>
            <div class="col-md-auto my-auto">
              <button
                class="btn btn-success float-right"
                type="button"
                name="button"
                @click="store"
              >
                <i class="fas fa-paper-plane mr-1"></i> Arrange Interview
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div v-if="invites.length">
      <div class="row">
        <div class="col">
          <div class="block-title mb-2">
            <span class="font-w700">Interviews</span>
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
        "
        v-for="(invite, key) in invites"
        :key="key"
      >
        <div class="block-content block-content-full tab-content">
          <div class="row">
            <div class="col-md-auto col-12 my-auto">
              <span class="h6">Details</span>
            </div>
            <div class="col-md-auto col-12 my-auto ml-auto">
              <button
                class="btn btn-info"
                type="button"
                data-original-title="View"
                v-on:click="remind(invite.id)"
                v-if="invite.status == 1"
                :disabled="disabled"
              >
                <i class="fa fa-paper-plane mr-1"></i>
                Reminder
              </button>
              <b-dropdown
                id="action"
                variant="primary"
                text="Interview Actions"
              >
                <b-dropdown-item v-if="invite.status == 0">
                  <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    data-original-title="View"
                    v-on:click="edit = invite.id"
                    v-if="edit != invite.id"
                  >
                    <i class="fas fa-calendar-alt mr-1"></i> Book Interview
                  </button>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    data-original-title="View"
                    v-on:click="update(invite)"
                    v-if="edit == invite.id"
                  >
                    <i class="fas fa-send mr-1"></i>
                    Send Slot
                  </button>
                </b-dropdown-item>
                <b-dropdown-item v-else>
                  <button
                    type="button"
                    class="btn btn-secondary btn-sm"
                    data-original-title="View"
                    v-on:click="edit = invite.id"
                    v-if="edit != invite.id"
                  >
                    <i class="fa fa-edit mr-1"></i> Edit
                  </button>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    data-original-title="View"
                    v-on:click="reschedule(invite)"
                    v-if="edit == invite.id"
                  >
                    <i class="fa fa-check mr-1"></i> Save
                  </button>
                </b-dropdown-item>
                <b-dropdown-item>
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    data-original-title="View"
                    v-on:click="destroy(invite.id)"
                    :disabled="disabled"
                  >
                    <i class="fa fa-trash mr-1"></i> Cancel
                  </button>
                </b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item v-if="invite.status == 1">
                  <button
                    class="btn btn-success btn-sm"
                    type="button"
                    name="button"
                    @click="successful(invite)"
                  >
                    <i class="fa fa-check mr-1"></i>Successful
                  </button>
                </b-dropdown-item>
                <b-dropdown-item v-if="invite.status == 1">
                  <button
                    class="btn btn-danger btn-sm"
                    type="button"
                    name="button"
                    @click="reject(invite)"
                  >
                    <i class="fa fa-times mr-1"></i>Unsuccessful
                  </button>
                </b-dropdown-item>
                <b-dropdown-item v-if="invite.status == 1">
                  <button
                    class="btn btn-info btn-sm"
                    type="button"
                    name="button"
                    @click="noShow(invite)"
                  >
                    <i class="fa fa-times mr-1"></i>No Show
                  </button>
                </b-dropdown-item>
              </b-dropdown>
            </div>
          </div>
          <hr />
          <div v-if="invite.status == 0 || invite.status == 1">
            <div class="row">
              <div class="col">
                <div class="row">
                  <div class="col-md">
                    <label>Status</label>
                    <div
                      class="h5"
                      v-bind:class="{
                        awaiting: invite.status == '0',
                        planned: invite.status == '1',
                        successful: invite.status == '3',
                        unsuccessful: invite.status == '4',
                        noShow: invite.status == '5',
                      }"
                    >
                      {{ status[invite.status] }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4">
                    <label>Scheduled Date</label>
                    <input
                      type="date"
                      name="date"
                      :min="todaysDate"
                      class="form-control"
                      v-model="invite.date"
                      :disabled="edit !== invite.id"
                    />
                  </div>
                  <div class="col-12 col-md-4">
                    <label>Scheduled Time</label>
                    <input
                      type="time"
                      name="time"
                      class="form-control"
                      v-model="invite.time"
                      :disabled="edit !== invite.id"
                    />
                  </div>
                  <div class="col-12 col-md-4">
                    <label>Interview Host</label>
                    <select
                      class="form-control selectpicker"
                      v-model="invite.staff_id"
                      required
                      :disabled="edit !== invite.id"
                    >
                      <option value selected disabled>Assign Staff</option>
                      <option
                        class="optionpicker"
                        v-for="(staff, key) in staff"
                        v-bind:key="key"
                        :value="staff.id"
                      >
                        {{ staff.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="row">
              <div class="col">
                <div class="row">
                  <div class="col-md">
                    <label>Status</label>
                    <div
                      class="h5"
                      v-bind:class="{
                        awaiting: invite.status == '0',
                        planned: invite.status == '1',
                        successful: invite.status == '3',
                        unsuccessful: invite.status == '4',
                        noShow: invite.status == '5',
                      }"
                    >
                      {{ status[invite.status] }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4">
                    <label>Completion Date</label>
                    <input
                      type="date"
                      name="date"
                      :min="todaysDate"
                      class="form-control"
                      v-model="invite.date"
                      :disabled="edit !== invite.id"
                    />
                  </div>
                  <div class="col-12 col-md-4">
                    <label>Completion Time</label>
                    <input
                      type="time"
                      name="time"
                      class="form-control"
                      v-model="invite.time"
                      :disabled="edit !== invite.id"
                    />
                  </div>
                  <div class="col-12 col-md-4">
                    <label>Interview Host</label>
                    <select
                      class="form-control selectpicker"
                      v-model="invite.staff_id"
                      required
                      :disabled="edit !== invite.id"
                    >
                      <option value selected disabled>Assign Staff</option>
                      <option
                        class="optionpicker"
                        v-for="(staff, key) in staff"
                        v-bind:key="key"
                        :value="staff.id"
                      >
                        {{ staff.name }}
                      </option>
                    </select>
                  </div>
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
import moment from "moment";
import Datepicker from "vuejs-datepicker";
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";

export default {
  components: {
    Datepicker,
    VueTimepicker,
  },
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },
    user: function () {
      return this.$store.state.user;
    },
    todaysDate: function () {
      return moment().format("YYYY-MM-DD");
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/interviews/",
      edit: false,
      success: false,
      disabled: false,
      invites: {},
      staff: {},
      sms: {
        message: "",
        mobile: "",
      },
      status: [
        "Awaiting",
        "Planned",
        "Completed",
        "Successful",
        "Rejected",
        "No Show",
      ],
    };
  },
  mounted() {
    this.show();
    this.getStaff();
  },
  methods: {
    getStaff() {
      axios.get(this.routePrefix + "all").then((response) => {
        this.staff = response.data;
      });
    },
    store() {
      axios
        .post(
          this.routePrefix + this.applicant.id,
          this.applicant,
          this.invites
        )
        .then((response) => {
          this.success = true;
        })
        .catch((error) => {
          this.message = "Oops, an error occurred!";
        })
        .then(() => {
          this.show();
        });
    },
    show() {
      axios.get(this.routePrefix + this.$route.params.id).then((response) => {
        this.invites = response.data;
      });
    },
    reschedule(invite) {
      this.edit = false;
      axios
        .patch(this.routePrefix + "update/" + invite.id, invite)
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

    update(invite) {
      this.edit = false;
      axios
        .patch(this.routePrefix + invite.id, invite)
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
    completed(invite) {
      axios
        .patch(this.routePrefix + "complete/" + invite.id, invite)
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
    destroy(id) {
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
    remind(id) {
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
    // successful(invite) {
    //   axios
    //     .patch(this.routePrefix + "success/" + invite.id, invite)
    //     .then(response => {
    //       this.$root.notification(response.data.message, "success");
    //     })
    //     .catch(error => {
    //       this.$root.notification(error.response.data.message, "error");
    //     })
    //     .then(() => {
    //       this.show();
    //     });
    // },
    // reject(invite) {
    //   axios
    //     .patch(this.routePrefix + "reject/" + invite.id, invite)
    //     .then(response => {
    //       this.$root.notification(response.data.message, "success");
    //     })
    //     .catch(error => {
    //       this.$root.notification(error.response.data.message, "error");
    //     })
    //     .then(() => {
    //       this.show();
    //     });
    // },
    // noShow(invite) {
    //   axios
    //     .patch(this.routePrefix + "no-show/" + invite.id, invite)
    //     .then(response => {
    //       this.$root.notification(response.data.message, "success");
    //     })
    //     .catch(error => {
    //       this.$root.notification(error.response.data.message, "error");
    //     })
    //     .then(() => {
    //       this.show();
    //     });
    // },
    updateContacted(applicant) {
      axios
        .patch(this.routePrefix + "contacted/" + applicant.id, applicant)
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

<style scoped>
.btn-sm,
.btn-group-sm > .btn {
  width: 150px !important;
}
.awaiting {
  color: orange;
}
.planned {
  color: #3c90df;
}
.successful {
  color: #82b54b;
}
.unsuccessful,
.noShow {
  color: #e04f1a;
}
</style>
