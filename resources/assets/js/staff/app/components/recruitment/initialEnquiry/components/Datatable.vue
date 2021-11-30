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
        <thead class="thead-light" v-if="datatable.data.length > 0">
          <tr>
            <th>Position</th>
            <th>Name</th>
            <th>Contact Details</th>
            <th>Address Details</th>
            <th>Hours p/w</th>
            <th>Driver</th>
            <th>Source</th>
            <th>Referral</th>
            <th>Referred By</th>
          </tr>
        </thead>
        <tbody class="bg-white" v-if="datatable.data.length > 0">
          <tr v-for="(data, key) in datatable.data" :key="key">
            <td>{{ data.position }}</td>
            <td>{{ data.first_name }} {{ data.last_name }}</td>
            <td>
              <div class="mb-2">
                {{ data.telephone }}
              </div>
              <div class="mb-0">{{ data.email }}</div>
            </td>
            <td>
              <div class="mb-2">
                {{ data.address_line_1 }}
              </div>
              <div class="mb-2">
                {{ data.address_line_2 }}
              </div>
              <div class="mb-2">
                {{ data.city }}
              </div>
              <div class="mb-0">
                {{ data.postcode }}
              </div>
            </td>
            <td>{{ data.hours_pw }}</td>
            <td>{{ data.driving_licence }}</td>
            <td>{{ data.source }}</td>
            <td>{{ data.referral }}</td>
            <td>{{ data.username }}</td>
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
import Loading from "../../../layout/tables/Loading.vue";
import Pagination from "../../../layout/tables/Pagination.vue";

export default {
  components: {
    Loading,
    Pagination,
  },
  computed: {
    routePrefix: function () {
      return this.$parent.routePrefix;
    },
    datatable: function () {
      return this.$store.state.invites.datatable;
    },
  },
  data() {
    return {
      loaded: false,
    };
  },
  mounted() {
    this.index();
  },
  methods: {
    async index() {
      await this.$store.dispatch("invites/getInvites", this.datatable);
      this.loaded = true;
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