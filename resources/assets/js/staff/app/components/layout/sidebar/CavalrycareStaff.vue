<template>
  <div>
    <li class="nav-main-item">
      <a
        class="nav-main-link nav-main-link-submenu"
        data-toggle="submenu"
        aria-haspopup="true"
        aria-expanded="true"
        href="#"
      >
        <i class="nav-main-link-icon fas fa-user-nurse"></i>
        <span class="nav-main-link-name">Cavalry Staff</span>
        <span class="badge badge-primary">NEW!</span>
      </a>
      <ul class="nav-main-submenu pt-0">
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="{ name: 'StaffOnboarding' }"
          >
            <i class="nav-main-link-icon fas fa-sign-in-alt"></i>
            <span class="nav-main-link-name">Onboarding</span>
          </router-link>
        </li>
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="{ name: 'StaffOffboarding' }"
          >
            <i class="nav-main-link-icon fas fa-sign-out-alt"></i>
            <span class="nav-main-link-name">Offboarding</span>
          </router-link>
        </li>
      </ul>
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