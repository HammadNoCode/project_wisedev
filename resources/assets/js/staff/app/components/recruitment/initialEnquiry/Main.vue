<template>
  <div class="content">
    <div class="row py-3">
      <div class="col">
        <h3 class="mb-0 py-3">Inital Enquiries</h3>
      </div>
      <div class="col-md-auto col-12 text-right my-auto">
        <button
          type="button"
          class="btn btn-primary"
          @click="showForm = true"
          v-show="showForm == false"
        >
          <i class="fa fa-plus mr-1"></i> Show Form
        </button>
        <button
          type="button"
          class="btn btn-danger"
          @click="showForm = false"
          v-show="showForm == true"
        >
          <i class="fa fa-times mr-1"></i> Hide Form
        </button>
      </div>
      <div class="col-md-auto col-12 text-right my-auto">
        <button
          type="button"
          class="btn btn-primary"
          @click="showLeaderboard = true"
          v-show="showLeaderboard == false"
        >
          <i class="fa fa-plus mr-1"></i> Show Leaderboard
        </button>
        <button
          type="button"
          class="btn btn-danger"
          @click="showLeaderboard = false"
          v-show="showLeaderboard == true"
        >
          <i class="fa fa-times mr-1"></i> Hide Leaderboard
        </button>
      </div>
    </div>

    <div v-show="showForm == true">
      <div class="js-appear-enabled animated fadeIn">
        <invite-form />
      </div>
    </div>

    <div v-show="showLeaderboard == true">
      <div class="js-appear-enabled animated fadeIn">
        <referrals-leaderboard />
      </div>
    </div>

    <div class="js-appear-enabled animated fadeIn">
      <reports />
    </div>

    <div class="row pb-2">
      <div class="col text-right">
        <!-- <button class="btn btn-info mr-3" disabled @click="text_all">
          {{ text_button }}
          <i class="fas fa-comment-dots pl-1"></i>
        </button> -->
        <button
          class="btn btn-secondary"
          :disabled="disabled"
          @click="email_all"
        >
          {{ email_button }}
          <i class="fas fa-paper-plane pl-1"></i>
        </button>
      </div>
    </div>

    <div class="js-appear-enabled animated fadeIn">
      <datatable />
    </div>
  </div>
</template>
<script>
import InviteForm from "./components/Form.vue";
import Reports from "./components/Reports.vue";
import ReferralsLeaderboard from "./components/leaderboard/Referrals.vue";
import Datatable from "./components/Datatable.vue";

export default {
  components: {
    InviteForm,
    Reports,
    ReferralsLeaderboard,
    Datatable,
  },
  data() {
    return {
      routePrefix: "/api/recruitment/enquiry-form/",
      showForm: false,
      showLeaderboard: false,
      email_button: "Email Reminder",
      text_button: "SMS Reminder",
      disabled: false,
    };
  },
  methods: {
    email_all() {
      this.disabled = true;
      this.email_button = "...";
      axios
        .post(this.routePrefix + "email/reminder")
        .then((response) => {
          this.$root.notification(response.data.message, "success");
          (this.disabled = false), (this.email_button = "Email Reminder");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    text_all() {
      this.disabled = true;
      this.text_button = "...";
      axios
        .post(this.routePrefix + "email/reminder")
        .then((response) => {
          this.$root.notification(response.data.message, "success");
          (this.disabled = false), (this.text_button = "SMS Reminder");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
  },
};
</script>