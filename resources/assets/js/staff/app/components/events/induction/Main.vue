<template>
  <div class="content">
    <div class="row pt-sm-3 pt-md-4">
      <div class="col-12">
        <h3>Indiction Events</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
          <div class="block-content block-content-full tab-content">
            <div class="row mb-4">
              <div class="col-lg-4 col-12 input-group ml-auto my-auto">
                <input type="text" class="form-control" v-model="search" :placeholder="'Search...'"/>
                <div class="input-group-append">
                  <span class="input-group-text" style="background-color:#ffffff;">
                    <i class="fa fa-fw fa-search"></i>
                  </span>
                </div>
              </div>
              <div class="col-lg-3 col-12 my-auto">
                <select class="form-control selectpicker" v-model="filterBranch" @change="filterEvents(1)">
                  <option value selected disabled>Filter by branches</option>
                  <option value="all" selected>All</option>
                  <option
                    class="optionpicker"
                    v-for="branch in branches"
                    v-bind:key="branch.id"
                    :value="branch.id"
                  >{{ branch.name }}</option>
                </select>
              </div>
              <div class="col-lg-3 col-12 my-auto">
                <select class="form-control selectpicker" v-model="sort" @change="filterEvents(datatable.current_page)">
                  <option value selected disabled>Event status</option>
                  <option value="all">All</option>
                  <option value="upcoming">Upcoming</option>
                  <option value="previous">Expired</option>
                </select>
              </div>
              <div class="col-lg-2 col-12 my-auto ml-auto">
                <button class="btn btn-dark btn-sm" v-on:click="create">
                  <i class="fa fa-plus"></i> New
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="table-responsive" v-if="loaded">
                  <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                    <thead class="thead-light" v-if="datatable.data.length">
                      <tr>
                        <th>Event</th>
                        <th>Attendee Type</th>
                        <th>Scheduled Time</th>
                        <th>Scheduled Date</th>
                        <th>Location</th>
                        <th class="text-center">Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                      <tr v-for="(event, key) in datatable.data" v-bind:key="key">
                        <td>{{ event.agenda }}</td>
                        <td>{{ event.attendee_type | AttendeeType }}</td>
                        <td>{{ event.scheduled_time }}</td>
                        <td>{{ event.scheduled_date }}</td>
                        <td style="text-transform:capitalize;">{{ event.location }}</td>
                        <td class="text-center">
                          <div class="btn btn-success btn-sty btn-sm" v-if="event.expired == 0 || event.expired == null">
                            <i class="fas fa-check"></i> Active
                          </div>
                          <div class="btn btn-danger btn-sty btn-sm" v-else>
                            <i class="fas fa-times"></i> Expired
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <router-link class="btn btn-outline-secondary btn-sm" :to="'/induction/booking/' + event.id">
                              <i class="fa fa-folder-open"></i> View
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
          <div class="block-content block-content-full block-content-sm bg-body-light">
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
import Loading from "../../layout/tables/Loading.vue";
import Pagination from "../../layout/tables/Pagination.vue";
// import vueCalendar from "vue2-simple-calendar";

export default {
  computed: {
    eventCount: function () {
      return _.size(this.datatable.data);
    },
  },
  data: function () {
    return {
      routePrefix: "/api/events/induction/booking/",
      sort: "all",
      search: "",
      filterBranch: null,
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      branches: {},
      newEvent: {},
      newEvents: false,
      loaded: true,
      disabled: false,
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
    search: function (val) {
      var search_check = this.search;
      setTimeout(() => {
        if (search_check == this.search) {
          this.index(1);
        }
      }, 500);
    },
  },
  mounted() {
    if (this.$route.query.page) {
      this.datatable.current_page = this.$route.query.page;
    }
    if (this.$route.query.search) {
      this.search = this.$route.query.search;
    }
    if (this.$route.query.filterBranch) {
      this.filterBranch = this.$route.query.filterBranch;
    }
    this.index(this.datatable.current_page, this.filterBranch);
    this.getBranches();
  },
  methods: {
    index(page, filterBranch) {
      var route = this.routePrefix + "?";
      route += "page=" + page;
      if (this.search.length > 0) {
        route += "&search=" + this.search;
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
            search: this.search,
            filterBranch: this.filterBranch,
            sort: this.sort,
          },
        })
        .catch((err) => {});
      axios
        .get(route)
        .then((response) => {
          this.datatable = response.data;
        })
        .then(() => {
          this.loaded = true;
        });
    },
    filterEvents(page) {
      this.$router.push({
        query: {
          page: page,
          filterBranch: this.filterBranch,
        },
      });
      this.index(page, this.sort, this.filterBranch);
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
    create() {
      axios
        .post(this.routePrefix + "create")
        .then((response) => {
          this.$router.push("/induction/booking/" + response.data.id);
        })
        .catch((error) => {
          this.message = "Oops, an error occurred!";
        });
    },
    getBranches() {
      axios
        .get("/api/management/staff/branches/")
        .then((response) => {
          this.branches = response.data;
        });
    },
    showAll(events) {
      // Do something...
    },
    dayClicked(day) {
      console.log(day);
      // Do something...
    },
    eventClicked(event) {
      // Do something...
    },
    monthChanged(start, end) {
      // Do something...
    },
  },
  created() {
    this.$calendar.eventBus.$on("show-all", (events) => this.showAll(events));
    this.$calendar.eventBus.$on("day-clicked", (day) => this.dayClicked(day));
  },
};
</script>
<style lang="scss" scoped>
#dayspan {
  font-family: Roboto, sans-serif;
  width: 100%;
  height: 100%;
}
</style>
