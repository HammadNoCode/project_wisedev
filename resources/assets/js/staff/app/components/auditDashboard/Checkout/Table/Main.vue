<template>
  <div class="content">
    <div class="row p-lg-5">
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
              <div class="col-9 my-auto">
                <span class="h5">{{ audit }} / Uploaded Audits</span>
              </div>
              <div class="col-3 input-group ml-auto" v-if="complianceManager">
                <select
                  class="form-control"
                  v-model="filter"
                  @change="filterFiles(1)"
                >
                  <option value="all">All</option>
                  <option
                    v-for="(author, key) in authors"
                    :key="key"
                    :value="author.id"
                  >
                    {{ author.name }}
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
                      table-striped
                      table-bordered
                      js-appear-enabled
                      animated
                      fadeIn
                    "
                  >
                    <thead class="thead-light">
                      <tr>
                        <th>Audit Name</th>
                        <th class="text-center">Views</th>
                        <th>Author</th>
                        <th class="text-center">Last Updated</th>
                        <th class="text-center">Score</th>
                        <th class="text-center" v-show="complianceManager">
                          Max Score
                        </th>
                        <th style="width: 125px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(file, key) in datatable.data" :key="key + 1">
                        <td style="text-decoration: underline">
                          <router-link
                            :to="{
                              path:
                                '/api/compliance-staff/checkout/upload/get/' +
                                file.filename,
                            }"
                            target="_blank"
                          >
                            {{ file.display_name }}
                          </router-link>
                        </td>
                        <td class="text-center">
                          <router-link
                            :to="{
                              path:
                                '/compliance/upload-table/' +
                                file.audit_id +
                                '/' +
                                file.id,
                            }"
                          >
                            {{ file.viewers_count }}
                          </router-link>
                        </td>
                        <td>{{ file.staff_id }}</td>
                        <td class="text-center">{{ file.updated_at }}</td>
                        <td
                          v-if="complianceManager"
                          class="text-center"
                          style="width: 80px"
                        >
                          <input
                            class="form-control"
                            type="text"
                            style="width: 55px"
                            v-model="file.score"
                            @change="update(file)"
                          />
                        </td>
                        <td v-if="complianceManager" class="text-center">
                          {{ file.audit.max_score }}
                        </td>
                        <td v-else class="text-center">
                          {{ file.score }} / {{ file.audit.max_score }}
                        </td>
                        <td class="text-center" style="width: 125px">
                          <button type="button" class="btn btn-sm btn-info">
                            <router-link
                              :to="{
                                path:
                                  '/compliance/upload-table/' +
                                  file.audit_id +
                                  '/' +
                                  file.id,
                              }"
                              class="text-white"
                            >
                              Views
                            </router-link>
                          </button>
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
<script>
import Pagination from "../../../layout/tables/Pagination.vue";
import Loading from "../../../layout/tables/Loading.vue";

export default {
  computed: {
    complianceManager: function () {
      return this.$store.state.user.compliance_manager == 1 ? true : false;
    },
    audit: function () {
      return this.$route.params.id;
    },
  },
  data: function () {
    return {
      routePrefix: "/api/compliance-staff/checkout/",
      files: {},
      datatable: {
        data: {},
        current_page: 1,
        per_page: 10,
        last_page: 0,
        total: 1,
      },
      authors: {},
      filter: "all",
      loaded: false,
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
    if (this.$route.query.filter) {
      this.filter = this.$route.query.filter;
    }
    this.show(this.datatable.current_page, this.filter);
    this.get_authors();
  },
  methods: {
    show(page, filter) {
      var route = this.routePrefix + "files/" + this.$route.params.id + "?";
      route += "&page=" + page;
      if (this.filter) {
        route += "&filter=" + this.filter;
      }
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: page,
            filter: this.filter,
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
        });
    },
    filterFiles(page) {
      this.$router.push({
        query: {
          filter: this.filter,
          page: page,
        },
      });
      this.show(page, this.filter);
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.show(current_page);
      }
    },
    update(file) {
      axios
        .patch(this.routePrefix + file.id, file)
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
    destroyAlert(id) {
      this.$swal
        .fire({
          title: "Remove File",
          text: "Are you sure you would like to remove this file?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#39AEAC",
          cancelButtonColor: "#495057",
          confirmButtonText: "Yes",
        })
        .then((result) => {
          if (result.value) {
            this.destroy(id);
          }
        });
    },
    destroy(id) {
      axios
        .delete(this.routePrefix + "file/" + id)
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
    get_authors() {
      axios
        .get("/api/compliance-staff/clinical")
        .then((response) => {
          this.authors = response.data;
        })
        .catch((error) => {});
    },
  },
};
</script>