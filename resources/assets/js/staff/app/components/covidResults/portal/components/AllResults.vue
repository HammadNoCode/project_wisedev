<template>
  <div class="content">
    <div class="row py-3">
      <div class="col-md-4 col-12 my-auto" v-if="datatable.data[0]">
        <h3>
          {{ datatable.data[0].first_name }} {{ datatable.data[0].last_name }}'s
          Covid-19 Results
        </h3>
      </div>
    </div>
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
            <thead class="thead-light">
              <tr>
                <th>Result</th>
                <th>Date</th>
                <th>Type</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr v-for="(test, key) in datatable.data" :key="key">
                <td
                  :class="{
                    negative: test.covid_result == 0,
                    positive: test.covid_result == 1,
                  }"
                >
                  {{ test.covid_result | covidResult }}
                </td>
                <td>{{ formatDate(test.test_date) }}</td>
                <td>
                  <div v-if="test.test_type != 'undefined'">
                    {{ test.test_type }}
                  </div>
                  <div v-if="test.test_type == 'undefined' || !test.test_type">
                    Not provided
                  </div>
                </td>
                <td>
                  <a
                    :href="
                      '/api/covid/portal/image/get/' +
                      test.staff_id +
                      '/' +
                      test.filename
                    "
                    target="_blank"
                    class="mb-2"
                  >
                    <i class="fas fa-file-download fa-xl mr-2"></i>Result
                  </a>
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
    <div>
      <div
        class="block-content block-content-full block-content-sm bg-body-light"
      >
        <div>
          <pagination />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Pagination from "../../../layout/tables/Pagination.vue";
import Loading from "../../../layout/tables/Loading.vue";

export default {
  data: function () {
    return {
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      loaded: false,
      today: moment(),
    };
  },
  computed: {
    staff_id: function () {
      return this.$route.params.id;
    },
    archived: function () {
      return this.$store.state.covid.archived;
    },
  },
  components: {
    Pagination,
    Loading,
  },
  mounted() {
    this.show(this.datatable.current_page);
  },
  methods: {
    show(page) {
      var route =
        "/api/covid/test/all/uploads?staff_id=" +
        this.staff_id +
        "&page=" +
        page +
        "&archived=" +
        this.archived;
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: page,
          },
        })
        .catch((error) => {
          console.log(error);
        });
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
        this.show(current_page);
      }
    },
    formatDate(date) {
      return moment(date).format("DD/MM/YYYY");
    },
  },
};
</script>
<style lang="scss" scoped>
.negative {
  color: green;
}

.positive {
  color: red;
}
</style>