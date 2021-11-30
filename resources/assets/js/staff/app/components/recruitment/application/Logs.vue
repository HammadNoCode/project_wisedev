<template>
  <div>
    <div class="row my-2">
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
              <div class="col-md-3 col-12 my-auto">
                <span class="h5">Activity Logs</span>
              </div>
            </div>
            <div class="row">
              <div class="col">
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
                        <th>Staff</th>
                        <th>Message</th>
                        <th>Action Date</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                      <tr v-for="(log, key) in datatable.data" :key="key">
                        <td>{{ log.staff_name }}</td>
                        <td>{{ log.message }}</td>
                        <td>{{ log.action_date }}</td>
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
import Pagination from "../../layout/tables/Pagination.vue";
import Loading from "../../layout/tables/Loading.vue";

export default {
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },
    user: function () {
      return this.$store.state.user;
    },
    logsCount: function () {
      return _.size(this.datatable.data);
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/logs/",
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      loaded: false,
      disabled: false,
    };
  },
  components: {
    Pagination,
    Loading,
  },
  mounted() {
    if (this.$route.query.page) {
      this.datatable.current_page = this.$route.query.page;
    }
    this.index(this.datatable.current_page);
  },
  methods: {
    index(page) {
      var route = this.routePrefix + this.$route.params.id + "?";
      route += "page=" + page;
      (this.loaded = false),
        this.$router
          .push({
            query: {
              page: page,
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
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
  },
};
</script>
