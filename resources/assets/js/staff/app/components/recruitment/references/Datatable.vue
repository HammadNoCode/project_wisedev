<template>
  <div class="content">
    <div class="row py-3">
      <div class="col-12">
        <h3 class="mb-0">References</h3>
      </div>
    </div>
    <div class="row py-3">
      <div class="col-md-3 col-12 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Status</span>
        </div>
        <select
          class="form-control selectpicker"
          v-model="filter"
          @change="filter_references(1)"
        >
          <option value selected disabled>Filter by status</option>
          <option value="all">All</option>
          <option value="not-requested">Not Requested</option>
          <option value="awaiting">Awaiting Response</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      <div class="col-md-3 col-12 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Sort By</span>
        </div>
        <select
          class="form-control selectpicker"
          v-model="sort"
          @change="filter_references(datatable.current_page)"
        >
          <option value="newest">Newest</option>
          <option value="oldest">Oldest</option>
        </select>
      </div>
      <div class="col-md-6 col-12 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">
            <i class="fa fa-fw fa-search"></i>
          </span>
        </div>
        <input
          type="text"
          class="form-control"
          v-model="search"
          :placeholder="'Search...'"
        />
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
          <div class="row">
            <div class="col-12">
              <div class="table-responsive" v-if="loaded">
                <table
                  class="
                    table table-hover table-vcenter table-bordered table-striped
                    js-appear-enabled
                    animated
                    fadeIn
                  "
                >
                  <thead class="thead-light" v-if="datatable.data.length">
                    <tr>
                      <th>Applicant Name</th>
                      <th>Referee Name</th>
                      <th>Updated At</th>
                      <th class="text-center">Reminder Sent</th>
                      <th class="text-center">Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <tr
                      v-for="(reference, key) in datatable.data"
                      v-bind:key="key"
                    >
                      <td>
                        {{ reference.first_name + " " + reference.last_name }}
                      </td>
                      <td>{{ reference.name }}</td>
                      <td>{{ reference.completed_at }}</td>
                      <td
                        class="text-center"
                        :class="{ max: reference.reminder_count == 5 }"
                      >
                        {{ reference.reminder_count }}
                      </td>

                      <td class="text-center">
                        <div v-if="reference.application_status == 2">
                          <button class="btn btn-danger btn-sty btn-sm mt-1">
                            <i class="fas fa-times mr-1"></i>Application
                            Rejected
                          </button>
                        </div>
                        <div
                          v-if="
                            reference.responded == 'Not-requested' &&
                            reference.application_status != 2
                          "
                        >
                          <button class="btn btn-secondary btn-sty btn-sm mt-1">
                            <i class="fas fa-minus mr-1"></i> Not Requested
                          </button>
                        </div>
                        <div
                          v-if="
                            reference.responded == 'Awaiting' &&
                            reference.application_status != 2
                          "
                        >
                          <button class="btn btn-info btn-sty btn-sm mt-1">
                            <i class="far fa-clock mr-1"></i> Awaiting
                          </button>
                        </div>
                        <div
                          v-if="
                            reference.responded == 'Completed' &&
                            reference.application_status != 2
                          "
                        >
                          <button class="btn btn-success btn-sty btn-sm mt-1">
                            <i class="fas fa-check mr-1"></i> Completed
                          </button>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="btn-group">
                          <router-link
                            class="btn btn-outline-secondary btn-sm"
                            :to="
                              '/recruitment/applications/' +
                              reference.applicant_id +
                              '/references'
                            "
                          >
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
import Pagination from "../../layout/tables/Pagination.vue";
import Loading from "../../layout/tables/Loading.vue";
export default {
  data: function () {
    return {
      routePrefix: "/api/recruitment/reference",
      search: "",
      filter: "not-requested",
      sort: "newest",
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
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
    if (this.$route.query.filter) {
      this.filter = this.$route.query.filter;
    }
    if (this.$route.query.sort) {
      this.sort = this.$route.query.sort;
    }
    this.index(this.datatable.current_page, this.filter, this.sort);
  },
  methods: {
    index(page, filter = null) {
      var route = this.routePrefix + "?";
      route += "page=" + page;
      if (this.search.length > 0) {
        route += "&search=" + this.search;
      }
      if (this.filter.length > 0) {
        route += "&filter=" + this.filter;
      }
      if (this.sort.length > 0) {
        route += "&sort=" + this.sort;
      }
      (this.loaded = false),
        this.$router
          .push({
            query: {
              page: page,
              search: this.search,
              filter: this.filter,
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
    filter_references(page) {
      this.$router.push({
        query: {
          filter: this.filter,
          page: page,
        },
      });
      this.index(page, this.filter, this.sort);
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
  },
};
</script>
<style scoped>
.max {
  color: #e04f1a;
}
</style>