<template>
  <div>
    <li class="nav-main-item open">
      <a
        class="nav-main-link nav-main-link-submenu"
        data-toggle="submenu"
        aria-haspopup="true"
        aria-expanded="open"
        href="#"
      >
        <i class="nav-main-link-icon fas fa-th-large"></i>
        <span class="nav-main-link-name">Dashboards</span>
      </a>
      <ul class="nav-main-submenu pt-0">
          <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="{ name: 'GoogleMap' }"
              >
                  <i class="nav-main-link-icon fas fa-map-marked-alt"></i>
                  <span class="nav-main-link-name">Maps</span>
              </router-link>
          </li>
          <li
              class="nav-main-item open"
              :class="current_path.includes('/application/') ? 'open' : null"
          >
              <a
                  class="nav-main-link nav-main-link-submenu"
                  data-toggle="submenu"
                  aria-haspopup="true"
                  aria-expanded="true"
                  href="#"
              >
                  <i class="nav-main-link-icon far fa-file-alt"></i>
                  <span class="nav-main-link-name">Recruitment</span>
              </a>
              <ul class="nav-main-submenu pt-0">
                  <li
                      class="nav-main-item"
                      :class="current_path.includes('/overall/') ? 'open' : null"
                  >
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'RecruitmentDashboard' }"
                      >
                          <i class="nav-main-link-icon fas fa-users"></i>
                          <span class="nav-main-link-name">Recruitment Stats</span>
                      </router-link>
                  </li>
                  <li
                      class="nav-main-item open"
                      :class="current_path.includes('/booking/') ? 'open' : null"
                  >
                      <a
                          class="nav-main-link nav-main-link-submenu"
                          data-toggle="submenu"
                          aria-haspopup="true"
                          aria-expanded="true"
                          href="#"
                      >
                          <i class="nav-main-link-icon fas fa-file-alt"></i>
                          <span class="nav-main-link-name">Compliance Stats</span>
                      </a>
                      <ul class="nav-main-submenu pt-0">
                          <li class="nav-main-item">
                              <router-link
                                  class="nav-main-link"
                                  active-class="active"
                                  :to="{ name: 'ComplianceDocuments' }"
                              >
                                  <i class="nav-main-link-icon fas fa-plus"></i>
                                  <span class="nav-main-link-name">Create</span>
                              </router-link>
                          </li>
                          <li class="nav-main-item">
                              <router-link
                                  class="nav-main-link"
                                  active-class="active"
                                  :to="{ name: 'ComplianceMatrix' }"
                              >
                                  <i class="nav-main-link-icon fas fa-table"></i>
                                  <span class="nav-main-link-name">Matrix</span>
                              </router-link>
                          </li>
                          <li class="nav-main-item">
                              <router-link
                                  class="nav-main-link"
                                  active-class="active"
                                  :to="{ name: 'ComplianceTracker' }"
                              >
                                  <i class="nav-main-link-icon fas fa-shoe-prints"></i>
                                  <span class="nav-main-link-name">Tracker</span>
                              </router-link>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'LiveStaffDashboard' }"
                      >
                          <i class="nav-main-link-icon fas fa-user-nurse"></i>
                          <span class="nav-main-link-name">Live Staff </span>
                      </router-link>
                  </li>
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'InitialEnquiryForm' }"
                      >
                          <i class="nav-main-link-icon fas fa-envelope-open-text"></i>
                          <span class="nav-main-link-name">Initial Enquiry</span>
                          <span class="badge badge-primary">NEW!</span>
                      </router-link>
                  </li>
                  <li
                      class="nav-main-item d-none d-md-block"
                      :class="current_path.includes('/carehome/') ? 'open' : null"
                  >
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'CarehomeDashboard' }"
                      >
                          <i class="nav-main-link-icon fas fa-home"></i>
                          <span class="nav-main-link-name">Carehome</span>
                      </router-link>
                  </li>
              </ul>
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
