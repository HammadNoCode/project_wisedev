<template>
  <div>
    <li
      class="nav-main-item open"
      :class="current_path.includes('/reporting/') ? 'open' : null"
    >
      <a
        class="nav-main-link nav-main-link-submenu"
        data-toggle="submenu"
        aria-haspopup="true"
        aria-expanded="true"
        href="#"
      >
        <i class="nav-main-link-icon fas fa-building"></i>
        <span class="nav-main-link-name">Branch Reporting</span>
        <span class="badge badge-warning">BETA!</span>
      </a>
      <ul class="nav-main-submenu pt-0">
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="'/branch/reporting/' + 'lancashire'"
          >
            <i class="nav-main-link-icon far fa-question-circle"></i>
            <span class="nav-main-link-name">Lancashire</span>
          </router-link>
        </li>
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="'/branch/reporting/' + 'warrington'"
          >
            <i class="nav-main-link-icon far fa-question-circle"></i>
            <span class="nav-main-link-name">Warrington</span>
          </router-link>
        </li>
        <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="'/branch/reporting/' + 'crewe'"
          >
            <i class="nav-main-link-icon far fa-question-circle"></i>
            <span class="nav-main-link-name">Crewe</span>
          </router-link>
        </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'liverpool'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Liverpool</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'manchester'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Manchester</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'leeds'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Leeds</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'shrewsbury'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Shrewsbury</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'chester'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Chester</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'permanent'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Permanent</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'complex care'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Complex Care</span>
              </router-link>
          </li>
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="'/branch/reporting/' + 'head office'"
              >
                  <i class="nav-main-link-icon far fa-question-circle"></i>
                  <span class="nav-main-link-name">Head Office</span>
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
