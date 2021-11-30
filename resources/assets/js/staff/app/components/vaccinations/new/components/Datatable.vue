<template>
  <div>
    <div class="table-responsive" v-if="loaded">
      <table
        class="
          table table-bordered table-stripped
          js-appear-enabled
          animated
          fadeIn
        "
      >
        <thead class="thead-light">
          <tr>
            <th class="d-table-cell d-lg-none">Vaccination</th>
            <th class="d-none d-lg-table-cell">Name</th>
            <th class="d-none d-lg-table-cell">Contact Details</th>
            <th class="d-none d-lg-table-cell">No. of Vaccinations</th>
            <th class="d-none d-lg-table-cell text-center"></th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <tr v-for="(data, key) in datatable.data" :key="key">
            <td class="d-table-cell d-lg-none">
              <div class="my-2">
                {{ data.application.first_name }}
                {{ data.application.last_name }}
              </div>
              <div class="my-2">
                {{ data.application.mobile }}
              </div>
              <div class="my-2">
                {{ data.application.email }}
              </div>
              <div class="my-2">
                {{ data.vaccination_count }}
              </div>
              <div class="my-2">
                <router-link
                  class="btn btn-secondary"
                  :to="'/vaccinations/list/' + data.staff_id"
                  >View Evidence</router-link
                >
              </div>
            </td>
            <td class="d-none d-lg-table-cell" v-if="data.application">
              <div class="my-2">
                {{ data.application.first_name }}
                {{ data.application.last_name }}
              </div>
            </td>
            <td
              class="d-none d-lg-table-cell text-truncate"
              v-if="data.application"
            >
              <div class="my-2">
                {{ data.application.mobile }}
              </div>
              <div
                class="d-none d-lg-table-cell my-2"
                v-if="data.application.email"
              >
                {{ data.application.email }}
              </div>
            </td>
            <td class="d-none d-lg-table-cell">{{ data.vaccination_count }}</td>
            <td class="d-none d-lg-table-cell text-center">
              <router-link
                class="btn btn-secondary"
                :to="'/vaccinations/list/' + data.staff_id"
                >View Evidence</router-link
              >
            </td>
          </tr>
        </tbody>
      </table>
      <div
        class="block-content block-content-full block-content-sm bg-body-light"
        v-if="datatable.data.length"
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
import Pagination from "../../../layout/tables/Pagination.vue";
import Loading from "../../../layout/tables/Loading.vue";

export default {
  components: {
    Pagination,
    Loading,
  },
  computed: {
    datatable: function () {
      return this.$store.state.vaccination.datatable;
    },
    filters: function () {
      return this.$store.state.vaccination.filters;
    },
    loaded: {
      get() {
        return this.$store.state.vaccination.loaded;
      },
      set(newVal) {
        return (this.$store.state.vaccination.loaded = newVal);
      },
    },
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
    this.index();
  },
  methods: {
    async index() {
      this.loaded = false;
      await this.$store
        .dispatch("vaccination/getVaccinations", {
          datatable: this.datatable,
          filters: this.filters,
        })
        .then((res) => {
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