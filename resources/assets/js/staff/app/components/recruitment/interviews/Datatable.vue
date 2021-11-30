<template>
  <div class="content">
    <div class="row py-3">
      <div class="col-md-auto col-12 my-auto">
        <h3 class="mb-0">Interviews</h3>
      </div>
      <div class="col-md-auto col-12 ml-auto my-auto">
        <button
          class="btn btn-primary btn-md"
          v-show="showFilters === false"
          @click="showFilters = true"
        >
          Show Filters
        </button>
        <button
          class="btn btn-danger btn-md"
          v-show="showFilters === true"
          @click="showFilters = false"
        >
          Hide Filters
        </button>
      </div>
    </div>

    <div class="row py-3" id="filters" v-show="showFilters === true">
      <div class="col-md-4 col-12 input-group">
        <div class="input-group-append">
          <span id="label" class="input-group-text"> Branch </span>
        </div>
        <select class="form-control selectpicker" v-model="filters.branch">
          <option value="all">All</option>
          <option
            v-for="(branch, key) in branches"
            :key="key"
            :value="branch.id"
          >
            {{ branch.name }}
          </option>
        </select>
      </div>
      <div class="col-md-4 col-12 input-group">
        <div class="input-group-append">
          <span id="label" class="input-group-text"> Status </span>
        </div>
        <select class="form-control selectpicker" v-model="filters.status">
          <option value="all">All</option>
          <option
            v-for="(status, key) in statuses"
            :key="key + 1"
            :value="status.value"
          >
            {{ status.name }}
          </option>
        </select>
      </div>
      <div class="col-md-4 col-12 input-group">
        <div class="input-group-append">
          <span id="label" class="input-group-text"> Interviewer </span>
        </div>
        <select class="form-control selectpicker" v-model="filters.staff">
          <option value="all">All</option>
          <option v-for="(s, key) in staff" :key="key + 2" :value="s.id">
            {{ s.name }}
          </option>
        </select>
      </div>
    </div>

    <div class="row py-3" id="datatable">
      <div class="col-12">
        <div class="table-responsive" v-if="loaded">
          <table
            class="
              table table-hover table-bordered table-striped
              js-appear-enabled
              animated
              fadeIn
            "
          >
            <thead class="thead-light">
              <tr>
                <th>Name</th>
                <th>Schedulded For</th>
                <th class="text-center">Status</th>
                <th>Interviewer</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr v-for="(data, key) in datatable.data" :key="key + 3">
                <td>
                  <div class="my-2">
                    {{ data.first_name }} {{ data.last_name }}
                  </div>
                </td>
                <td class="text-truncate">
                  <div class="my-2">{{ data.scheduled_date }}</div>
                  <div class="my-2">{{ data.scheduled_time }}</div>
                </td>
                <td class="text-center">
                  <div class="my-2" v-show="data.application_status == 2">
                    <button class="btn btn-md btn-danger" disabled>
                      APPLICATION REJECTED
                    </button>
                  </div>
                  <div
                    class="my-2"
                    v-show="
                      data.response == 'Pending' && data.application_status != 2
                    "
                  >
                    <button class="btn btn-md btn-warning" disabled>
                      <i class="fas fa-minus mr-1"></i> Pending
                    </button>
                  </div>
                  <div
                    class="my-2"
                    v-show="
                      data.response == 'Planned' && data.application_status != 2
                    "
                  >
                    <button class="btn btn-md btn-info" disabled>
                      <i class="far fa-clock mr-1"></i> Planned
                    </button>
                  </div>
                  <div
                    class="my-2"
                    v-show="
                      data.response == 'Completed' &&
                      data.application_status != 2
                    "
                  >
                    <button class="btn btn-md btn-success" disabled>
                      <i class="fas fa-check mr-1"></i> Completed
                    </button>
                  </div>
                  <div
                    class="my-2"
                    v-show="
                      data.response == 'Successful' &&
                      data.application_status != 2
                    "
                  >
                    <button class="btn btn-md btn-success" disabled>
                      <i class="fas fa-check mr-1"></i> Successful
                    </button>
                  </div>
                  <div
                    class="my-2"
                    v-show="
                      data.response == 'Rejected' &&
                      data.application_status != 2
                    "
                  >
                    <button class="btn btn-md btn-danger" disabled>
                      <i class="fas fa-times mr-1"></i> Rejected
                    </button>
                  </div>
                  <div
                    class="my-2"
                    v-show="
                      data.response == 'No Show' && data.application_status != 2
                    "
                  >
                    <button class="btn btn-md btn-danger" disabled>
                      <i class="fas fa-times mr-1"></i> No Show
                    </button>
                  </div>
                </td>
                <td>
                  <div class="my-2">
                    {{ data.staff_name }}
                  </div>
                </td>
                <td class="text-center">
                  <div class="btn-group my-2">
                    <router-link
                      class="btn btn-secondary btn-md"
                      :to="
                        '/recruitment/applications/' +
                        data.applicant_id +
                        '/references'
                      "
                    >
                      <i class="far fa-eye pr-2"></i>View
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
</template>
<script>
import Pagination from "../../layout/tables/Pagination.vue";
import Loading from "../../layout/tables/Loading.vue";

export default {
  components: {
    Pagination,
    Loading,
  },
  data() {
    return {
      showFilters: false,
      branches: {},
      statuses: {
        pending: { name: "Pending", value: 0 },
        planned: { name: "Planned", value: 1 },
        completed: { name: "Completed", value: 2 },
        successful: { name: "Successful", value: 3 },
        rejected: { name: "Rejected", value: 4 },
        no_show: { name: "No show", value: 5 },
      },
      staff: {},
      filters: {
        branch: "all",
        status: "all",
        staff: "all",
      },
      datatable: {
        data: {},
        current_page: 1,
        per_page: 25,
        last_page: 0,
        total: 1,
      },
      loaded: false,
    };
  },
  watch: {
    filters: {
      deep: true,
      handler: function (val) {
        this.index();
      },
    },
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.getBranches();
      this.getStaff();
      this.index();
    },
    getStaff() {
      axios.get("/api/recruitment/interviews/active").then((response) => {
        this.staff = response.data;
      });
    },
    getBranches() {
      axios.get("/api/branches").then((res) => {
        this.branches = res.data;
      });
    },
    index() {
      var route = "/api/recruitment/interviews?";
      route += "page=" + this.datatable.current_page;
      route += "&branch=" + this.filters.branch;
      route += "&status=" + this.filters.status;
      route += "&staff=" + this.filters.staff;
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: this.datatable.current_page,
            branch: this.filters.branch,
            status: this.filters.status,
            staff: this.filters.staff,
          },
        })
        .catch((error) => {});
      axios
        .get(route)
        .then((response) => {
          this.datatable = response.data;
        })
        .then(() => {
          this.loaded = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index();
      }
    },
  },
};
</script>