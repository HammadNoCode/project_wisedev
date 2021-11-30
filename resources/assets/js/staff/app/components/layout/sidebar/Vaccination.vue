<template>
  <div>
    <li class="nav-main-item open">
      <router-link
        class="nav-main-link"
        active-class="active"
        :to="{ name: 'VaccinationList' }"
      >
        <i class="nav-main-link-icon fas fa-syringe"></i>
        <span class="nav-main-link-name">Vaccinations</span>
      </router-link>
    </li>
  </div>
</template>
<script>
export default {
  computed: {
    manager: function () {
      return this.$store.state.user.manager == 1 ? true : false;
    },
    department: function () {
      return this.$store.state.user.department_array;
    },
    unread_messages: function () {
      return this.$store.state.inbox;
    },
    store_admin: function () {
      return this.$store.state.store_admin;
    },
    current_path: function () {
      return window.location.href;
    },
    production: function () {
      return window.location.href.includes("cavalrycare.co.uk") ? true : false;
    },
  },
};
</script>
