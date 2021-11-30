<template>
  <div class="row pb-3">
    <div class="col-md-auto col ml-auto">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Position</span>
        </div>
        <select class="form-control selectpicker" v-model="filter.position">
          <option value="all">All</option>
          <option v-for="(position, key) in positions" :key="key">
            {{ position }}
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-auto col">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Period</span>
        </div>
        <select class="form-control selectpicker" v-model="filter.period">
          <option value="weekly">Weekly</option>
          <option value="monthly">Monthly</option>
          <option value="custom">Custom</option>
        </select>
      </div>
    </div>
    <div class="col-md-auto col" v-show="filter.period == 'custom'">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">From</span>
        </div>
        <input type="date" class="form-control" v-model="filter.date_from" />
      </div>
    </div>
    <div class="col-md-auto col" v-show="filter.period == 'custom'">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">To</span>
        </div>
        <input type="date" class="form-control" v-model="filter.date_to" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    positions: function () {
      return this.$store.state.reports.positions;
    },
    branch: function () {
      return this.$parent.branch;
    },
    filter: {
      get() {
        return this.$store.state.reports.filter;
      },
      set(newValue) {
        return (this.$store.state.reports.filter = newValue);
      },
    },
  },
};
</script>
