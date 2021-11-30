<template>
  <div>
    <div class="col-12 py-2">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Application Status</span>
        </div>
        <select class="form-control selectpicker" v-model="filters.status">
          <option value="all">All</option>
          <option v-for="(status, key) in statuses" :key="key">
            {{ status }}
          </option>
        </select>
      </div>
    </div>
    <div class="col-12 py-2">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Branch</span>
        </div>
        <select class="form-control selectpicker" v-model="filters.branch">
          <option value="all">All</option>
          <option v-for="(branch, key) in branches" :key="key + 1">
            {{ branch }}
          </option>
        </select>
      </div>
    </div>
    <div class="col-12 py-2">
      <div class="input-group">
        <div class="input-group-append">
          <span class="input-group-text">Role</span>
        </div>
        <select class="form-control selectpicker" v-model="filters.role">
          <option value="all">All</option>
          <option v-for="(role, key) in roles" :key="key + 2">
            {{ role }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    filters: {
      get() {
        return this.$store.state.emails.filters;
      },
      set(newVal) {
        return (this.$store.state.email.filters = newVal);
      },
    },
    statuses: function () {
      return this.$store.state.emails.statuses;
    },
    branches: function () {
      return this.$store.state.emails.branches;
    },
    roles: function () {
      return this.$store.state.emails.roles;
    },
  },
};
</script>