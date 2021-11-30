<template>
  <nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
      <div class="content-header bg-white-10">
        <router-link class="font-w600 font-size-lg text-white" to="/">
          <span class="smini-visible">
            <span class="text-white-75">C</span>
            <span class="text-white">C</span>
          </span>
          <span class="smini-hidden" style="z-indez: 1032">
            <span class="text-white-75">Cavalry</span>
            <span class="text-white">Healthcare</span>
          </span>
        </router-link>
        <div>
          <a
            class="d-lg-none text-white ml-2"
            data-toggle="layout"
            data-action="sidebar_close"
            href="javascript:void(0)"
          >
            <i class="fa fa-times-circle"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="content-side content-side-full side-scroll js-sidebar-scroll">
      <ul class="nav-main">
        <recruitment />
      <!--  <covid />
        <vaccination />
        <google-map /> -->
        <dashboards />
        <carehome />

        <div v-show="!production">
          <branch-reporting />
        </div>
      <!--  <compliance /> -->
       <!-- <live-staff /> -->
        <!-- <competencies /> -->
        <!-- <auditDashboard /> -->
        <events />
        <productivity />
        <management />
        <support />
          <ExistingStaff />
         <settings />
        <div v-show="!production">
          <staff-onboarding />
        </div>
      </ul>
    </div>
  </nav>
</template>
<script>
import Business from "./sidebar/BusinessDev";
import LiveStaff from "./sidebar/LiveStaff";
import Compliance from "./sidebar/Compliance";
import AuditDashboard from "./sidebar/AuditDashboard";
import Dashboards from "./sidebar/Dashboards";
import GoogleMap from "./sidebar/Map";
import Events from "./sidebar/Events";
import Management from "./sidebar/Management";
import Productivity from "./sidebar/Productivity";
import Recruitment from "./sidebar/Recruitment";
import Covid from "./sidebar/Covid.vue";
import Carehome from "./sidebar/Carehome";
import Competencies from "./sidebar/ComplexCare";
import Support from "./sidebar/Support";
import BranchReporting from "./sidebar/BranchReporting.vue";
import Vaccination from "./sidebar/Vaccination.vue";
import StaffOnboarding from "./sidebar/CavalrycareStaff.vue";
import Settings from "./sidebar/settings.vue";
import ExistingStaff from "./sidebar/ExistingStaff.vue";

export default {
  computed: {
    production: function () {
      return window.location.href.includes("cavalrycare.co.uk") ? true : false;
    },
  },
  components: {
    AuditDashboard,
    Business,
    LiveStaff,
    Compliance,
    Dashboards,
    GoogleMap,
    Events,
    Management,
    Productivity,
    Recruitment,
    Covid,
    Carehome,
    Competencies,
    Support,
    BranchReporting,
    Vaccination,
    StaffOnboarding,
    Settings,
      ExistingStaff,
  },
};
</script>
,
    Vaccination
