<template>
  <div class="content">
    <div class="row py-3">
      <div class="col">
        <h3 class="mb-0">Covid Test Uploads</h3>
      </div>
    </div>

    <div class="py-3">
      <data-filter />
    </div>

    <div class="row">
      <div class="col">
        <datatable />
      </div>
    </div>
  </div>
</template>
<script>
import DataFilter from "./components/Filters.vue";
import Datatable from "./components/Datatable.vue";

export default {
  components: {
    DataFilter,
    Datatable,
  },
  data: function () {
    return {};
  },
};
</script>