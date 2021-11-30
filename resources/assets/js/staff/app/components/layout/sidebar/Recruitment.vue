<template>
  <div>
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
                  <span class="nav-main-link-name">Jobs</span>
              </a>
              <ul class="nav-main-submenu pt-0">
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'ApplicationsTable' }"
                      >
                          <i class="nav-main-link-icon fas fa-users"></i>
                          <span class="nav-main-link-name">Applications</span>
                      </router-link>
                  </li>
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'InterviewsTable' }"
                      >
                          <i class="nav-main-link-icon fas fa-user-clock"></i>
                          <span class="nav-main-link-name">Interviews</span>
                      </router-link>
                  </li>
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'ReferencesTable' }"
                      >
                          <i class="nav-main-link-icon fas fa-user-friends"></i>
                          <span class="nav-main-link-name">References</span>
                      </router-link>
                  </li>
                  </ul>
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
                  <span class="nav-main-link-name">New Starter Compliance</span>
              </a>
              <ul class="nav-main-submenu pt-0">
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'RetrievalsLog' }"
                      >
                          <i class="nav-main-link-icon fas fa-list"></i>
                          <span class="nav-main-link-name">App Retrievals</span>
                      </router-link>
                  </li>
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'ConversionTracker' }"
                      >
                          <i class="nav-main-link-icon fas fa-chart-pie"></i>
                          <span class="nav-main-link-name">Conversion Tracker</span>
                          <span class="badge badge-primary">NEW!</span>
                      </router-link>
                  </li>
                  <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'RecruitmentPipeline' }"
                      >
                          <i class="nav-main-link-icon fas fa-table"></i>
                          <span class="nav-main-link-name">Pipeline</span>
                      </router-link>
                  </li>
          <!--        <li class="nav-main-item">
                      <router-link
                          class="nav-main-link"
                          active-class="active"
                          :to="{ name: 'InitialEnquiryForm' }"
                      >
                          <i class="nav-main-link-icon fas fa-envelope-open-text"></i>
                          <span class="nav-main-link-name">Initial Enquiry</span>
                          <span class="badge badge-primary">NEW!</span>
                      </router-link>
                  </li> -->
</ul>
          </li>


      <!--  <li class="nav-main-item">
          <router-link
            class="nav-main-link"
            active-class="active"
            :to="{ name: 'MassEmails' }"
          >
            <i class="nav-main-link-icon fas fa-envelope-open-text"></i>
            <span class="nav-main-link-name">Mass Emails</span>
            <span class="badge badge-primary">NEW!</span>
          </router-link>
            <router-link
                class="nav-main-link"
                active-class="active"
                :to="{ name: 'MassSms' }"
            >
                <i class="nav-main-link-icon fas fa-sms"></i>
                <span class="nav-main-link-name">Mass SMS</span>
            </router-link>
        </li> -->
       <!--   <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="{ name: 'SmsTemplate' }"
              >
                  <i class="nav-main-link-icon fas fa-file-alt"></i>
                  <span class="nav-main-link-name">SMS Templates</span>
              </router-link>
          </li> -->
      <!--    <li class="nav-main-item">
              <router-link
                  class="nav-main-link"
                  active-class="active"
                  :to="{ name: 'smslog' }"
              >
                  <i class="nav-main-link-icon fas fa-file-contract"></i>
                  <span class="nav-main-link-name">SMS Log</span>
              </router-link>
          </li> -->
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
