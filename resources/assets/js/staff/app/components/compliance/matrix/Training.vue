<template>
  <div>
    <div class="row mt-4">
      <div class="col">
        <div class="table-responsive">
          <table
            class="table table-hover table-vcenter table-borderless table-striped js-appear-enabled animated fadeIn"
          >
            <thead class="thead-light">
              <tr>
                <th>Live Staff Name</th>
                <th class="text-center">{{ training[0].name }}</th>
                <th class="text-center">{{ training[1].name }}</th>
                <th class="text-center">{{ training[2].name }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr v-for="(training, key) in datatable.data" :key="key">
                <td>{{ training.first_name }} {{ training.last_name }}</td>
                <td
                  class="text-center"
                  :class="{
                    expired: training.training_1 == '0',
                    active: training.training_1 == '1',
                  }"
                >
                  <i class="fas fa-check-square fa-lg"></i>
                </td>
                <td
                  class="text-center"
                  :class="{
                    expired: training.training_2 == '0',
                    active: training.training_2 == '1',
                  }"
                >
                  <i class="fas fa-check-square fa-lg"></i>
                </td>
                <td
                  class="text-center"
                  :class="{
                    expired: training.training_3 == '0',
                    active: training.training_3 == '1',
                  }"
                >
                  <i class="fas fa-check-square fa-lg"></i>
                </td>
                <td class="text-center btn-td">
                  <div class="btn-group">
                    <router-link
                      class="btn btn-outline-dark btn-sm"
                      :to="
                        '/recruitment/applications/' +
                        training.applicant_id +
                        '/compliance'
                      "
                    >
                      GO
                      <i class="fas fa-arrow-right"></i>
                    </router-link>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>
          <pagination />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from "../../layout/tables/Pagination.vue";

export default {
  data: function () {
    return {
      routePrefix: "/api/compliance/matrix/training/",
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      training: {},
    };
  },
  components: {
    Pagination,
  },
  mounted() {
    if (this.$route.query.page) {
      this.datatable.current_page = this.$route.query.page;
    }
    this.index(this.datatable.current_page);
    this.getTraining();
  },
  methods: {
    index(page) {
      var route = this.routePrefix + "?";
      route += "page=" + page;
      this.loaded = false;
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
        .catch((err) => {
          console.log(err);
        });
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
    getTraining() {
      axios
        .get(this.routePrefix + "training")
        .then((response) => {
          this.training = response.data;
        })
        .catch(() => {
          console.log(err);
        });
    },
  },
};
</script>
<style lang="scss" scoped>
.expired {
  color: red;
}
.active {
  color: green;
}
</style>