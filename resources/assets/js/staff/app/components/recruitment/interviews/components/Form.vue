<template>
  <div>
    <div
      class="
        js-wizard-simple
        block block-rounded
        js-appear-enabled
        animated
        fadeIn
      "
    >
      <div class="block-content block-content-full tab-content">
        <form class="interview-request-form">
          <div class="row">
            <div class="col-12 my-auto">
              <span class="h6">Contact Details</span>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-md my-auto">
              <label>Email</label>
              <div class="h5">{{ applicant.email }}</div>
            </div>
            <div class="col-md my-auto">
              <label>Mobile</label>
              <div class="h5">{{ applicant.mobile }}</div>
            </div>
            <div
              class="col-md-auto my-auto"
              v-show="applicant.declaration == null"
            >
              <button
                class="btn btn-info float-right"
                type="button"
                name="button"
                @click="updateContacted(applicant)"
              >
                <i class="fas fa-phone mr-1"></i> Phoned
              </button>
            </div>
            <div class="col-md-auto my-auto">
              <button
                class="btn btn-success float-right"
                type="button"
                name="button"
                @click="store"
              >
                <i class="fas fa-paper-plane mr-1"></i> Arrange Interview
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Datepicker from "vuejs-datepicker";
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";

export default {
  components: {
    Datepicker,
    VueTimepicker,
  },
};
</script>