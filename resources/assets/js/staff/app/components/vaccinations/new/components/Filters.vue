<template>
  <div class="row pb-3">
    <!-- <div class="col-md-3 col-12 ml-auto">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">No. Vaccination</span>
        </div>
        <select
          class="form-control selectpicker"
          v-model="filter.no_vaccinations"
        >
          <option value="all">All</option>
          <option value="1">One</option>
          <option value="2">Two</option>
        </select>
      </div>
    </div> -->
    <div class="col-md-3 col-12 ml-auto py-1">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Archived</span>
        </div>
        <select class="form-control selectpicker" v-model="filter.archived">
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
      </div>
    </div>
    <div class="col-md-6 col-12 input-group py-1">
      <div class="input-group-append">
        <span id="basic-addon1" class="input-group-text">
          <i class="fa fa-fw fa-search"></i>
        </span>
      </div>
      <input
        type="text"
        class="form-control"
        :placeholder="'Search last name...'"
        v-model="filter.search"
      />
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    filter: {
      get() {
        return this.$store.state.vaccination.filters;
      },
      set(newVal) {
        return (this.$store.state.vaccination.filters = newVal);
      },
    },
  },
};
</script>