<template>
  <div>
    <div class="row mt-3">
      <div class="col-lg-4 col-12">
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
              <div class="col-12 py-2">
                <h2 class="text-center mb-1">
                  {{ carehome.main_contact_number }}
                </h2>
              </div>
              <div class="col-12 py-2">
                <a
                  class="btn w-100 text-white"
                  style="background-color: #750288"
                  :href="'tel:' + carehome.main_contact_number"
                  @click="createRecord(carehome.location_id)"
                  >CALL <i class="fas fa-phone pl-2"></i
                ></a>
              </div>
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
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Agencies</h5>
              </div>
            </div>
            <hr />
            <div class="row pb-2">
              <div class="col">
                <button
                  type="button"
                  class="btn btn-primary w-100"
                  @click="createCavalryHealthcareAgency"
                >
                  <i class="fas fa-plus pr-1"></i> Cavalry Healthcare
                </button>
              </div>
            </div>
            <div class="row py-2 pb-4">
              <div class="col-lg-10 col-10 my-auto">
                <input
                  class="form-control"
                  type="text"
                  name="agency name"
                  :placeholder="'Other agency name...'"
                  v-model="agency.name"
                />
              </div>
              <div class="col-lg-2 col-2 my-auto ml-auto">
                <button
                  type="button"
                  class="btn btn-sm btn-success float-right"
                  @click="addAgency"
                >
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="row py-b">
              <div class="col-12">
                <ul v-if="agencies.length > 0">
                  <li
                    class="py-1 my-auto"
                    v-for="(agency, key) in agencies"
                    :key="key + 1"
                  >
                    {{ agency.name }}
                    <i
                      type="button"
                      class="btn btn-sm fas fa-times text-danger float-right"
                      @click="destroyAgency(agency.id)"
                    ></i>
                  </li>
                </ul>
                <div class="py-3" v-else>
                  <h6 class="text-muted text-center">No Agencies</h6>
                </div>
              </div>
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
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Service Types</h5>
              </div>
            </div>
            <hr />
            <div class="row py-b">
              <div class="col-12">
                <ul v-if="carehome.service_types.length > 0">
                  <li
                    class="py-1"
                    v-for="(type, key) in carehome.service_types"
                    :key="key"
                  >
                    {{ type.type }}
                  </li>
                </ul>
                <div class="py-3" v-else>
                  <h6 class="text-muted text-center">No Service Types</h6>
                </div>
              </div>
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
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Specialisms</h5>
              </div>
            </div>
            <hr />
            <div class="row py-b">
              <div class="col-12">
                <ul v-if="carehome.specialisms.length > 0">
                  <li
                    class="py-1"
                    v-for="(specialism, key) in carehome.specialisms"
                    :key="key"
                  >
                    {{ specialism.specialism }}
                  </li>
                </ul>
                <div class="py-3" v-else>
                  <h6 class="text-muted text-center">No Specialisms</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-8 col-12">
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
              <div class="col-12">
                <h5 class="mb-0">Overall Rating</h5>
              </div>
            </div>
            <hr />
            <div class="row py-2">
              <div class="col-12">
                <button
                  class="btn w-100 text-uppercase text-white"
                  :class="{
                    outstanding: carehome.rating == 'Outstanding',
                    good: carehome.rating == 'Good',
                    improvement: carehome.rating == 'Requires improvement',
                    inadequate: carehome.rating == 'Inadequate',
                  }"
                >
                  {{ carehome.rating }}
                </button>
              </div>
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
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">
                  About<i class="fas fa-info-circle text-primary pl-2"></i>
                </h5>
              </div>
            </div>
            <hr />
            <div class="row pb-2">
              <div class="col-12 py-1" v-if="manager">
                <label for="branch">Branch</label>
                <select
                  class="form-control"
                  name="branch"
                  v-model="carehome.branch_id"
                >
                  <option selected disabled>Branch</option>
                  <option value="1">Blackburn</option>
                  <option value="2">Liverpool</option>
                  <option value="3">Warrington</option>
                  <option value="4">Crewe</option>
                </select>
              </div>
              <div class="col-12 py-1" v-else>
                <label for="branch">Branch</label>
                <select
                  class="form-control"
                  name="branch"
                  :disabled="!edit"
                  v-model="carehome.branch_id"
                >
                  <option selected disabled>Branch</option>
                  <option value="1">Blackburn</option>
                  <option value="2">Liverpool</option>
                  <option value="3">Warrington</option>
                  <option value="4">Crewe</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-12 py-1">
                <label for="branch">Carehome Status</label>
                <select
                  class="form-control"
                  name="branch"
                  v-model="carehome.status"
                  @change="update"
                >
                  <option selected disabled>Status</option>
                  <option value="not contacted">Not Contacted</option>
                  <option value="contacted not interested">
                    Contacted (Not Interested)
                  </option>
                  <option value="contacted try again">
                    Contacted (Try Again)
                  </option>
                  <option value="contacted in onboarding">
                    Contacted (In Onboarding)
                  </option>
                  <option value="current client">Current Client</option>
                  <option value="elapsed client">Elapsed Client</option>
                </select>
              </div>
              <div class="col-lg-6 col-12 py-1">
                <label for="branch">Agency Status</label>
                <select
                  class="form-control"
                  name="branch"
                  v-model="carehome.agency_status"
                  @change="update"
                >
                  <option selected disabled>Status</option>
                  <option value="no agency">No Agency</option>
                  <option value="frequent">Frequent User</option>
                  <option value="active">Active User</option>
                </select>
              </div>
            </div>
            <div class="row pb-2">
              <div class="col-lg-6 col-12 py-1">
                <label for="address">Street</label>
                <input
                  class="form-control"
                  type="text"
                  name="address"
                  :disabled="!edit"
                  v-model="carehome.address_1"
                />
              </div>
              <div class="col-lg-6 col-12 py-1">
                <label for="city">City/Town</label>
                <input
                  class="form-control"
                  type="text"
                  name="city"
                  :disabled="!edit"
                  v-model="carehome.city"
                />
              </div>
            </div>
            <div class="row py-2">
              <div class="col-lg-6 col-12 py-1">
                <label for="postalcode">Postal Code</label>
                <input
                  class="form-control"
                  type="text"
                  name="postalcode"
                  :disabled="!edit"
                  v-model="carehome.postal_code"
                />
              </div>
              <div class="col-lg-6 col-12 py-1">
                <label for="region">Region</label>
                <input
                  class="form-control"
                  type="text"
                  name="region"
                  :disabled="!edit"
                  v-model="carehome.region"
                />
              </div>
            </div>
            <div class="row pb-2">
              <div class="col-lg-6 col-12 py-1">
                <label for="website">Website</label>
                <input
                  class="form-control"
                  type="text"
                  name="website"
                  :disabled="!edit"
                  v-model="carehome.website"
                />
              </div>
              <div class="col-lg-6 col-12 py-1">
                <label for="city">Total Beds</label>
                <input
                  class="form-control"
                  type="text"
                  name="city"
                  :disabled="!edit"
                  v-model="carehome.beds"
                />
              </div>
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
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Registered Managers</h5>
              </div>
            </div>
            <hr />
            <div class="row pb-2">
              <div class="col-12">
                <div class="table-responsive">
                  <table
                    class="
                      table table-hover table-vcenter table-borderless
                      js-appear-enabled
                      animated
                      fadeIn
                    "
                  >
                    <tbody class="bg-white">
                      <tr v-for="(contact, key) in contacts" :key="key">
                        <td>{{ contact.full_name }}</td>
                        <td>{{ contact.role }}</td>
                      </tr>
                    </tbody>
                  </table>
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
    carehome: function () {
      return this.$parent.carehome;
    },
    manager: function () {
      return this.$store.state.user.manager == 1 ? true : false;
    },
  },
  data() {
    return {
      routePrefix: "/api/carehome/",
      edit: false,
      agency: {},
      agencies: {},
      agency_status: "",
      contacts: {},
    };
  },
  mounted() {
    this.getAgencies();
    this.showContacts();
  },
  methods: {
    addAgency() {
      axios
        .post(this.routePrefix + "agency", {
          id: this.$route.params.id,
          name: this.agency.name,
        })
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.getAgencies();
        });
    },
    getAgencies() {
      axios
        .get(this.routePrefix + "agency/" + this.$route.params.id)
        .then((response) => {
          this.agencies = response.data;
        })
        .catch((error) => {});
    },
    update() {
      axios
        .patch(this.routePrefix + "detail/" + this.$route.params.id, {
          carehome_status: this.carehome.status,
          agency_status: this.carehome.agency_status,
        })
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.$parent.showCarehome();
        });
    },
    destroyAgency(id) {
      axios
        .delete(this.routePrefix + "agency/" + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.getAgencies();
        });
    },
    showContacts() {
      axios
        .get(this.routePrefix + "contacts/" + this.$route.params.id)
        .then((response) => {
          this.contacts = response.data;
        })
        .catch(() => {});
    },
    createRecord(id) {
      axios
        .post(this.routePrefix + "call-history/" + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.readCallRecords();
        });
    },
    createCavalryHealthcareAgency() {
      axios
        .post("/api/carehome/agency", {
          id: this.$route.params.id,
          name: "Cavalry Healthcare",
        })
        .then((res) => {
          this.getAgencies();
        });
    },
  },
};
</script>
<style scoped>
.outstanding,
.good {
  background-color: #82b54b;
}
.improvement {
  background-color: #ffb347;
}
.inadequate {
  background-color: #ff6961;
}
</style>