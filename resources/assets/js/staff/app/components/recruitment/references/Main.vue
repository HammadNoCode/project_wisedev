<template>
  <div>
    <div class="row pb-3">
      <div
        class="col-auto ml-auto my-auto"
        v-show="application.contact_referee == 1"
      >
        <div class="alert alert-success mb-0" role="alert">
          <p class="mb-0">
            <i class="fas fa-check pr-1"></i>
            <b>Consent to contact referees autherised</b>
          </p>
        </div>
      </div>
      <div class="col-auto" v-show="application.contact_referee == 0">
        <div class="alert alert-danger" role="alert">
          <p class="mb-0">
            <i class="fas fa-check pr-1"></i>
            <b>Consent to contact referees denied</b>
          </p>
        </div>
      </div>
      <div class="col-auto my-auto">
        <button
          class="btn btn-primary btn-md"
          @click="showForm = true"
          v-show="showForm == false"
        >
          <i class="fas fa-plus pr-2"></i>Show Form
        </button>
        <button
          class="btn btn-danger btn-md"
          @click="showForm = false"
          v-show="showForm == true"
        >
          <i class="fas fa-minus pr-2"></i>Hide Form
        </button>
      </div>
    </div>
    <div class="row" v-if="showForm === true">
      <div class="col-12">
        <invite-form />
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <invites />
      </div>
    </div>
  </div>
</template>
<script>
import InviteForm from "./components/Form.vue";
import Invites from "./components/Invite.vue";

export default {
  components: {
    InviteForm,
    Invites,
  },
  computed: {
    application: function () {
      return this.$parent.applicant;
    },
    showForm: {
      get() {
        return this.$store.state.reference.showForm;
      },
      set(newVal) {
        return (this.$store.state.reference.showForm = newVal);
      },
    },
  },
};
</script>