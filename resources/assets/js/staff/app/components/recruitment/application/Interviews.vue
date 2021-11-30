<template>
  <div>
    <div class="row my-2">
      <div class="col-12">
        <div role="group" aria-label="1" class="btn-group btn-block">
          <button
            :class="{ active: tab == 'invites' }"
            @click="tab = 'invites'"
            class="btn btn-light"
          >
            <i class="fas fa-envelope-open-text pr-2"></i>Invites
          </button>
          <button
            :class="{ active: tab == 'questionnaire' }"
            @click="tab = 'questionnaire'"
            class="btn btn-light"
          >
            <i class="fas fa-pencil-alt pr-2"></i>Interview Notes
          </button>
        </div>
      </div>
    </div>
    <div v-if="tab == 'invites'">
      <invites />
    </div>
    <div v-if="tab == 'questionnaire'">
      <questionnaire />
    </div>
  </div>
</template>
<script>
import Invites from "./interview/Invites";
import Questionnaire from "./interview/Questionnaire";

export default {
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },
    user: function () {
      return this.$store.state.user;
    },
  },
  data: function () {
    return {
      tab: "invites",
    };
  },
  components: {
    Invites,
    Questionnaire,
  },
};
</script>
<style scoped>
.btn-light:hover {
  color: #212529;
  background-color: #e1effe;
  border-color: #e1effe;
}
button {
  border-bottom-left-radius: 0px !important;
  border-bottom-right-radius: 0px !important;
}
</style>