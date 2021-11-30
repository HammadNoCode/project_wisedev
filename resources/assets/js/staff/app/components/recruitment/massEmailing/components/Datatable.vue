<template>
  <div>
    <div
      class="block block-rounded block-bordered"
      style="height: 100%; width: 100%"
    >
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Email Recipients - {{ format_number(datatable.total) }}
        </h3>
        <div class="text-right">
          <button
            class="btn"
            @click="expandDatatable = true"
            v-show="expandDatatable == false"
          >
            Expand <i class="fas fa-plus fa-xl"></i>
          </button>
          <button
            class="btn"
            @click="expandDatatable = false"
            v-show="expandDatatable == true"
          >
            Minimise <i class="fas fa-minus fa-xl"></i>
          </button>
        </div>
      </div>
      <div class="block-content p-2" v-show="expandDatatable == true">
        <table class="table table-bordered table-vcenter table-stripped">
          <thead>
            <tr>
              <td>Name</td>
              <td>Email</td>
              <td>Role</td>
              <td>Branch</td>
              <td>Application Status</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, key) in datatable.data" :key="key">
              <td>{{ data.first_name }} {{ data.last_name }}</td>
              <td>{{ data.email }}</td>
              <td>{{ data.position }}</td>
              <td>{{ data.branch_id | branchName }}</td>
              <td>{{ data.status | applicationStatus }}</td>
            </tr>
          </tbody>
        </table>
        <pagination />
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from "../../../layout/tables/Pagination.vue";

export default {
  components: {
    Pagination,
  },
  computed: {
    datatable: {
      get() {
        return this.$store.state.emails.datatable;
      },
      set(newVal) {
        return (this.$store.state.emails.datatable = newVal);
      },
    },
    filters: {
      get() {
        return this.$store.state.emails.filters;
      },
      set(newVal) {
        return (this.$store.state.email.filters = newVal);
      },
    },
    format_number: function () {
      return this.$root.format_number;
    },
  },
  data: function () {
    return {
      expandDatatable: false,
    };
  },
  methods: {
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        // this.show(current_page);
        this.$store.dispatch("emails/getData", {
          page: current_page,
          filters: this.filters,
        });
      }
    },
  },
};
</script>
