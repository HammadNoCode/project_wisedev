<template>
  <div class="content">
    <div class="row py-3">
      <div class="col-12">
        <h3 class="mb-0">Application Status Conversion Tracker</h3>
      </div>
    </div>
    <div class="row py-3">
      <div class="col-md-6 col-12">
        <live />
      </div>
      <div class="col-md-6 col-12">
        <accepted />
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <pie-chart />
      </div>
    </div>
  </div>
</template>
<script>
import PieChart from "./components/PieChart.vue";
import Live from "./components/Live.vue";
import Accepted from "./components/Accepted.vue";

export default {
  components: {
    PieChart,
    Live,
    Accepted,
  },
};
</script>