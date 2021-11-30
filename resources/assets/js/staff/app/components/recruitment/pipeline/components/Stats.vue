<template>
  <div>
    <div class="row mb-3">
      <div class="col-12 col-md-6">
        <a
          class="block block-rounded text-center block-fx-pop"
          :class="{ 'block-mode-loading': !loaded }"
        >
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <h2
                class="text-black"
                style="font-size: 30px"
                v-if="datatable.total && loaded"
              >
                {{ format_number(datatable.total) }}
              </h2>
              <div class="font-w600 mt-3 text-uppercase text-black">
                Applicant
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6">
        <a
          class="block block-rounded text-center block-fx-pop"
          :class="{ 'block-mode-loading': !loaded }"
        >
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <h2
                class="text-black"
                style="font-size: 30px"
                v-if="datatable.data && loaded"
              >
                {{ format_number(hours) }}
              </h2>
              <div class="font-w600 mt-3 text-uppercase text-black">
                Hours p/w
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    datatable: function () {
      return this.$store.state.pipeline.datatable;
    },
    filter: function () {
      return this.$store.state.pipeline.filters;
    },
    hours: function () {
      return this.$store.state.pipeline.hours;
    },
    format_number: function () {
      return this.$root.format_number;
    },
    loaded: function () {
      return this.$parent.loaded;
    },
  },

  mounted() {
    this.getStats();
  },
  methods: {
    async getStats() {
      await this.$store.dispatch("pipeline/getStats", {
        filters: this.filter,
      });
    },
  },
};
</script>