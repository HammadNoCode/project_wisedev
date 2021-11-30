<template>
  <div class="content">
    <div class="row py-3">
      <div class="col">
        <h3 class="mb-0 py-3" v-if="branch">{{ branch | capitalize }}</h3>
      </div>
      <div class="col text-right my-auto">
        <button
          type="button"
          class="btn btn-primary"
          @click="showForm = true"
          v-show="showForm == false"
        >
          <i class="fa fa-plus mr-1"></i> Show Form
        </button>
        <button
          type="button"
          class="btn btn-danger"
          @click="showForm = false"
          v-show="showForm == true"
        >
          <i class="fa fa-times mr-1"></i> Hide Form
        </button>
      </div>
    </div>

    <div v-show="showForm == true">
      <div class="js-appear-enabled animated fadeIn">
        <data-input-form />
      </div>
    </div>

    <div class="js-appear-enabled animated fadeIn">
      <data-filters />
    </div>

    <div class="js-appear-enabled animated faedIn">
      <data-stats />
    </div>

    <div class="js-appear-enabled animated fadeIn">
      <pie-chart />
    </div>
  </div>
</template>
<script>
import DataInputForm from "./components/Form.vue";
import DataFilters from "./components/Filters.vue";
import DataStats from "./components/Stats.vue";
import PieChart from "./components/PieChart.vue";

export default {
  components: {
    DataInputForm,
    DataFilters,
    DataStats,
    PieChart,
  },
  computed: {
    branch: function () {
      return this.$route.params.branch;
    },
  },
  data: function () {
    return {
      showForm: false,
    };
  },
};
</script>