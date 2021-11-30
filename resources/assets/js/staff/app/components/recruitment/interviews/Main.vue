<template>
  <div>
    <div class="row py-3">
      <div class="col-12">
        <invite-form />
      </div>
    </div>
    <div class="row py-3">
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