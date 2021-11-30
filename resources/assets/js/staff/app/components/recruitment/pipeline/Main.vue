<template>
  <div class="content">
    <div class="row mb-4">
      <div class="col-md-10 col-12 my-auto">
        <h3 class="mb-0">Recruitment Pipeline</h3>
      </div>
      <div class="col-md-2 col-12 my-auto">
        <button
          type="button"
          class="btn btn btn-primary float-right"
          @click="showFilters = true"
          v-show="showFilters == false"
        >
          <i class="fa fa-plus mr-1"></i> Show Filters
        </button>
        <button
          type="button"
          class="btn btn btn-danger float-right"
          @click="showFilters = false"
          v-show="showFilters == true"
        >
          <i class="fa fa-times mr-1"></i> Hide Filters
        </button>
      </div>
    </div>

    <div v-show="showFilters == true">
      <data-filters />
    </div>

    <reporting-stats />

    <datatable />
  </div>
</template>
<script>
import DataFilters from "./components/Filters.vue";
import ReportingStats from "./components/Stats.vue";
import Datatable from "./components/Datatable.vue";

export default {
  components: {
    DataFilters,
    ReportingStats,
    Datatable,
  },
  computed: {
    showFilters: {
      get() {
        return this.$store.state.pipeline.showFilters;
      },
      set(newVal) {
        return (this.$store.state.pipeline.showFilters = newVal);
      },
    },
    loaded: {
      get() {
        return this.$store.state.pipeline.loaded;
      },
      set(newVal) {
        return (this.$store.state.pipeline.loaded = newVal);
      },
    },
  },
};
</script>