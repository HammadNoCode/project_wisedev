<template>
  <div class="content">
    <div class="row my-3">
      <div class="col-12 my-auto">
        <h3 class="mb-0">Interviews</h3>
      </div>
    </div>
    <div class="row py-3">
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
            <div class="row mb-4">
              <div class="col-md-4 col-12 my-auto input-group">
                <select
                  class="form-control selectpicker"
                  v-model="sort"
                  v-on:change="filter_interviews(datatable.current_page)"
                >
                  <option value selected disabled>Filter by status</option>
                  <option value="all">All</option>
                  <option value="pending">Pending</option>
                  <option value="planned">Planned</option>
                  <option value="completed">Completed</option>
                  <option value="successful">Successful</option>
                  <option value="rejected">Unsuccessful</option>
                </select>
              </div>
              <div class="col-md-4 col-12 my-auto">
                <select
                  class="form-control selectpicker"
                  v-model="filterBranch"
                  v-on:change="filter_interviews(1)"
                >
                  <option value selected disabled>Branches</option>
                  <option value="0" selected>All</option>
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
              <div class="col-md-4 col-12 my-auto">
                <select
                  class="form-control selectpicker"
                  v-model="filter"
                  v-on:change="filter_interviews(1)"
                >
                  <option value selected disabled>Staff</option>
                  <option value="all" selected>All</option>
                  <option
                    class="optionpicker"
                    v-for="staff in staff"
                    v-bind:key="staff.id"
                    :value="staff.id"
                  >
                    {{ staff.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive" v-if="loaded">
                  <table
                    class="
                      table
                      table-hover
                      table-vcenter
                      table-bordered
                      table-striped
                      js-appear-enabled
                      animated
                      fadeIn
                    "
                  >
                    <thead class="thead-light" v-if="datatable.data.length">
                      <tr>
                        <th>Applicant Name</th>
                        <th>Interview Date</th>
                        <th>Interview Time</th>
                        <th class="text-center">Status</th>
                        <th>Staff Assigned</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                      <tr
                        v-for="(interview, key) in datatable.data"
                        v-bind:key="key"
                      >
                        <td>
                          {{ interview.first_name + " " + interview.last_name }}
                        </td>
                        <td>{{ interview.scheduled_date }}</td>
                        <td>{{ interview.scheduled_time }}</td>
                        <td class="text-center">
                          <div
                            v-if="
                              interview.response == 'Pending' &&
                              interview.application_status != 2
                            "
                          >
                            <button class="btn btn-sty btn-sm mt-1">
                              <i class="fas fa-minus mr-1"></i> Pending
                            </button>
                          </div>
                          <div
                            v-if="
                              interview.response == 'Planned' &&
                              interview.application_status != 2
                            "
                          >
                            <button class="btn btn-info btn-sty btn-sm mt-1">
                              <i class="far fa-clock mr-1"></i> Planned
                            </button>
                          </div>
                          <div
                            v-if="
                              interview.response == 'Completed' &&
                              interview.application_status != 2
                            "
                          >
                            <button class="btn btn-success btn-sty btn-sm mt-1">
                              <i class="fas fa-check mr-1"></i> Completed
                            </button>
                          </div>
                          <div
                            v-if="
                              interview.response == 'Successful' &&
                              interview.application_status != 2
                            "
                          >
                            <button class="btn btn-success btn-sty btn-sm mt-1">
                              <i class="fas fa-check mr-1"></i> Successful
                            </button>
                          </div>
                          <div
                            v-if="
                              interview.response == 'Rejected' &&
                              interview.application_status == 2
                            "
                          >
                            <button class="btn btn-danger btn-sty btn-sm mt-1">
                              <i class="fas fa-times mr-1"></i> Unsuccessful
                            </button>
                          </div>
                          <div v-if="interview.response == 'No Show'">
                            <button class="btn btn-danger btn-sty btn-sm mt-1">
                              <i class="fas fa-times mr-1"></i> No Show
                            </button>
                          </div>
                        </td>
                        <td>
                          <div v-if="interview.staff_name">
                            {{ interview.staff_name }}
                          </div>
                          <div class="text-danger" v-else>
                            Staff not Assigned
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <router-link
                              class="btn btn-secondary btn-sm"
                              :to="
                                '/recruitment/applications/' +
                                interview.applicant_id +
                                '/interviews'
                              "
                            >
                              <i class="fa fa-folder-open"></i> Interview
                            </router-link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div>
                  <loading />
                </div>
              </div>
            </div>
          </div>
          <div
            class="
              block-content block-content-full block-content-sm
              bg-body-light
            "
          >
            <div>
              <pagination />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/javascript">
import Pagination from "../layout/tables/Pagination.vue";
import Loading from "../layout/tables/Loading.vue";
export default {
  computed: {
    userBranch: function () {
      return this.$store.state.user.branch_id;
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/interviews",
      sort: "all",
      filter: "all",
      filterBranch: null,
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      branches: {},
      staff: {},
      loaded: false,
    };
  },
  components: {
    Pagination,
    Loading,
  },
  watch: {
    filter: function (val) {
      this.index(1);
    },
  },
  mounted() {
    if (this.$route.query.page) {
      this.datatable.current_page = this.$route.query.page;
    }
    if (this.$route.query.filter) {
      this.filter = this.$route.query.filter;
    }
    if (this.$route.query.filterBranch) {
      this.filterBranch = this.$route.query.filterBranch;
    }
    if (this.$route.query.sort) {
      this.sort = this.$route.query.sort;
    }
    this.index(
      this.datatable.current_page,
      this.filter,
      this.filterBranch,
      this.sort
    );
    this.getStaff();
    this.getBranches();
  },
  methods: {
    index(page, filter = null, filterBranch, sort = null) {
      var route = this.routePrefix + "?";
      route += "page=" + page;
      if (this.filter) {
        route += "&filter=" + this.filter;
      }
      if (this.filterBranch) {
        route += "&filterBranch=" + this.filterBranch;
      }
      if (this.sort.length > 0) {
        route += "&sort=" + this.sort;
      }
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: page,
            filter: this.filter,
            filterBranch: this.filterBranch,
            sort: this.sort,
          },
        })
        .catch((error) => {});
      axios
        .get(route)
        .then((response) => {
          this.datatable = response.data;
          // if (this.filterBranch == null) {
          //   this.filterBranch = this.userBranch;
          // }
        })
        .then(() => {
          this.loaded = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    filter_interviews(page) {
      this.$router
        .push({
          query: {
            page: page,
            filter: this.filter,
          },
        })
        .catch((error) => {
          console.log(error);
        });
      this.index(page, this.filter, this.filterBranch, this.sort);
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
    getStaff() {
      axios.get(this.routePrefix + "/active").then((response) => {
        this.staff = response.data;
      });
    },
    getBranches() {
      axios
        .get("/api/recruitment/applications/" + "branches")
        .then((response) => {
          this.branches = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
