<template>
  <div>
    <!-- Modal -->
    <div v-if="missing_compliance">
      <div
        class="modal fadeIn fadeOut backdrop-bg"
        id="exampleModalCenter"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Missing Compliance</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <ul>
                <li v-for="(data, key) in missing_compliance" :key="key">
                  {{ data.name }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12" v-if="loaded">
        <table
          class="
            table table table-hover table-vcenter table-bordered table-striped
            js-appear-enabled
            animated
            fadeI
          "
        >
          <thead class="thead-light">
            <tr>
              <th>Applicant</th>
              <th>Location</th>
              <th>Shift Details</th>
              <th>DBS Details</th>
              <th>Vaccinated</th>
              <th class="text-center">Driving Licence</th>
              <th class="text-center">Interview Score</th>
              <th class="text-center">Compliance %</th>
              <th class="text-center">Favourite</th>
              <th class="text-center">Last Updated</th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <tr v-for="(applicant, key) in datatable.data" :key="key">
              <td>
                <div class="mb-2">
                  {{ applicant.first_name }} {{ applicant.last_name }}
                </div>
                <div class="mb-2">{{ applicant.position }}</div>
                <div class="mb-0">{{ applicant.branch_id | branchName }}</div>
              </td>
              <td>
                <div class="mb-2">{{ applicant.address_line_1 }}</div>
                <div class="mb-2">{{ applicant.city }}</div>
                <div class="mb-0">{{ applicant.postcode }}</div>
              </td>
              <td>
                <div class="mb-2">Hours p/w: {{ applicant.hours_pw }}</div>
                <div class="mb-0" v-if="applicant.interview_notes">
                  Shift type:
                  {{ applicant.interview_notes.shift_type | shiftType }}
                </div>
                <div class="mb-0" v-else>Shift type: N/A</div>
              </td>
              <td class="text-center" v-if="applicant.dbs_details">
                <div class="mb-2">
                  Number: {{ applicant.dbs_details.dbs_number }}
                </div>
                <div class="mb-0">
                  Issue Date: {{ applicant.dbs_details.issue_date }}
                </div>
              </td>
              <td class="text-center" v-else>
                <div class="mb-0">N/A</div>
              </td>
              <td class="text-center">
                <div class="mb-0" v-if="applicant.vaccinated">
                  {{ applicant.vaccinated | vaccinated }}
                </div>
              </td>
              <td
                class="text-center"
                :class="{
                  driver:
                    applicant.drivers_licence === 'Yes' ||
                    applicant.drivers_licence === 'yes',
                  leadfoot:
                    applicant.drivers_licence === 'No' ||
                    applicant.drivers_licence === 'no' ||
                    applicant.drivers_licence === null,
                }"
                style="text-transform: capitalize"
              >
                {{ applicant.drivers_licence }}
              </td>
              <td
                v-if="applicant.interview_notes"
                class="text-center"
                :class="{
                  poor:
                    applicant.interview_notes.overall_score === '1' ||
                    applicant.interview_notes.overall_score === '2' ||
                    applicant.interview_notes.overall_score === '3' ||
                    applicant.interview_notes.overall_score === '4',
                  ok:
                    applicant.interview_notes.overall_score === '5' ||
                    applicant.interview_notes.overall_score === '6' ||
                    applicant.interview_notes.overall_score === '7',
                  excellent:
                    applicant.interview_notes.overall_score === '8' ||
                    applicant.interview_notes.overall_score === '9' ||
                    applicant.interview_notes.overall_score === '10',
                }"
              >
                <div v-if="applicant.interview_notes">
                  {{ applicant.interview_notes.overall_score }}
                </div>
                <div class="text-center" v-else>N/A</div>
              </td>
              <td class="text-center" v-else>N/A</td>
              <td
                class="text-center"
                v-if="
                  applicant.position == 'RGN' || applicant.position == 'RMN'
                "
              >
                <div v-if="applicant.total_compliance_items">
                  <button
                    class="btn btn-md btn-light"
                    data-toggle="modal"
                    data-target="#exampleModalCenter"
                    data-backdrop="false"
                    @click="getMissingCompliance(applicant.id)"
                  >
                    <b>
                      {{
                        format_percentage(
                          (100 / 8) * applicant.total_compliance_items.length
                        )
                      }}%
                    </b>
                  </button>
                </div>
              </td>
              <td class="text-center" v-else>
                <div v-if="applicant.total_compliance_items">
                  <button
                    class="btn btn-md btn-light"
                    data-toggle="modal"
                    data-target="#exampleModalCenter"
                    data-backdrop="false"
                    @click="getMissingCompliance(applicant.id)"
                  >
                    <b>
                      {{
                        format_percentage(
                          (100 / 7) * applicant.total_compliance_items.length
                        )
                      }}%
                    </b>
                  </button>
                </div>
              </td>
              <td class="text-center" v-if="applicant.favourite == 1">
                <button
                  type="button"
                  class="btn"
                  :class="{ favourite: applicant.favourite == 1 }"
                  @click="update(applicant.id, { favourite: 0 })"
                >
                  <i class="fas fa-star fa-2x"></i>
                </button>
              </td>
              <td class="text-center" v-else>
                <button
                  type="button"
                  class="btn"
                  @click="update(applicant.id, { favourite: 1 })"
                >
                  <i class="fas fa-star fa-2x"></i>
                </button>
              </td>
              <td class="text-center">
                {{ format_date(applicant.updated_at) }}
              </td>
              <td class="test-center">
                <router-link
                  class="btn btn-secondary"
                  :to="'/recruitment/applications/' + applicant.id"
                >
                  <i class="fas fa-eye py-auto"></i>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-12">
        <loading />
      </div>
    </div>
    <div
      class="
        row
        block-content block-content-full block-content-sm
        bg-body-light
        mb-4
      "
    >
      <div class="col-12">
        <pagination />
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Pagination from "../../../layout/tables/Pagination.vue";
import Loading from "../../../layout/tables/Loading.vue";

export default {
  components: {
    Pagination,
    Loading,
  },
  computed: {
    datatable: function () {
      return this.$store.state.pipeline.datatable;
    },
    missing_compliance: function () {
      return this.$store.state.pipeline.missing_compliance;
    },
    filters: function () {
      return this.$store.state.pipeline.filters;
    },
    loaded: {
      get() {
        return this.$parent.loaded;
      },
      set(newVal) {
        return (this.$parent.loaded = newVal);
      },
    },
    showFilters: {
      get() {
        return this.$store.state.pipeline.showFilters;
      },
      set(newVal) {
        return (this.$store.state.pipeline.showFilters = newVal);
      },
    },
    format_percentage() {
      return this.$root.format_percentage;
    },
  },
  mounted() {
    this.index();
  },
  methods: {
    async index() {
      (this.loaded = false),
        await this.$store.dispatch("pipeline/getDatatable", {
          filters: this.filters,
          datatable: this.datatable,
        });
      this.loaded = true;
    },
    async update(id, data) {
      await this.$store.dispatch("pipeline/updateDatatable", {
        id: id,
        favourite: data,
      });
      this.index();
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
    async getMissingCompliance(id) {
      await this.$store.dispatch("pipeline/getMissingCompliance", {
        id: id,
      });
    },
    format_date(date) {
      return moment(date).format("DD/MM/YYYY");
    },
  },
};
</script>
