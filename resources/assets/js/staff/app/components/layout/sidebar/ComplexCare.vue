<template>
  <div>
    <li class="nav-main-item">
      <a
        class="nav-main-link nav-main-link-submenu"
        data-toggle="submenu"
        aria-haspopup="true"
        aria-expanded="false"
        href="#"
      >
        <i class="nav-main-link-icon fas fa-hand-holding-medical"></i>
        <span class="nav-main-link-name">Complex care</span>
      </a>
      <ul class="nav-main-submenu pt-0">
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="{ name: 'SignOffForm' }"
          >
            <i class="nav-main-link-icon fas fa-file-upload"></i>
            <span class="nav-main-link-name">Sign Off Form</span>
          </router-link>
        </li>
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="{ name: 'UploadedForms' }"
          >
            <i class="nav-main-link-icon fas fa-list"></i>
            <span class="nav-main-link-name">Uploaded Forms</span>
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