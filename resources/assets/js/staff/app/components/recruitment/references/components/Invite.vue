<template>
  <div>
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
          <div class="col-md-6 col-12 my-auto">
            <h4 class="mb-0">Invite</h4>
          </div>
          <div class="col-md-6 col-12 my-auto ml-auto">
            <div
              class="float-right"
              :class="{
                limit: invite.reminder_count == 5,
                remaining: invite.reminder_count < 5,
              }"
            >
              <b>Reminder Count: {{ invite.reminder_count }}</b>
            </div>
          </div>
        </div>
        <hr />
        <div class="row pb-3" id="actionsbar">
          <div class="col-md-3 col-12">
            <button
              class="btn btn-success btn-md w-100"
              @click="request(invite)"
            >
              <i class="fa fa-paper-plane pr-2"></i>
              Request
            </button>
          </div>
          <div class="col-md-3 col-12">
            <button
              class="btn btn-primary btn-md w-100"
              @click="remind(invite)"
            >
              <i class="fa fa-paper-plane pr-2"></i>
              Reminder
            </button>
          </div>
          <div class="col-md-3 col-12">
            <button
              class="btn btn-secondary btn-md w-100"
              v-show="editInvite != invite.id"
              @click="editInvite = invite.id"
            >
              <i class="fa fa-edit pr-2"></i>Edit
            </button>
            <button
              class="btn btn-success btn-md w-100"
              v-show="editInvite == invite.id"
              @click="update(invite)"
            >
              <i class="fa fa-save pr-2"></i>Save
            </button>
          </div>
          <div class="col-md-3 col-12">
            <button
              class="btn btn-danger btn-md w-100"
              @click="destroy(invite.id)"
            >
              <i class="fa fa-trash pr-2"></i>Delete
            </button>
          </div>
        </div>

        <div v-if="editInvite == false">
          <div class="row" id="invitedetails">
            <div class="col-md-4 col-12">
              <label>Name</label>
              <div class="h5">{{ invite.name }}</div>
            </div>
            <div class="col-md-4 col-12">
              <label>Email</label>
              <div class="h5">{{ invite.email }}</div>
            </div>
            <div class="col-md-4 col-12">
              <label>Mobile</label>
              <div class="h5">{{ invite.mobile }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-12">
              <label>Type</label>
              <div v-if="invite.type == 1" class="h5">Professional</div>
              <div v-else class="h5">Personal</div>
            </div>
            <div class="col-md-4 col-12">
              <label>Status</label>
              <div v-if="invite.status == null" class="h5">Not Requested</div>
              <div v-if="invite.status == 1" class="h5">Awaiting Response</div>
              <div v-if="invite.status == 2" class="h5">Completed</div>
              <div v-if="invite.status == 3" class="h5">Declined</div>
            </div>
          </div>
        </div>

        <div v-else>
          <div class="row" id="editabelinvitedetails">
            <div class="col-md-4 col-12">
              <label>Name</label>
              <div class="h5">{{ invite.name }}</div>
            </div>
            <div class="col-md-4 col-12">
              <label>Email</label>
              <input
                class="form-control"
                :disabled="editInvite !== invite.id"
                v-model="invite.email"
              />
            </div>
            <div class="col-md-4 col-12">
              <label>Mobile</label>
              <input
                class="form-control"
                :disabled="editInvite !== invite.id"
                v-model="invite.mobile"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-12">
              <label>Type</label>
              <div v-if="invite.type == 1" class="h5">Professional</div>
              <div v-else class="h5">Personal</div>
            </div>
            <div class="col-md-4 col-12">
              <label>Status</label>
              <div v-if="invite.status == null" class="h5">Not Requested</div>
              <div v-if="invite.status == 1" class="h5">Awaiting Response</div>
              <div v-if="invite.status == 2" class="h5">Completed</div>
              <div v-if="invite.status == 3" class="h5">Declined</div>
            </div>
          </div>
        </div>

        <div v-if="invite.type == 1">
          <div v-if="editInvite == false">
            <div v-if="invite.status == 2">
              <hr />
              <div class="row mb-1 mt-4">
                <div class="col-lg col-md-6 col-12">
                  <label>Occupation</label>
                  <div class="h5">{{ invite.occupation }}</div>
                </div>
                <div
                  class="col-lg col-md-6 col-12"
                  v-if="invite.safeguard_check == 1"
                >
                  <label>Safeguarding issues</label>
                  <div class="h5">YES</div>
                </div>
                <div
                  class="col-lg col-md-6 col-12"
                  v-if="invite.safeguard_check == 2"
                >
                  <label>Safeguarding issues</label>
                  <div class="h5">NO</div>
                </div>
                <div
                  class="col-lg col-md-6 col-12"
                  v-if="invite.employed_to == null"
                >
                  <label>Employment Dates:</label>
                  <div class="h5">
                    {{ invite.employed_from | date }} - Present
                  </div>
                </div>
                <div class="col-lg col-md-6 col-12" v-else>
                  <label>Employment Dates:</label>
                  <div class="h5">
                    {{ invite.employed_from | date }} -
                    {{ invite.employed_to | date }}
                  </div>
                </div>
                <div class="col-lg col-md-6 col-12">
                  <label>Completed at</label>
                  <div class="h5">{{ invite.completed_at }}</div>
                </div>
              </div>
              <div class="row" v-if="invite.staff_note != null">
                <div class="col-lg col-md-6 col-12">
                  <label>Staff notes</label>
                  <div class="h5">{{ invite.staff_note }}</div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="row mb-1 mt-4">
              <div class="col-lg col-md-6 col-12">
                <label>Occupation</label>
                <input
                  class="form-control h5"
                  v-model="invite.occupation"
                  :disabled="editInvite !== invite.id"
                />
              </div>
              <div class="col-lg col-md-6 col-12">
                <label>Safeguarding issues</label>
                <select
                  class="optionpicker form-control"
                  v-model="invite.safeguard_check"
                  :disabled="editInvite !== invite.id"
                >
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
              </div>
              <div class="col-lg col-md-6 col-12">
                <label>Employment Start:</label>
                <input
                  type="date"
                  class="form-control h5"
                  v-model="invite.employed_from"
                  :disabled="editInvite !== invite.id"
                />
              </div>
              <div class="col-lg col-md-6 col-12">
                <label>Employment End:</label>
                <input
                  type="date"
                  class="form-control h5"
                  v-model="invite.employed_to"
                  :disabled="editInvite !== invite.id"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-lg col-md-6 col-12">
                <label>Notes</label>
                <input
                  class="form-control h5"
                  v-model="invite.note"
                  :disabled="editInvite !== invite.id"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-lg col-md-6 col-12">
                <label>Staff Notes</label>
                <input
                  class="form-control h5"
                  v-model="invite.staff_note"
                  :disabled="editInvite !== invite.id"
                />
              </div>
              <div class="col-lg-4 col-md-6 col-12 my-auto ml-auto">
                <input
                  type="checkbox"
                  id="exampleCheck1"
                  v-model="invite.manually"
                  :disabled="editInvite !== invite.id"
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
          <div v-if="editInvite == false">
            <div v-if="invite.status == 2">
              <hr />
              <div class="row mb-1 mt-4">
                <div class="col-lg col-md-6 col-12">
                  <label>Occupation</label>
                  <div class="h5">{{ invite.occupation }}</div>
                </div>
                <div class="col-lg col-md-6 col-12">
                  <label>Known for</label>
                  <div class="h5">{{ invite.known_since }}</div>
                </div>
                <div class="col-lg col-md-6 col-12" v-if="invite.related == 1">
                  <label>Related?</label>
                  <div class="h5">YES</div>
                </div>
                <div class="col-lg col-md-6 col-12" v-if="invite.related == 2">
                  <label>Related?</label>
                  <div class="h5">NO</div>
                </div>
                <div class="col-lg col-md-6 col-12">
                  <label>Capacity</label>
                  <div class="h5">{{ invite.capacity }}</div>
                </div>
                <div class="col-lg col-md-6 col-12">
                  <label>Completed at</label>
                  <div class="h5">{{ invite.completed_at }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg col-md-6 col-12">
                  <label>Applicant suitability</label>
                  <div class="h5">{{ invite.note }}</div>
                </div>
              </div>
              <div class="row" v-if="invite.staff_note != null">
                <div class="col-lg col-md-6 col-12">
                  <label>Staff notes</label>
                  <div class="h5">{{ invite.staff_note }}</div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="row mb-1 mt-4">
              <div class="col-lg col-md-6 col-12">
                <label>Occupation</label>
                <input
                  class="form-control h5"
                  v-model="invite.occupation"
                  :disabled="editInvite !== invite.id"
                />
              </div>
              <div class="col-lg col-md-6 col-12">
                <label>Known for</label>
                <input
                  class="form-control h5"
                  v-model="invite.known_since"
                  :disabled="editInvite !== invite.id"
                />
              </div>
              <div class="col-lg col-md-6 col-12">
                <label>Related</label>
                <select
                  class="optionpicker form-control"
                  v-model="invite.related"
                  :disabled="editInvite !== invite.id"
                >
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
              </div>
              <div class="col-lg col-md-6 col-12">
                <label>Capacity</label>
                <input
                  class="form-control h5"
                  v-model="invite.capacity"
                  :disabled="editInvite !== invite.id"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-lg col-md-6 col-12">
                <label>Applicant suitability</label>
                <input
                  class="form-control h5"
                  v-model="invite.note"
                  :disabled="editInvite !== invite.id"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-lg col-md-6 col-12">
                <label>Staff Notes</label>
                <input
                  class="form-control h5"
                  v-model="invite.staff_note"
                  :disabled="editInvite !== invite.id"
                />
              </div>
              <div class="col-lg-4 col-md-6 col-12 my-auto ml-auto">
                <input
                  type="checkbox"
                  id="exampleCheck1"
                  v-model="invite.manually"
                  :disabled="editInvite !== invite.id"
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
</template>
<script>
export default {
  computed: {
    invites: function () {
      return this.$store.state.reference.invites;
    },
    editInvite: {
      get() {
        return this.$store.state.reference.editInvite;
      },
      set(newVal) {
        return (this.$store.state.reference.editInvite = newVal);
      },
    },
  },
  mounted() {
    this.show();
  },
  methods: {
    async show() {
      await this.$store.dispatch("reference/readInvites", {
        id: this.$route.params.id,
      });
    },
    async update(invite) {
      await this.$store
        .dispatch("reference/patchInvite", {
          id: invite.id,
          data: invite,
        })
        .then((res) => {
          this.editInvite = false;
        });
    },
    async request(invite) {
      await this.$store
        .dispatch("reference/request", {
          id: invite.id,
          data: invite,
        })
        .then((res) => {
          this.show();
        });
    },
    async destroy(id) {
      await this.$store
        .dispatch("reference/destroyInvite", { id: id })
        .then((res) => {
          this.show();
        });
    },
    async remind(invite) {
      await this.$store
        .dispatch("reference/reminder", {
          id: invite.id,
          data: invite,
        })
        .then((res) => {
          this.$store.dispatch("reference/readInvites", {
            id: this.$route.params.id,
          });
        });
    },
  },
};
</script>