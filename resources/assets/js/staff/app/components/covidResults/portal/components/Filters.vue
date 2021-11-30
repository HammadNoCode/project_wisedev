<template>
  <div class="row pb-3">
    <div class="col-md-3 col-12 ml-auto">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Archived</span>
        </div>
        <select class="form-control selectpicker" v-model="archived">
          <option value="no">No</option>
          <option value="yes">Yes</option>
        </select>
      </div>
    </div>
    <div class="col-md-3 col-12 ml-auto">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Result</span>
        </div>
        <select class="form-control selectpicker" v-model="filter">
          <option value="all">All</option>
          <option value="1">Positive</option>
          <option value="0">Negative</option>
        </select>
      </div>
    </div>
    <div class="col-md-6 col-12 input-group">
      <div class="input-group-append">
        <span id="basic-addon1" class="input-group-text">
          <i class="fa fa-fw fa-search"></i>
        </span>
      </div>
      <input
        type="text"
        class="form-control"
        :placeholder="'Search last name...'"
        v-model="search"
      />
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    filter: {
      get() {
        return this.$store.state.covid.filter;
      },
      set(newVal) {
        return (this.$store.state.covid.filter = newVal);
      },
    },
    search: {
      get() {
        return this.$store.state.covid.search;
      },
      set(newVal) {
        return (this.$store.state.covid.search = newVal);
      },
    },
    archived: {
      get() {
        return this.$store.state.covid.archived;
      },
      set(newVal) {
        return (this.$store.state.covid.archived = newVal);
      },
    },
  },
};
</script>