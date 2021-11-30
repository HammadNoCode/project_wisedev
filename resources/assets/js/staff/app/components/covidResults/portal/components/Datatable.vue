<template>
  <div>
    <div class="table-responsive" v-if="loaded">
      <table
        class="
          table table-hover table-bordered table-striped
          js-appear-enabled
          animated
          fadeIn
        "
      >
        <thead class="thead-light" v-if="datatable.data">
          <tr>
            <th>Name</th>
            <th>Result</th>
            <th>Test Date</th>
            <th>Upload Date</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody class="bg-white" v-if="datatable.data">
          <tr v-for="(data, key) in datatable.data" :key="key">
            <td>{{ data.first_name }} {{ data.last_name }}</td>
            <td
              :class="{
                negative: data.covid_result == 0,
                positive: data.covid_result == 1,
              }"
            >
              {{ data.covid_result | covidResult }}
            </td>
            <td v-if="data">{{ data.test_date }}</td>
            <td v-if="data">{{ data.created_at }}</td>
            <td class="text-center btn-td">
              <div
                class="btn-group"
                v-if="new Date(data.test_date) < week && data.contacted == 1"
              >
                <button
                  class="btn btn-sm btn-info"
                  @click="reminder(data.staff_id)"
                >
                  Remind
                </button>
              </div>
              <div v-else>In-date</div>
            </td>
            <td class="text-center">
              <router-link
                class="btn btn-sm btn-info"
                :to="'/covid/results/' + data.staff_id"
              >
                All Tests
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
      <div
        class="block-content block-content-full block-content-sm bg-body-light"
        v-if="datatable.data.length > 0"
      >
        <div>
          <pagination />
        </div>
      </div>
    </div>
    <div>
      <loading />
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
    filter: function () {
      return this.$store.state.covid.filter;
    },
    search: function () {
      return this.$store.state.covid.search;
    },
    archived: function () {
      return this.$store.state.covid.archived;
    },
    loaded: {
      get() {
        return this.$store.state.covid.loaded;
      },
      set(newVal) {
        return (this.$store.state.covid.loaded = newVal);
      },
    },
    week: function () {
      var today = new Date();
      var data = today.setDate(today.getDate() - 7);
      var date = new Date(parseInt(data));
      return date;
    },
  },
  data: function () {
    return {
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
    };
  },
  watch: {
    filter: function (newVal) {
      this.index();
    },
    search: function (newVal) {
      this.index();
    },
    archived: function (newVal) {
      this.index();
    },
  },
  mounted() {
    this.index(this.datatable.current_page);
  },
  methods: {
    index(page) {
      var route = "/api/covid/test/uploads";
      route += "?page=" + page;
      route += "&filter=" + this.filter;
      route += "&search=" + this.search;
      route += "&archived=" + this.archived;
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: page,
            filter: this.filter,
            search: this.search,
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
    formatDate(date) {
      return moment(date).format("DD/MM/YYYY");
    },
    reminder(id) {
      axios
        .post("/api/covid/test/reminder/" + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
  },
};
</script>
<style scoped>
.positive {
  color: green;
}
.negative {
  color: red;
}
</style>